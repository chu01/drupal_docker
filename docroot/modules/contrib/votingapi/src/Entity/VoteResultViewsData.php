<?php

/**
 * @file
 * Contains Drupal\votingapi\Entity\VoteResultViewsData.
 */

namespace Drupal\votingapi\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Vote Result entities.
 */
class VoteResultViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['votingapi_result']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Vote Result'),
      'help' => $this->t('The Vote Result ID.'),
    );

    return $data;
  }

}
