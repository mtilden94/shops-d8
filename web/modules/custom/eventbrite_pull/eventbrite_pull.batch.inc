<?php

use Drupal\eventbrite_pull\Eventbrite;

function eventbrite_pull_get_batch_operations() {
  $config = \Drupal::config('eventbrite_pull.settings')->getRawData();

  dpm($config);
  /*$eventbrite = new Eventbrite('VV5E5YJU6MWUFKDZY6JW');
  $eventbrite->get('organizers/'. 8460585411 .'/events');*/

}