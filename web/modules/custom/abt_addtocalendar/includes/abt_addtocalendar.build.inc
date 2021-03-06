<?php

/**
 * @file
 * Contains preprocess helper function.
 */

use \Drupal\Core\Entity\Entity\EntityViewDisplay;
use \Drupal\Core\Datetime\DrupalDateTime;

/**
 * Helper function to preprocess datetime field.
 */
function _abt_addtocalendar_preprocess_field(&$variables) {
  $entity = $variables['element']['#object'];
  $view_mode = $variables['element']['#view_mode'];
  $field_name = $variables['element']['#field_name'];

  // get the field formatter settings...
  $entity_display = EntityViewDisplay::collectRenderDisplay($entity, $view_mode);
  $field_display = $entity_display->getComponent($field_name);

  if (!empty($field_display['third_party_settings']['abt_addtocalendar'])) {
    $build['addtocalendar'] = [];
    $settings = $field_display['third_party_settings']['abt_addtocalendar'];
    $style = [];
    if (isset($settings['addtocalendar_show']) && $settings['addtocalendar_show']) {
      $token_service = \Drupal::token();
      $langcode = $entity->language()->getId();
      $token_options = ['langcode' => $langcode, 'callback' => '', 'clear' => TRUE];
      $timeZone = date_default_timezone_get();
      $date = new DrupalDateTime(preg_replace('/T/', ' ', $entity->{$field_name}->value), 'UTC');
      $build['addtocalendar']['atc_date_start'] = [
        '#type' => 'html_tag',
        '#tag' => 'var',
        '#value' => $date->format('m/d/Y g:ia', ['timezone' => $timeZone]),
        '#attributes' => [
          'class' => 'atc_date_start',
        ],
      ];
      $info = [
        'atc_date_end',
        'atc_title',
        'atc_description',
        'atc_location',
        'atc_organizer',
        'atc_organizer_email',
      ];
      foreach ($info as $value) {
        switch ($settings['addtocalendar_settings'][$value]['field']) {
          case 'token':
            $class_value = $settings['addtocalendar_settings'][$value]['tokenized'];
            $class_value = $token_service->replace($class_value, array('node' => $entity), $token_options);
            break;

          case 'title':
            $class_value = $entity->getTitle();
            break;

          default:
            $field = $settings['addtocalendar_settings'][$value]['field'];
            $class_value = strip_tags($entity->{$field}->value);
            break;
        }
        $build['addtocalendar'][$value] = [
          '#type' => 'html_tag',
          '#tag' => 'var',
          '#value' => $class_value,
          '#attributes' => [
            'class' => $value,
          ],
        ];
      }

      $date = new DrupalDateTime(preg_replace('/T/', ' ', $build['addtocalendar']['atc_date_end']['#value']), 'UTC');
      $build['addtocalendar']['atc_date_end']['#value'] = $date->format('m/d/Y g:ia', ['timezone' => $timeZone]);

      $build['addtocalendar']['atc_timezone'] = [
        '#type' => 'html_tag',
        '#tag' => 'var',
        '#value' => $timeZone,
        '#attributes' => [
          'class' => 'atc_timezone',
        ],
      ];

      $build['addtocalendar']['atc_privacy'] = [
        '#type' => 'html_tag',
        '#tag' => 'var',
        '#value' => $settings['addtocalendar_settings']['atc_privacy'],
        '#attributes' => [
          'class' => 'atc_privacy',
        ],
      ];

      $build['addtocalendar'] = [
        '#type' => 'html_tag',
        '#tag' => 'span',
        '#value' => '<var class="atc_event">' . render($build['addtocalendar']) . '</var>',
        '#attributes' => [
          'class' => [
            'addtocalendar',
          ],
        ],
      ];

      if ($settings['addtocalendar_settings']['data_calendars']) {
        $value = '';
        foreach ($settings['addtocalendar_settings']['data_calendars'] as $key => $set) {
          if ($set) {
            $value .= $key . ', ';
          }
        }
        if ($value) {
          $build['addtocalendar']['#attributes']['data-calendars'] = $value;
        }
      }

      $build['addtocalendar']['#attributes']['data-secure'] = $settings['addtocalendar_settings']['data_secure'];

    }
    $variables['items'][0]['content']['#button'] = render($build['addtocalendar']);
    $variables['#attached']['library'][] = 'abt_addtocalendar/base';
  }
}
