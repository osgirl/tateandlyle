<?php

namespace Drupal\tal_search\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides continue search block for search page.
 *
 * @Block(
 *   id = "job_search",
 *   admin_label = @Translation("Job Search Block"),
 *   category = @Translation("Blocks")
 * )
 */
class JobSearchBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\tal_search\Form\TalJobSearch');
    return $form;
  }

}
