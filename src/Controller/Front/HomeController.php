<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="front_app", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        return $this->render('Front/Home/index.html.twig');
    }
}