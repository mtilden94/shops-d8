<?php

namespace Drupal\eventbrite_pull;

class BatchPullEvent {

  protected $operations;
  protected $cron = FALSE;
  protected $config;

  function __construct() {
    $this->config = \Drupal::config('eventbrite_pull.settings');
    $this->operations = $this->getOperations();
  }

  public function setRunCron() {
    $this->cron = TRUE;
  }

  public function start() {
    $batch = array(
      'operations' => $this->operations,
      'title' => 'Pull Event',
      'file' => drupal_get_path('module', 'eventbrite_pull') . '/eventbrite_pull.batch.inc',
    );

    batch_set($batch);

    if($this->cron) {
      $batch = &batch_get();
      $batch['progressive'] = FALSE;
      batch_process();
    }
  }

  protected function getOperations() {
    $operations = [];
    $node_published = $this->config->get('node_published');

    $eventbrite = new Eventbrite($this->config->get('oauth_token'));
    $data = $eventbrite->get('organizers/' . $this->config->get('organizer_id') . '/events', [
      'status' => 'live'
    ]);

    if($data) {
      foreach ($data->events as $event) {
        $operations[] = ['eventbrite_pull_node_save', [$event, $node_published, 0]];
      }
    }

    return $operations;
  }
}