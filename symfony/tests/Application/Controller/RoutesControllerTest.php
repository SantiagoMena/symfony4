<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoutesControllerTest extends WebTestCase
{
    public function testEjemplo(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/routes/ejemplo');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Ejemplo de rutas');
    }

    /** @dataProvider dataMethods */
    public function testEjemplosMethod($route, $method): void
    {
        $client = static::createClient();
        $crawler = $client->request($method, '/routes/'. $route);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Ejemplo de rutas ' . $method);
    }

    public function dataMethods()
    {
        yield ['ejemploGet', 'GET'];
        yield ['ejemploPost', 'POST'];
        yield ['ejemploPut', 'PUT'];
        yield ['ejemploDelete', 'DELETE'];
    }
}
