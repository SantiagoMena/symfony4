<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/plantillas", name="app_plantillas_")
 */
class PlantillasController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('plantillas/index.html.twig', [
            'title' => 'PlantillasController',
        ]);
    }

    /**
     * @Route("/parametros", name="parametros")
     */
    public function parametros(): Response
    {
        $array = [
            'parametro' => 'array.parametro'
        ];

        $parametro = 'parametro';

        return $this->render('plantillas/parametros.html.twig', [
            'array' => $array,
            'parametro' => $parametro
        ]);
    }

    /**
     * @Route("/links", name="links")
     */
    public function links(): Response
    {
        return $this->render('plantillas/links.html.twig');
    }

    /**
     * @Route("/assets", name="assets")
     */
    public function assets(): Response
    {
        return $this->render('plantillas/assets.html.twig');
    }

    /**
     * @Route("/variable-app", name="variable_app")
     */
    public function variableApp(): Response
    {
        $this->addFlash('alerta', 'flash');

    //    $this->sessions->set('session', 'session');

        return $this->render('plantillas/variable_app.html.twig');
    }
}
