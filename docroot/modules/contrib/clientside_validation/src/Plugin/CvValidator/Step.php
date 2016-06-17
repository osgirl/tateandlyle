<?php
/**
 * @file
 * Contains \Drupal\clientside_validation\Plugin\CvValidator\Step.
 */

namespace Drupal\clientside_validation\Plugin\CvValidator;

use Drupal\clientside_validation\CvValidatorBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'step' validator.
 *
 * @CvValidator(
 *   id = "step",
 *   name = @Translation("Step"),
 *   supports = {
 *     "attributes" = {"step"}
 *   }
 * )
 */
class Step extends CvValidatorBase {

  /**
   * {@inheritdoc}
   */
  protected function getRules($element, FormStateInterface $form_state) {
    if ($element['#step'] !== 'any') {
      if (isset($element['#min'])) {
        return [
          'messages' => [
            'step' => $this->t('The value in @title has to be greater than @min by steps of @step.', ['@title' => $element['#title'], '@step' => $element['#step'], '@min' => $element['#min']]),
          ],
        ];
      }
      return [
        'messages' => [
          'step' => $this->t('The value in @title has to be divisible by @step.', ['@title' => $element['#title'], '@step' => $element['#step']]),
        ],
      ];
    }
  }

}
