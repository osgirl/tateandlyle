<?php

namespace Drupal\tal_ingredient_search\Form;

use \Drupal\Core\Form\FormBase;

use \Drupal\Core\Form\FormStateInterface;

use \Drupal\Core\Link;
use \Drupal\Core\Url;

/**
 * {@inheritdoc}
 */
class TalSearchfinderForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tal-search-finder-form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['keyword'] = array(
      '#type' => 'textfield',
      '#default_value' => "Search",
      '#attributes' => array(
        'class' => array('search'),
        'plceholder' => 'Search',
      ),
    );

    $form['search'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Search'),
      '#attributes' => array(),
    );

    $form['#action'] = '/search/ingredients/results';
    $url = Url::fromUserInput('/search/ingredients');
    $advance_link = Link::fromTextAndUrl('Advanced search filters', $url)->toString();
    $form['#prefix'] = '<div class="footer-search-finder-block">';
    $form['#suffix'] = '<div class="advance-search">' . $advance_link . '</div></div>';
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $parameters['query']['s'] = $form_state->getValue('keyword');
    $parameters['query']['sort_by'] = 'search_api_relevance';
    $routing_name = \Drupal::routeMatch()->getRouteName();
    $form_state->setRedirect($routing_name, $parameters['query']);
  }

}
