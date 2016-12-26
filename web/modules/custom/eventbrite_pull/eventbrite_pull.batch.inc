<?php

use \Drupal\node\Entity\Node;

function eventbrite_pull_node_save($event, $published = 0, $uid = 0, &$context) {
  $ignore = false;
  $createdDate = new DateTime($event->created);
  $changedDate = new DateTime($event->changed);

  $is_event = \Drupal::service('eventbrite_pull.storage')->read($event->id);

  if(!$is_event) {
    $node = Node::create([
      'type' => 'event',
      'title' => $event->name->text,
      'status' => $published,
      'uid' => $uid,
    ]);

    $context['results']['message_log'][] = '<span style="color: green">Create</span>: <b>'. $event->name->text .'</b>';

  } else if($is_event->changed != $changedDate->getTimestamp()){
    $node = Node::load($is_event->nid);

    $context['results']['message_log'][] = '<span style="color: orange">Update</span>: <b>'. $event->name->text .'</b>';
  } else {
    $context['results']['message_log'][] = '<span style="color: grey">Ignore</span>: <b>'. $event->name->text .'</b>';
    $ignore = true;
  }

  if(!$ignore) {

    $node->eventbrite = (object) [
      'id' => $event->id,
      'created' => $createdDate->getTimestamp(),
      'changed' => $changedDate->getTimestamp()
    ];

    // Set date
    $node->set('field_event_date', [
      'value' => $event->start->local,
      'end_value' => $event->end->local
    ]);

    $node->set('field_register_link', [
      'uri' => $event->url,
      'title' => 'Register Now'
    ]);

    $file = eventbrite_pull_create_image_file($event);
    if ($file) {
      $node->set('field_featured_image', [
        'target_id' => $file->id()
      ]);
    }

    $node->set('body', [
      'value' => check_markup($event->description->text, 'basic_html'),
      'summary' => NULL,
      'format' => 'basic_html',
      'safe_value' => check_markup($event->description->text, 'basic_html'),
    ]);

    $node->save();

    if ($file) {
      \Drupal::service('file.usage')
        ->add($file, 'file', 'node', $node->id());
    }
  }

  $context['message'] = implode("<br/>", $context['results']['message_log'] + ['Processed...']);
}

function eventbrite_pull_create_image_file($event) {
  if(!empty($event->logo)) {
    $path = file_default_scheme().'://eventbrite/image/';

    if(\Drupal::service('file_system')->mkdir($path)) {
      file_prepare_directory($path, FILE_CREATE_DIRECTORY);
    }

    $url = $event->logo->original->url;
    $parse_url = parse_url($url);
    $filename = md5(time()) .'_'. basename(urldecode($parse_url['path']));

    $data = file_get_contents($url);
    $file = file_save_data($data, $path . $filename, FILE_EXISTS_RENAME);

    return $file;
  }

  return FALSE;
}