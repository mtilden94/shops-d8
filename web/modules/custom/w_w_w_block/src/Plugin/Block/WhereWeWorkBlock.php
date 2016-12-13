<?php
/**
 * @file
 * Contains \Drupal\current_active_submenu\Plugin\Block\CurrentActiveSubmenu.
 */
namespace Drupal\w_w_w_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "www_block",
 *   admin_label = @Translation("Where We Work"),
 *   category = @Translation("Blocks")
 * )
 */
class WhereWeWorkBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  private $continent_vid = 'continent';

  public function build() {
    $block = array(
      '#cache' => array(
        'contexts' => array('url'),
      )
    );

    $markup = '';

    $markup = 'W W W blocks';


    $node_storage = \Drupal::entityTypeManager()->getStorage('node');
    $q = $node_storage->getQuery();
    $nids = $q->condition('type', 'countries')
      ->condition('status', 1)
      ->groupBy('field_continent')
      ->execute();

    $nodes = $node_storage->loadMultiple($nids);

    $continents = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($this->continent_vid, 0, 1, TRUE);

    $data = array();
    foreach ($continents as $continent) {
      $data[$continent->id()] = array(
        'term' => array(
          'name' => str_replace(array('and', '/'), array('&', ' & '), $continent->getName()),
          'image' => $continent->field_image->getValue(),
        ),
        'nodes'=> array(),
      );
    }

    foreach ($nodes as $node) {
      $term_id = $node->field_continent->getValue()[0]['target_id'];

      $data[$term_id]['nodes'][$node->id()] = array(
        'nid' => $node->id(),
        'title' => $node->getTitle(),
        'link' => $node->toLink(),
      );
    }

    $block = array(
      'www_block' => array(
        '#theme' => 'www_block',
        '#data' => $data,
      ),
      '#cache' => array(
        'contexts' => array('url'),
      )
    );

    return $block;
  }
}