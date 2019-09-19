<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
  /**
  * @Route("/")
  */
  public function login()
  {
    return $this->render('login.html.twig');
  }
}
