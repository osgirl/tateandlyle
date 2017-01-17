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
      '#open' => TRUE,
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
      '#open' => TRUE,
    ];
    $form['tal_pr_boilerplate_settings']['boilerplate_content'] = array(
      '#type' => 'text_format',
      '#title' => $this->t('Boilerplate Content'),
      '#format' => 'rich_text',
      '#default_value' => $config->get('boilerplate_content'),
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('tal_admin_config.settings');
    $config->set('tai_title', $form_state->getValue('tai_title'));
    $values = $form_state->getValues();
    $tai_summary = $values['tai_summary']['value'];
    $boilerplate_content = $values['boilerplate_content']['value'];
    $config->set('tai_summary', $tai_summary);
    $config->set('tai_read_more', $form_state->getValue('tai_read_more'));
    $config->set('tai_link', $form_state->getValue('tai_link'));
    $config->set('boilerplate_content', $boilerplate_content)
      ->save();

    parent::submitForm($form, $form_state);
  }

}
