<?php

namespace Drupal\tal_search\Plugin\Block;

use Drupal\block\BlockForm;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides continue search block for search page.
 *
 * @Block(
 *   id = "continue_or_browse",
 *   admin_label = @Translation("Continue Search or Browse Ingredient"),
 *   category = @Translation("Blocks")
 * )
 */
class ContinueSearchBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#title'] = $this->label();
    $build['#label_display'] = $this->configuration['label_display'];
    $build['#block_description'] = $this->configuration['block_description'];
    $build['#link_text'] = $this->configuration['link_text'];
    $build['#link_url'] = $this->configuration['link_url'];

    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['block_description'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Block description'),
      '#default_value' => isset($config['block_description']) ? $config['block_description'] : $this->t('View the full ingredient results in our ingredient finder.'),
      '#required' => TRUE,
    );
    $form['link_text'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Link text'),
      '#default_value' => isset($config['link_text']) ? $config['link_text'] : $this->t('All matching ingredients'),
      '#required' => TRUE,
    );
    $form['link_url'] = array(
      '#type' => 'checkbox',
      '#description' => $this->t('If checked the url of the link will be on Browse "Ingredient Finder(/search/ingredients)" page. Else on the "Ingredient results(/search/ingredients/results)" page.'),
      '#title' => $this->t('Link url'),
      '#default_value' => isset($config['link_url']) ? $config['link_url'] : 0,
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $form['visibility']['request_path']['#value'] = '/search';
    $this->configuration['block_description'] = $form_state->getValue('block_description');
    $this->configuration['link_text'] = $form_state->getValue('link_text');
    $this->configuration['link_url'] = $form_state->getValue('link_url');
  }

}
