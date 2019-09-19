<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FidoController extends AbstractController
{
  /**
   * @Route("/fidologin", name="fido_login", methods={"POST"})
   */
  public function login(Request $request)
  {
    $credential = $request->get('credential');

    return $this->json([
      'username' => $user->getUsername(),
      'roles' => $user->getRoles(),
    ]);
  }

  /**
   * @Route("/fidoregister", name="fido_register", methods={"POST"})
   */
  public function register(Request $request)
  {
    $credential = $request->get('credential');

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
