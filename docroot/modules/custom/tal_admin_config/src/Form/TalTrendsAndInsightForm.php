<?php

namespace Drupal\tal_admin_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class TalTrendsAndInsightForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tal_admin_trend_and_insights';
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
      '#format' => 'advanced_rich_text',
      '#title' => $this->t('Summary'),
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
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')->getEditable('tal_admin_config.settings');
    $config->set('tai_title', $form_state->getValue('tai_title'));
    $config->set('tai_summary', $form_state->getValue('tai_summary'));
    $config->set('tai_read_more', $form_state->getValue('tai_read_more'));
    $config->set('tai_link', $form_state->getValue('tai_link'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
