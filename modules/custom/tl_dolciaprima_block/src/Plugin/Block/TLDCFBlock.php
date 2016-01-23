<?php
/**
 * @file
 * A custom block for the Tate & Lyle Dolciaprima site.
 */

namespace Drupal\tl_dolciaprima_block\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom block with the T&L contact form.
 *
 * @Block(
 *   id = "tl_dolciaprima_block",
 *   admin_label = @Translation("Tate & Lyle Dolciaprima Contact Form"),
 *   category = @Translation("Blocks")
 * )
 */
class TLDCFBlock extends BlockBase {
  /**
   * Provides block content.
   */
  public function build() {
      $contact_form = \Drupal::entityManager()
        ->getStorage('contact_form')
        ->load('marketing');

      $message = \Drupal::entityManager()
        ->getStorage('contact_message')
        ->create(array(
        'contact_form' => 'marketing'
      ));

      $form = \Drupal::service('entity.form_builder')->getForm($message);
    return array(
      '#markup' => drupal_render($form),
    );
  }

}
