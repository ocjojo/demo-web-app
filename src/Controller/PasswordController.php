<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\UserType;

class PasswordController extends AbstractController
{
  /**
   * @Route("/passwordlogin", name="password_login", methods={"POST"})
   */
  public function login()
  {
    $user = $this->getUser();

    return $this->json([
      'username' => $user->getUsername(),
      'roles' => $user->getRoles(),
    ]);
  }

  /**
   * @Route("/passwordregister", name="password_register", methods={"POST"})
   */
  public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
  {
    $username = $request->get('username');
    $password = $request->get('password');

    if ($username && $password) {
      $user = new User();
      $user->setUsername($username);
      $user->setPlainPassword($password);
      $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
      $user->setPassword($password);

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($user);
      $entityManager->flush();

      return $this->json([
        "success" => true
      ]);
    }

    return $this->json([], 400);
  }
}
