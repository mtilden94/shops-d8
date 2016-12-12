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
  public function build() {
    $block = array(
      '#cache' => array(
        'contexts' => array('url'),
      )
    );

    $markup = '';

    $markup = 'W W W blocks';

    $block['#markup'] = $markup;


    return $block;
  }
}