<?php
/**
 * @file
 * Contains \Drupal\current_active_submenu\Plugin\Block\CurrentActiveSubmenu.
 */
namespace Drupal\current_active_submenu\Plugin\Block;
use Drupal\Core\Block\BlockBase;
/**
 * @Block(
 *   id = "current_active_submenu",
 *   admin_label = @Translation("Current active submenu"),
 *   category = @Translation("Blocks")
 * )
 */
class CurrentActiveSubmenu extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $menu_tree = \Drupal::menuTree();
    $menu_name = 'main';

    // Build the typical default set of menu tree parameters.
    $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name);

    $trail = $parameters->activeTrail;
    end($trail);
    $plagin_id = prev($trail);

    $parameters->setRoot($plagin_id);

    // Load the tree based on this set of parameters.
    $tree = $menu_tree->load($menu_name, $parameters);

    $markup = "";
    if(isset($tree[$plagin_id])) {

      $title = $tree[$plagin_id]->link->getTitle();
      $subtree = $tree[$plagin_id]->subtree;

      $manipulators = array(
        ['callable' => 'menu.default_tree_manipulators:checkAccess'],
        ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort']
      );

      $subtree = $menu_tree->transform($subtree, $manipulators);

      // Finally, build a renderable array from the transformed tree.
      $menu = $menu_tree->build($subtree);

      $markup .= '<h2 class="title">' .$title. '</h2>';
      $markup .= drupal_render($menu);
    }

    return array(
      '#markup' => $markup,
      '#cache' => array(
        'contexts' => array('url'),
      )
    );
  }
}