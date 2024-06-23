<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;


class AccountPasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    #[Route('/compte/password', name: 'app_account_password')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        /**
         * @var User|null $user
         */
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $current_password = $form->get('current_password')->getData();


            if ($passwordHasher->isPasswordValid($user, $current_password)) {

                $new_password = $form->get('new_password')->getData();
                $password = $passwordHasher->hashPassword($user, $new_password);
                $user->setPassword($password);
                $this->entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a bien été mis à jour.');
                return $this->redirectToRoute('app_account');
            } else {

                $this->addFlash('error', 'Votre mot de passe actuel est incorrect, veuillez ressayer !');
            }
        }
        return $this->render('account/password.html.twig', ['form' => $form->createView()]);
    }
}
