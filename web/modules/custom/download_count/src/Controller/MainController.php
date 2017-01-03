<?php

namespace Drupal\download_count\Controller;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\NodeInterface;

class MainController extends ControllerBase {
  protected $status = 0;

  public function add(NodeInterface $node) {
    $new = 0;
    $field = $node->get('field_current_downloads');

    if($field) {
      $this->status = 1;

      $new = (int)$field->value;
      $field->set(0, ++$new);

      $node->save();
    }

    // Process $params...
    return new JsonResponse([
      'status' => $this->status,
      'value' => $new,
    ]);
  }
}