<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RegistrationType;
use App\Form\Type\UserType;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * User service.
     */
    private UserServiceInterface $userService;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     */
    public function __construct(UserServiceInterface $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(
            RegistrationType::class,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('app_register'),
            ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $data = $form->getData();
            $user = new User();
            $user->setEmail($data['email']);
            $user->setNickname($data['nickname']);
            $user->setRoles(array('ROLE_USER'));
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $data['password']
                ));

            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.success')
            );

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('security/registration.html.twig', [
            'controller_name' => 'RegistrationController',
            'form' => $form->createView()
        ]);

    }
}