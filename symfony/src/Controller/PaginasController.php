<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaginasController extends AbstractController
{
    public function numero()
    {
        $number = random_int(0, 100);

        return new Response(
            "<html><body>Número de la suerte: {$number}</body></html>"
        );
    }

    /**
     * @Route("/paginas/anotaciones")
     *
     * @return Response
     */
    public function anotaciones(): Response
    {
        return new Response("Esta ruta a sido generada con annotations");
    }

    /**
     * @Route("/paginas/template")
     *
     * @return void
     */
    public function numeroTemplate()
    {
        $number = random_int(0, 100);

        return $this->render('paginas/numero.html.twig', [
            'number' => $number
        ]);
    }
}