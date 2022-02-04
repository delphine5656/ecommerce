<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this -> entityManager = $entityManager;
    }


    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $plaintextPassword = "";
        $form = $this-> createForm(RegisterType::class, $user);
        $form ->handleRequest($request);

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        if($form -> isSubmitted() && $form -> isValid()){
            $user = $form ->getData();
            $this-> entityManager -> persist($user);
            $this-> entityManager-> flush();

        }
        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function delete(UserPasswordHasherInterface $passwordHasher, UserInterface $user)
    {
        // ... e.g. get the password from a "confirm deletion" dialog
        $plaintextPassword = "";

        if (!$passwordHasher->isPasswordValid($user, $plaintextPassword)) {
            throw new AccessDeniedException();
        }
    }
}

