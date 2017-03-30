<?php

namespace Drupal\tal_articles\Form;

use \Drupal\Core\Form\FormBase;

use \Drupal\Core\Form\FormStateInterface;

use \Drupal\Component\Utility\UrlHelper;

/**
 * {@inheritdoc}
 */
class ArticleSearchFilterForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tal-article-search-filter';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Get current query parameters.
    $path = \Drupal::request()->getUri();
    $parameters = UrlHelper::parse($path);

    $form['search_filter']['keyword'] = array(
      '#type' => 'textfield',
      '#title' => t('Search the news:'),
      '#default_value' => isset($parameters['query']['title']) ? $parameters['query']['title'] : '',
      '#attributes' => array(
        'id' => 'tal-search-filter',
      ),
    );

    $form['search_filter']['save'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Search'),
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

    if (!empty($form_state->getValue('keyword'))) {
      $parameters['query']['title'] = $form_state->getValue('keyword');
      $parameters['query']['body_value'] = $form_state->getValue('keyword');
    }
    $routing_name = \Drupal::routeMatch()->getRouteName();
    $parameters['query']['arg_0'] = \Drupal::routeMatch()->getParameter('arg_0');

    $form_state->setRedirect($routing_name, UrlHelper::filterQueryParameters($parameters['query']));
  }

}
