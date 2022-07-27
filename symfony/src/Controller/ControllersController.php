<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ControllersController extends AbstractController
{
    /**
     * @Route("/controllers/index", name="app_controllers_index")
     */
    public function index(): Response
    {
        return $this->render('controllers/index.html.twig', [
            'title' => 'Index'
        ]);
    }

    /**
     * @Route("/controllers/redirect", name="app_controllers_redireccion_ruta")
     */
    public function redireccionRuta(): RedirectResponse
    {
        return $this->redirectToRoute('app_controllers_index', [], 301);
    }

    /**
     * @Route("/controllers/redirect-externa", name="app_controllers_redireccion_externa")
     */
    public function redireccionExterna(): RedirectResponse
    {
        return $this->redirect('https://symfony.com');
    }

    /**
     * @Route("/controllers/renderirzar-vista", name="app_controllers_renderizar_vista")
     *
     * @return Response
     */
    public function renderizarVisra(): Response
    {
        return $this->render('controllers/render.html.twig', ['text' => 'render']);
    }

    
}
