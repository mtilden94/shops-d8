<?php

namespace Drupal\abt_breadcrumbs\Breadcrumb;

use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\node\NodeInterface;
use Drupal\taxonomy\Entity\Term;

class OurPeopleBreadcrumbBuilder implements BreadcrumbBuilderInterface {
  use StringTranslationTrait;


  /**
   * @inheritdoc
   */
  public function applies(RouteMatchInterface $route_match) {
    // This breadcrumb apply only for all custom node types
    $parameters = $route_match->getParameters()->all();
    if (isset($parameters['node'])) {
      return $parameters['node']->getType() == 'our_people';
    }

    return false;
  }

  /**
   * @inheritdoc
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addLink(Link::createFromRoute($this->t('Home'), '<front>'));
    $breadcrumb->addLink(Link::createFromRoute($this->t('Our people'), 'view.our_people.page_1'));

    $parameters = $route_match->getParameters()->all();
    if (!empty($parameters['node']->get('field_staff_type')->target_id)) {
      $term = Term::load($parameters['node']->get('field_staff_type')->target_id);

      $breadcrumb->addLink(Link::fromTextAndUrl($term->getName(), $term->toUrl()));
    }
    dsm($breadcrumb);
    return $breadcrumb;
  }
}