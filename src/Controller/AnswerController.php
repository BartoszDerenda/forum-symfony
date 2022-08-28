<?php
/**
 * Answer controller.
 */

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Entity\User;
use App\Form\Type\AnswerType;
use App\Service\AnswerServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AnswerController.
 */
#[Route('/answer')]
class AnswerController extends AbstractController
{
    /**
     * Answer service.
     */
    private AnswerServiceInterface $answerService;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     */
    public function __construct(AnswerServiceInterface $answerService, TranslatorInterface $translator)
    {
        $this->answerService = $answerService;
        $this->translator = $translator;
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'answer_create',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|POST',
    )]
    public function create(Request $request, Question $question): Response
    {
        /** @var User $author */
        $author = $this->getUser();

        $answer = new Answer();
        $answer->setAuthor($author);
        $answer->setQuestion($question);
        $form = $this->createForm(
            AnswerType::class,
            $answer,
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('answer')['image'];
            if ($file) {
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

                $file->move(
                    $this->getParameter('uploads_dir'), $filename
                );
                $answer->setImage($filename);
            }
            $this->answerService->save($answer);

            $this->addFlash(
                'success',
                $this->translator->trans('message.answer_created_successfully')
            );

            return $this->redirectToRoute('question_show', ['id' => $answer->getQuestion()->getId()]);
        }

        return $this->render(
            'answer/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Answer $answer Answer entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'answer_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('EDIT', subject: 'answer')]
    public function edit(Request $request, Answer $answer): Response
    {
        $form = $this->createForm(
            AnswerType::class,
            $answer,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('answer_edit', ['id' => $answer->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get('answer')['image'];
            if ($file) {
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

                $file->move(
                    $this->getParameter('uploads_dir'), $filename
                );
                $answer->setImage($filename);
            }
            $this->answerService->save($answer);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('question_show', ['id' => $answer->getQuestion()->getId()]);
        }

        return $this->render(
            'answer/edit.html.twig',
            [
                'form' => $form->createView(),
                'answer' => $answer,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Answer $answer Answer entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'answer_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    #[IsGranted('DELETE', subject: 'answer')]
    public function delete(Request $request, Answer $answer): Response
    {
        $form = $this->createForm(
            FormType::class,
            $answer,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('answer_delete', ['id' => $answer->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->answerService->delete($answer);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('question_show', ['id' => $answer->getQuestion()->getId()]);
        }

        return $this->render(
            'answer/delete.html.twig',
            [
                'form' => $form->createView(),
                'answer' => $answer,
            ]
        );
    }

    /**
     * Award action.
     *
     * @param Request  $request  HTTP request
     * @param Answer $answer Answer entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/award', name: 'answer_award', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('ROLE_ADMIN')]
    #[IsGranted('AWARD', subject: 'answer')]
    public function award(Request $request, Answer $answer): Response
    {
        $form = $this->createForm(
            FormType::class,
            $answer,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('answer_award', ['id' => $answer->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->answerService->award($answer);

            $this->addFlash(
                'success',
                $this->translator->trans('message.awarded_successfuly')
            );

            return $this->redirectToRoute('question_index');
        }

        return $this->render(
            'answer/award.html.twig',
            [
                'form' => $form->createView(),
                'answer' => $answer,
            ]
        );
    }

    /**
     * Deaward action.
     *
     * @param Request  $request  HTTP request
     * @param Answer $answer Answer entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/award', name: 'answer_award', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('ROLE_ADMIN')]
    #[IsGranted('AWARD', subject: 'answer')]
    public function deaward(Request $request, Answer $answer): Response
    {
        $form = $this->createForm(
            FormType::class,
            $answer,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('answer_award', ['id' => $answer->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->answerService->deaward($answer);

            $this->addFlash(
                'success',
                $this->translator->trans('message.awarded_successfuly')
            );

            return $this->redirectToRoute('question_index');
        }

        return $this->render(
            'answer/award.html.twig',
            [
                'form' => $form->createView(),
                'answer' => $answer,
            ]
        );
    }
}
