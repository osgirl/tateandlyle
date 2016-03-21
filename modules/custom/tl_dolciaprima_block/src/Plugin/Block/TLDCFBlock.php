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
        'contact_form' => 'marketing',
      ));
    $form = \Drupal::service('entity.form_builder')->getForm($message);
    $form['#prefix'] = '<div class="header-text">' . \Drupal::config('tl_dolciaprima_block.settings')->get('header_text') . '</div>';
    $form['#suffix'] = '<a href="#" class="btn-close-form-submit-thank-you-message btn-close-form hide-text">Close</a><div class="form-submit-thank-you-message">' . \Drupal::config('tl_dolciaprima_block.settings')->get('submit_thank_you_message') . '</div>';
    return array(
      '#markup' => drupal_render($form),
    );
  }

}
