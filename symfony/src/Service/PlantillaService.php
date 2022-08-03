<?php
namespace App\Service;
use Twig\Environment;

class PlantillaService
{
    private $twig;

    public function __construct(Environment $twig) {
        $this->twig = $twig;
    }

    public function renderByService(string $param)
    {
        return $this->twig->render('plantillas/service.html.twig', [
            'param' => $param
        ]);
    }
}