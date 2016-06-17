<?php
/**
 * @file
 * Contains \Drupal\clientside_validation_jquery\Plugin\CvValidator\Form.
 */

namespace Drupal\clientside_validation_jquery\Plugin\CvValidator;

use Drupal\clientside_validation\CvValidatorBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'form' validator.
 *
 * @CvValidator(
 *   id = "form",
 *   name = @Translation("Form"),
 *   supports = {
 *     "types" = {
 *       "form"
 *     }
 *   },
 *   attached = {
 *     "library" = {
 *       "clientside_validation_jquery/cv.jquery.validate"
 *     }
 *   }
 * )
 */
class Form extends CvValidatorBase {

  /**
   * {@inheritdoc}
   */
  protected function getRules($element, FormStateInterface $form_state) {
    // We need this, otherwise our js files aren't attached.
    return [
      'messages' => ['form' => ''],
    ];
  }

}
