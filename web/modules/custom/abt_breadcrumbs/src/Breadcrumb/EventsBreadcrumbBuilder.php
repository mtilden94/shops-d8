<?php

namespace Drupal\abt_breadcrumbs\Breadcrumb;

use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\node\NodeInterface;
use Drupal\taxonomy\Entity\Term;

class EventsBreadcrumbBuilder implements BreadcrumbBuilderInterface {
  use StringTranslationTrait;


  /**
   * @inheritdoc
   */
  public function applies(RouteMatchInterface $route_match) {
    // This breadcrumb apply only for all custom node types
    $parameters = $route_match->getParameters()->all();
    if (isset($parameters['node'])) {
      return $parameters['node']->getType() == 'event';
    }

    return FALSE;
  }

  /**
   * @inheritdoc
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addLink(Link::createFromRoute($this->t('Home'), '<front>'));
    $breadcrumb->addLink(Link::createFromRoute($this->t('Events'), 'view.events.page_1'));

    $parameters = $route_match->getParameters()->all();
    if (!empty($parameters['node']->get('title')->getValue())) {
      $title = $parameters['node']->get('title')->getValue();
      $breadcrumb->addLink(Link::createFromRoute($title[0]['value'], '<none>'));
    }
    $breadcrumb->addCacheContexts(array('url'));

    return $breadcrumb;
  }
}