<?php

/**
 * @file
 * Contains \Drupal\token_login\Routing\RouteSubscriber.
 */

namespace Drupal\token_login\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteSubscriber.
 *
 * @package Drupal\token_login\Routing
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {
  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Use the password reset form for the login page.
    if ($route = $collection->get('user.login')) {
      $route->addDefaults(array('_form' => '\Drupal\token_login\Form\TokenLoginForm'));
    }
    // Always deny access to '/user/logout'.
    // Note that the second parameter of setRequirement() is a string.
    if ($route = $collection->get('user.pass')) {
      $route->setRequirement('_access', 'FALSE');
    }
  }

}
