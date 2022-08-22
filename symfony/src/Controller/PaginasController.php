<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class PaginasController
{
    public function numero()
    {
        $number = random_int(0, 100);

        return new Response(
            "<html><body>Número de la suerte: {$number}</body></html>"
        );
    }
}