<?php
/**
 * Answer service interface.
 */

namespace App\Service;

use App\Entity\Answer;

/**
 * Interface CategoryServiceInterface.
 */
interface AnswerServiceInterface
{
    /**
     * Save entity.
     *
     * @param Answer $answer Answer entity
     */
    public function save(Answer $answer): void;

    /**
     * Delete entity.
     *
     * @param Answer $answer Answer entity
     */
    public function delete(Answer $answer): void;
}
