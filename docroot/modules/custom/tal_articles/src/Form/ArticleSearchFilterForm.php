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
   * Get the "Publishing date" array for press release and news content.
   *
   * @return array
   *   Returns the array for year from date 'field_date' field.
   */
  public function getOptionsYear() {
    $query = \Drupal::database()->select('node__field_date', 'date');
    $query->condition('date.bundle', ['company_story', 'press_release'], 'IN');
    $query->distinct();
    $query->addExpression("date_format(str_to_date(field_date_value, '%Y-%m-%d'), '%Y')", 'year');
    $query->orderBy('year', 'DESC');
    $result = $query->execute()->fetchAllKeyed(0, 0);

    return $result;
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
      '#title' => t('Search for news'),
      '#default_value' => isset($parameters['query']['title']) ? $parameters['query']['title'] : '',
      '#attributes' => array(
        'id' => 'tal-search-filter',
        'placeholder' => t('Enter keywords'),
      ),
    );

    $form['search_filter']['save'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    );
    $form['search_filter']['year'] = array(
      '#type' => 'select',
      '#title' => t('Filter by year'),
      '#options' => $this->getOptionsYear(),
      '#empty_option' => '-- Show All --',
      '#default_value' => isset($parameters['query']['year']) ? $parameters['query']['year'] : '',
      '#attributes' => array(
        'id' => 'tal-search-year-filter',
        'class' => array('select-year-press-article'),
      ),
    );
    $form['#attached']['library'][] = 'tal_articles/tal_articles_search';
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Reset the query parameters based on the value selected
    // and redirect to the search result page.
    $path = \Drupal::request()->getUri();
    $parameters = UrlHelper::parse($path);

    if (!empty($form_state->getValue('keyword'))) {
      $parameters['query']['title'] = $form_state->getValue('keyword');
      $parameters['query']['news'] = $form_state->getValue('keyword');
    }
    else {
      unset($parameters['query']['title']);
      unset($parameters['query']['news']);
    }
    if (!empty($form_state->getValue('year'))) {
      $parameters['query']['year'] = $form_state->getValue('year');
    }
    else {
      unset($parameters['query']['year']);
    }
    if (isset($parameters['query']['page'])) {
      unset($parameters['query']['page']);
    }
    $routing_name = \Drupal::routeMatch()->getRouteName();
    $parameters['query']['arg_0'] = \Drupal::routeMatch()->getParameter('arg_0');

    $form_state->setRedirect($routing_name, UrlHelper::filterQueryParameters($parameters['query']));
  }

}
