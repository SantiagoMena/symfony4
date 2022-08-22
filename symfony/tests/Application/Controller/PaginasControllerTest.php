<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaginasControllerTest extends WebTestCase
{
    public function testNumero(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/paginas/numero');

        $this->assertResponseIsSuccessful();
    }
}
