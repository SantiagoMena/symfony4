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
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

    /**
     * @Route("/controllers/consulta-idioma")
     *
     * @param Request $request
     * @return Response
     */
    public function idiomaBrowser(Request $request): Response
    {
        return $this->render('controllers/index.html.twig', ['title' => $request->getPreferredLanguage()]);
    }

    /**
     * @Route("/controllers/parametro-get")
     *
     * @param Request $request
     * @return Response
     */
    public function parametroGet(Request $request): Response
    {
        $parametro = $request->query->get('parametro');

        return $this->render('controllers/index.html.twig', ['title' => $parametro]);
    }

    /**
     * @Route("/controllers/parametro-post", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function parametroPost(Request $request): Response
    {
        $parametro = $request->request->get('parametro');

        return $this->render('controllers/index.html.twig', ['title' => $parametro]);
    }

    /**
     * @Route("/controllers/variables-servidor")
     *
     * @param Request $request
     * @return Response
     */
    public function obtenerVariablesServidor(Request $request): Response
    {
        $host = $request->server->get('HTTP_HOST');

        return $this->render('controllers/index.html.twig', ['title' => $host]);
    }

    /**
     * @Route("/controllers/archivos")
     *
     * @param Request $request
     * @return Response
     */
    public function obtenerArchivos(Request $request): Response
    {
        $archivo = $request->files->get('archivo');

        if(!$archivo instanceof UploadedFile) {
            throw new HttpException(400, "Archivo no encontrado en la solicitud");
        }

        return $this->render('controllers/index.html.twig', ['title' => $archivo->getClientOriginalName()]);
    }
}
