<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlantillasController extends AbstractController
{
    /**
     * @Route("/plantillas", name="app_plantillas")
     */
    public function index(): Response
    {
        return $this->render('plantillas/index.html.twig', [
            'title' => 'PlantillasController',
        ]);
    }
}
