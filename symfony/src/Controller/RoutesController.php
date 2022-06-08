<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoutesController extends AbstractController
{
    /**
     * @Route("/routes/ejemplo1", name="app_routes_ejemplo1")
     */
    public function ejemplo1(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas #1',
        ]);
    }
}
