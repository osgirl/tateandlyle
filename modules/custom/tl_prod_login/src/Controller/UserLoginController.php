<?php

/**
 * @file
 * Contains \Drupal\tl_prod_login\Controller\UserLoginController.
 */

namespace Drupal\tl_prod_login\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

/**
 * Class UserLoginController.
 *
 * @package Drupal\tl_prod_login\Controller
 */
class UserLoginController extends ControllerBase {
  /**
   * Loginpage.
   *
   * @return string
   *   Return Hello string.
   */
  public function loginPage() {
    $build = array();
    // Return without executing if the functionality is not enabled.
    if (!\Drupal::config('simplesamlphp_auth.settings')->get('activate')) {
      $build['simplesamlphp_auth_inactive'] = array(
        '#markup' => $this->t('SSO is not enabled.'),
      );
      return $build;
    }

    $label = \Drupal::config('simplesamlphp_auth.settings')->get('login_link_display_name');

    $build['simplesamlphp_auth_login_link'] = array(
      '#markup' => \Drupal::l($label, Url::fromRoute('simplesamlphp_auth.saml_login', array(), array(
        'attributes' => array(
          'class' => array('simplesamlphp-auth-login-link'),
        ),
      ))),
    );

    return $build;

  }

}
