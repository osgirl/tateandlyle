<?php

namespace Drupal\tal_search\Form;

use Drupal\Core\Form\FormBase;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Drupal\Core\Form\FormStateInterface;

/**
 * Implements the ajax demo form controller.
 *
 * This example demonstrates using ajax callbacks to populate the options of a
 * color select element dynamically based on the value selected in another
 * select element in the form.
 *
 * @see \Drupal\Core\Form\FormBase
 * @see \Drupal\Core\Form\ConfigFormBase
 */
class TalJobSearch extends FormBase {

  /**
   * Form for language selection options.
   *
   * @param array $form
   *   Form to render Language selection dropdown.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   FormState object.
   *
   * @return array
   *   Renderable form array.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Generate a unique salt for placeholder id.
    $form['job'] = [
      '#type' => 'textfield',
      '#description' => t('Job role or skill e.g. finance, research, logistics'),
      '#attributes' => array(
        'placeholder' => t('Job, roll or skill'),
      ),
      '#weight' => 0,
    ];
    $form['job_actions'] = [
      '#type' => 'actions',
      '#weight' => 1,
    ];
    $form['submit_job'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Search'),
      '#button_type' => 'primary',
      '#suffix' => '<span class="in__label">in</span>',
    );
    $form['location'] = [
      '#type' => 'textfield',
      '#description' => t('Location e.g. UK, London, Latin America'),
      '#attributes' => array(
        'placeholder' => t('Location'),
      ),
      '#weight' => 2,
    ];
    $form['location_actions'] = [
      '#type' => 'actions',
      '#weight' => 3,
    ];
    $form['location_actions']['submit_location'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Search'),
      '#button_type' => 'primary',
    );
    $form['actions'] = [
      '#type' => 'actions',
      '#weight' => 4,
    ];
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Find a job'),
      '#weight' => 7,
      '#attributes' => array(
        'class' => array(
          'btn-white',
          'btn',
        ),
      ),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {

    return 'tal_job_search';
  }

  /**
   * Final submit handler.
   *
   * Reports what values were finally set.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = \Drupal::config('tal_admin_config.settings');
    $url = $config->get('job_search_url');
    if (!empty($url)) {
      $params = array();

      // Add job/skills parameters.
      if (!empty($job = $form_state->getValue('job'))) {
        $params['q'] = $job;
      }
      // Add location parameters.
      if (!empty($location = $form_state->getValue('location'))) {
        $params['locationsearch'] = $location;
      }
      // Build query and create url.
      if (!empty($params)) {
        $query = http_build_query($params);
        $url = !empty($query) ? $url . $query : $url;
      }
      $response = new RedirectResponse($url);
      $response->send();
    }
  }

}
