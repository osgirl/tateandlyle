<?php

/**
 * @file
 * Contains \Drupal\tl_prod_login\Routing\RouteSubscriber.
 */

namespace Drupal\tl_prod_login\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RouteSubscriber.
 *
 * @package Drupal\tl_prod_login\Routing
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {
  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Use the password reset form for the login page.
    if ($route = $collection->get('user.login')) {
      $route->setDefaults(array(
        '_form' => '',
        '_controller' => '\Drupal\tl_prod_login\Controller\UserLoginController::loginPage',
        '_title' => 'Log in via SSO',
      ));
    }

    // Deny access to the password reset page.
    if ($route = $collection->get('user.pass')) {
      $route->setRequirement('_access', 'FALSE');
    }

    // Deny access to the password reset page.
    if ($route = $collection->get('user.reset')) {
      $route->setRequirement('_access', 'FALSE');
    }
  }
}
