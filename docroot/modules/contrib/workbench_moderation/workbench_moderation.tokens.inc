<?php

use Drupal\Core\Render\BubbleableMetadata;
use Drupal\node\NodeInterface;
use Drupal\workbench_moderation\ModerationInformationInterface;

/**
 * Implements hook_token_info().
 */
function workbench_moderation_token_info() {
  $node = [];

  $node['latest_revision'] = [
    'name' => t('Latest revision'),
    'description' => t('Tokens relating to the latest revision of the node'),
    'type' => 'node',
  ];

  $node['latest_revision_author'] = [
    'name' => t('Latest Revision Author'),
    'description' => t('Tokens relating to the latest revision author of the node'),
    'type' => 'user',
  ];

  return [
    'tokens' => ['node' => $node],
  ];
}

/**
 * Implements hook_tokens().
 */
function workbench_moderation_tokens($type, $tokens, array $data, array $options, BubbleableMetadata $metadata) {
  $replacements = [];

  if ($type !== 'node' || empty($data['node'])) {
    return $replacements;
  }

  $node = $data['node'];
  if (!$node instanceof NodeInterface) {
    return $replacements;
  }

  /** @var ModerationInformationInterface $moderation_info */
  $moderation_info = \Drupal::service('workbench_moderation.moderation_information');
  if (!$moderation_info->isModeratableEntity($node)) {
    return $replacements;
  }

  // Fetch used tokens for the latest revision.
  $token = \Drupal::token();
  $latest_revision_tokens = $token->findWithPrefix($tokens, 'latest_revision');
  if ($latest_revision_tokens) {
    // Load latest revision.
    $revision = $moderation_info->getLatestRevision($node->getEntityTypeId(), $node->id());

    // Add replacements for the latest revision.
    $latest_revision_data = ['node' => $revision];
    $replacements += $token->generate('node', $latest_revision_tokens, $latest_revision_data, $options, $metadata);
  }

  // Fetch used tokens for the latest revision author.
  $latest_revision_author_tokens = $token->findWithPrefix($tokens, 'latest_revision_author');
  if ($latest_revision_author_tokens) {
    // Load latest revision author.
    $revision = $moderation_info->getLatestRevision($node->getEntityTypeId(), $node->id());
    $revision_author = $revision->getRevisionUser();

    // Add replacements for the latest revision author.
    $latest_revision_author_data = ['user' => $revision_author];
    $replacements += $token->generate('user', $latest_revision_author_tokens, $latest_revision_author_data, $options, $metadata);
  }

  return $replacements;
}
