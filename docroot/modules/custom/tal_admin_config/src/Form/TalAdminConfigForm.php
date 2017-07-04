<?php

namespace Drupal\tal_admin_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class TalAdminConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tal_admin_config';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'tal_admin_config.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = \Drupal::config('tal_admin_config.settings');
    $values = $config->getRawData();
    $form['tai_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Trends and Insight settings'),
      '#open' => FALSE,
    ];
    $form['tai_settings']['tai_title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('tai_title'),
    );
    $form['tai_settings']['tai_summary'] = array(
      '#type' => 'text_format',
      '#title' => $this->t('Summary'),
      '#format' => 'rich_text',
      '#default_value' => $config->get('tai_summary'),
    );
    $form['tai_settings']['tai_read_more'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Read more link'),
      '#default_value' => $config->get('tai_read_more'),
    );
    $form['tai_settings']['tai_link'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Link'),
      '#default_value' => $config->get('tai_link'),
    );
    // Press Release Boilerplate settings.
    $form['tal_pr_boilerplate_settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Press Release Boilerplate Settings'),
      '#open' => FALSE,
    ];
    $form['tal_pr_boilerplate_settings']['boilerplate_content'] = array(
      '#type' => 'text_format',
      '#title' => $this->t('Boilerplate Content'),
      '#format' => 'rich_text',
      '#default_value' => $config->get('boilerplate_content'),
    );
    // Job search reference URL.
    $form['job_search'] = [
      '#type' => 'details',
      '#title' => $this->t('Careers settings.'),
      '#open' => FALSE,
    ];
    $form['job_search']['job_search_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Job search URL.'),
      '#description' => $this->t('Redirect URL for Job search block.'),
      '#default_value' => $config->get('job_search_url'),
    ];
    // Web service point.
    $form['web_service'] = [
      '#type' => 'details',
      '#title' => $this->t('Web service configuration'),
      '#open' => FALSE,
    ];
    $form['web_service']['web_service_on_off'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Web service on'),
      '#description' => $this->t('Check to use the web service.'),
      '#default_value' => $config->get('web_service_on_off'),
    ];
    // Salesforce OID.
    $form['webform_config_values'] = [
      '#type' => 'details',
      '#title' => $this->t('Webform configuration values'),
      '#open' => FALSE,
    ];
    $form['webform_config_values']['salesforce_oid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Salesforce OID'),
      '#default_value' => $config->get('salesforce_oid'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('tal_admin_config.settings');
    $config->set('tai_title', $form_state->getValue('tai_title'));
    $config->set('job_search_url', $form_state->getValue('job_search_url'));
    $values = $form_state->getValues();
    $tai_summary = $values['tai_summary']['value'];
    $boilerplate_content = $values['boilerplate_content']['value'];
    $config->set('tai_summary', $tai_summary);
    $config->set('tai_read_more', $form_state->getValue('tai_read_more'));
    $config->set('tai_link', $form_state->getValue('tai_link'));
    $config->set('boilerplate_content', $boilerplate_content)->save();
    $config->set('web_service_on_off', $form_state->getValue('web_service_on_off'))->save();
    $config->set('salesforce_oid', $form_state->getValue('salesforce_oid'))->save();

    parent::submitForm($form, $form_state);
  }

}
