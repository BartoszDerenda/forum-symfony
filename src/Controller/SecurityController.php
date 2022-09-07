<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RegistrationType;
use App\Form\Type\UserType;
use App\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    /**
     * User service.
     */
    private UserServiceInterface $userService;

    /**
     * Password hasher.
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     */
    public function __construct(UserServiceInterface $userService, TranslatorInterface $translator, UserPasswordHasherInterface $passwordHasher)
    {
        $this->userService = $userService;
        $this->translator = $translator;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('question_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(
            RegistrationType::class,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('app_register'),
            ]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $user = new User();
            $user->setEmail($data['email']);
            $user->setNickname($data['nickname']);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $data['password']
                )
            );

            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.success')
            );

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('security/registration.html.twig', [
            'controller_name' => 'RegistrationController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edit action.
     */
    #[Route('/{id}/account_edit', name: 'app_account_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(
            UserType::class,
            $user,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('app_account_edit', ['id' => $user->getId()]),
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);
            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.success')
            );

            return $this->redirectToRoute('question_index');
        }

        return $this->render(
            'security/edit.html.twig',
            ['form' => $form->createView()]
        );
    }
}
