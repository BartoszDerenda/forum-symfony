<?php
/**
 * Answer service.
 */

namespace App\Service;

use App\Entity\Answer;
use App\Repository\AnswerRepository;

/**
 * Class AnswerService.
 */
class AnswerService implements AnswerServiceInterface
{
    /**
     * Answer repository.
     */
    private AnswerRepository $answerRepository;

    /**
     * Constructor.
     *
     * @param AnswerRepository     $answerRepository Answer repository
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }


    /**
     * Save entity.
     *
     * @param Answer $answer Answer entity
     */
    public function save(Answer $answer): void
    {
        $this->answerRepository->save($answer);
    }

    /**
     * Delete entity.
     *
     * @param Answer $answer Answer entity
     */
    public function delete(Answer $answer): void
    {
        $this->answerRepository->delete($answer);
    }
}
