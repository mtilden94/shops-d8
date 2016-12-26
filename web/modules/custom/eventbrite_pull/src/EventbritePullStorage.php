<?php

namespace Drupal\eventbrite_pull;
use Drupal\Core\Database\Connection;
use Drupal\node\NodeInterface;

/**
 * Handles CRUD operations to {eventbrite_pull} table.
 */
class EventbritePullStorage implements EventbritePullStorageInterface {

  /**
   * The active database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a EventbritePullStorage object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The current database connection.
   */
  function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public function create(NodeInterface $node) {
    $this->database->insert('eventbrite_pull')
      ->fields(array(
        'nid' => $node->id(),
        'eid' => $node->eventbrite->id,
        'created' => $node->eventbrite->created,
        'changed' => $node->eventbrite->changed
      ))
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function read($eid) {
    return $this->database->select('eventbrite_pull', 'e')
      ->fields('e')
      ->condition('e.eid', $eid)
      ->execute()
      ->fetchObject();
  }

  /**
   * {@inheritdoc}
   */
  public function update(NodeInterface $node) {
    return $this->database->update('eventbrite_pull')
      ->fields(array(
        'changed' => $node->eventbrite->changed
      ))
      ->condition('nid', $node->id())
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function delete(NodeInterface $node) {
    return $this->database->delete('eventbrite_pull')
      ->condition('nid', $node->id())
      ->execute();
  }
}
