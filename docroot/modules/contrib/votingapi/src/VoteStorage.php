<?php

namespace Drupal\votingapi;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\votingapi\Entity\Vote;

/**
 * Storage class for vote entities.
 */
class VoteStorage extends SqlContentEntityStorage implements VoteStorageInterface {

  function getUserVotes($uid, $vote_type_id = NULL, $entity_type_id = NULL, $entity_id = NULL, $vote_source = NULL) {
    $query = \Drupal::entityQuery('vote')
      ->condition('user_id', $uid);
    if ($vote_type_id) {
      $query->condition('type', $vote_type_id);
    }
    if ($entity_type_id) {
      $query->condition('entity_type', $entity_type_id);
    }
    if ($entity_id) {
      $query->condition('entity_id', $entity_id);
    }
    if ($uid == 0) {
      $query->condition('vote_source', static::defaultVoteSource($vote_source));
    }
    return $query->execute();
  }

  function deleteUserVotes($uid, $vote_type_id = NULL, $entity_type_id = NULL, $entity_id = NULL, $vote_source = NULL) {
    $votes = $this->getUserVotes($uid, $vote_type_id, $entity_type_id, $entity_id, $vote_source);
    if (!empty($votes)) {
      entity_delete_multiple('vote', $votes);
    }
  }

  /**
   * {@inheritdoc}
   */
  static function defaultVoteSource($vote_source = NULL) {
    if (is_null($vote_source)) {
      $vote = Vote::create(['type' => 'vote']);
      $callback = $vote->getFieldDefinition('vote_source')
        ->getDefaultValueCallback();
      $vote_source = $callback();
    }
    return $vote_source;
  }

  function getVotesSinceMoment() {
    $last_cron = \Drupal::state()->get('votingapi.last_cron', 0);
    return \Drupal::entityQueryAggregate('vote')
      ->condition('timestamp', $last_cron, '>')
      ->groupBy('entity_type')
      ->groupBy('entity_id')
      ->groupBy('type')
      ->execute();
  }

  function deleteVotesForDeletedEntity($entity_type_id, $entity_id) {
    $votes = \Drupal::entityQuery('vote')
      ->condition('entity_type', $entity_type_id)
      ->condition('entity_id', $entity_id)
      ->execute();
    if (!empty($votes)) {
      entity_delete_multiple('vote', $votes);
    }
    db_delete('votingapi_result')
      ->condition('entity_type', $entity_type_id)
      ->condition('entity_id', $entity_id)
      ->execute();
  }

}
