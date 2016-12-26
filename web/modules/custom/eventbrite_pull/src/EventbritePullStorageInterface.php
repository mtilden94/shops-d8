<?php

namespace Drupal\eventbrite_pull;

use Drupal\node\NodeInterface;


/**
 * Handles CRUD operations to {forum_index} table.
 */
interface EventbritePullStorageInterface {

  public function create(NodeInterface $node);

  public function read($eid);

  public function update(NodeInterface $node);

  public function delete(NodeInterface $node);
}
