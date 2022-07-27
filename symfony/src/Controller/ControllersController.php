<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    /**
     * @Route("/controllers/obtener-servicio")
     *
     * @return Response
     */
    public function obtenerServicio(LoggerInterface $logger): Response
    {
        return $this->render('controllers/index.html.twig', ['title' => get_class($logger)]);
    }

    /**
     * @Route("/controllers/pagina-404")
     *
     * @param Request $request
     * @return Response
     */
    public function pagina404(Request $request): Response
    {
        if($request->get('error')) {
            throw $this->createNotFoundException('Error');
        }
        return $this->render('controllers/index.html.twig', ['title' => 'ok']);
    }

    /**
     * @Route("/controllers/sesion")
     *
     * @param SessionInterface $session
     * @return Response
     */
    public function session(SessionInterface $session): Response
    {
        $session->set('session', 'session_value');

        return $this->render('controllers/index.html.twig', ['title' => $session->get('session')]);
    }

    /**
     * @Route("/controllers/alerta-relampago")
     *
     * @return Response
     */
    public function alertasRelampago(): Response
    {
        $this->addFlash('alerta', 'flash');

        return $this->render('controllers/relampago.html.twig');
    }

    /**
     * @Route("/controllers/consulta-ajax")
     *
     * @param Request $request
     * @return void
     */
    public function requestAjax(Request $request): Response
    {
        if(!$request->isXmlHttpRequest()) {
            throw new HttpException(400, 'No es Ajax');
        }

        return $this->render('controllers/index.html.twig', ['title' => 'ajax']);
    }
}
