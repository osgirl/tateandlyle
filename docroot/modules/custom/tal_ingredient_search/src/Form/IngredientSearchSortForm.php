<?php

namespace Drupal\tal_ingredient_search\Form;

use \Drupal\Core\Form\FormBase;

use \Drupal\Core\Form\FormStateInterface;

use \Drupal\Component\Utility\UrlHelper;

/**
 * {@inheritdoc}
 */
class IngredientSearchSortForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tal-search-sort-by';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get current query parameters.
    $path = \Drupal::request()->getUri();
    $parameters = UrlHelper::parse($path);

    $form['sort_by'] = array(
      '#type' => 'select',
      '#title' => t('Sort by:'),
      '#options' => array(
        'created' => t('Published on'),
        'title' => t('Alphabetical order'),
        'search_api_relevance' => t('Best Match'),
      ),
      '#default_value' => isset($parameters['query']['sort_by']) ? $parameters['query']['sort_by'] : '',
      '#attributes' => array(
        'onchange' => 'jQuery(\'#' . $this->getFormId() . '\').submit();',
      ),
    );

    $form['save'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#attributes' => array('class' => array('hidden')),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Reset the query parameters based on the value selected
    // and rediect to the serch result page.
    $path = \Drupal::request()->getUri();
    $parameters = UrlHelper::parse($path);
    $parameters['query']['sort_by'] = $form_state->getValue('sort_by');
    $routing_name = \Drupal::routeMatch()->getRouteName();
    $form_state->setRedirect($routing_name, $parameters['query']);
  }

}
