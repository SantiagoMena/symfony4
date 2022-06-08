<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoutesController extends AbstractController
{
    /**
     * @Route("/routes/ejemplo", name="app_routes_ejemplo")
     * @return Response
     */
    public function ejemplo(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas',
        ]);
    }

    /**
     * @Route("/routes/ejemploGet", name="app_routes_ejemplo_get", methods={"GET", "HEAD"})
     * @return Response
     */
    public function ejemploGet(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas GET',
        ]);
    }

    /**
     * @Route("/routes/ejemploPost", name="app_routes_ejemplo_post", methods={"POST"})
     * @return Response
     */
    public function ejemploPost(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas POST',
        ]);
    }

    /**
     * @Route("/routes/ejemploPut", name="app_routes_ejemplo_put", methods={"PUT"})
     * @return Response
     */
    public function ejemploPut(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas PUT',
        ]);
    }

    /**
     * @route("/routes/ejemploDelete", name="app_routes_ejemplo_delete", methods={"DELETE"})
     * @return Response
     */
    public function ejemploDelete(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas DELETE'
        ]);
    }
}
