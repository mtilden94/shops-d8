<?php

namespace Drupal\w_w_w_block\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;

class WhereWeWorkMenuLinkDerivative extends DeriverBase implements ContainerDeriverInterface {

  private $continent_vid = 'continent';

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static();
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $links = array();

    // Get all nodes of type countries.
    $nodeQuery = \Drupal::entityQuery('node');
    $nodeQuery->condition('type', 'countries');
    $nodeQuery->condition('status', TRUE);
    $ids = $nodeQuery->execute();
    $ids = array_values($ids);

    $nodes = Node::loadMultiple($ids);

    $continents = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($this->continent_vid, 0, 1, TRUE);

    foreach ($continents as $continent) {
      $links['www_menulink_continent_' . $continent->id()] = [
          'title' => $continent->getName(),
          'menu_name' => 'main',
          'route_name' => '<nolink>',
        ] + $base_plugin_definition;

//      $links['www_menulink_continent_' . $continent->id()]['id'] = 'id_www_continent_'.$continent->id();
    }


    /*foreach($nodes as $node) {
      $links['www_menulink_' . $node->id()] = [
          'title' => $node->get('title')->getString(),
          'menu_name' => 'main',
          'route_name' => 'entity.node.canonical',
          //@TODO setup parent from continent
          //'parent' => 'www_menulink_continent_' . $node->field_continent->getValue()[0]['target_id'],
          'route_parameters' => [
            'node' => $node->id(),
          ],
        ] + $base_plugin_definition;
    }*/

    return $links;
  }
}