<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\UserType;

class OauthController extends AbstractController
{
  /**
   * @Route("/oauth", name="password_login", methods={"POST"})
   */
  public function login()
  {
    $username = $request->get('username');


    return $this->json([
      'username' => $user->getUsername(),
      'roles' => $user->getRoles(),
    ]);
  }
}
