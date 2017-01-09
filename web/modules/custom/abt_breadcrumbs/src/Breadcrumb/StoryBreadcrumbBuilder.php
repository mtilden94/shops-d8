<?php

namespace Drupal\abt_breadcrumbs\Breadcrumb;

use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Link;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Component\Utility\Unicode;

class StoryBreadcrumbBuilder implements BreadcrumbBuilderInterface {
  use StringTranslationTrait;


  /**
   * @inheritdoc
   */
  public function applies(RouteMatchInterface $route_match) {
    // This breadcrumb apply only for all custom node types
    $parameters = $route_match->getParameters()->all();
    if (isset($parameters['node'])) {
      return $parameters['node']->getType() == 'story';
    }

    return FALSE;
  }

  /**
   * @inheritdoc
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addLink(Link::createFromRoute($this->t('Home'), '<front>'));
    $breadcrumb->addLink(Link::createFromRoute($this->t('What We Do'), '<none>'));
    $breadcrumb->addLink(Link::createFromRoute($this->t('Success Stories'), '<none>'));

    $parameters = $route_match->getParameters()->all();
    if (!empty($parameters['node']->get('title')->getValue())) {

      $title = $parameters['node']->get('title')->getValue();

      $breadcrumb->addLink(Link::createFromRoute(Unicode::truncate($title[0]['value'], 40, TRUE, TRUE), '<none>'));
    }
    $breadcrumb->addCacheContexts(array('url'));

    return $breadcrumb;
  }
}