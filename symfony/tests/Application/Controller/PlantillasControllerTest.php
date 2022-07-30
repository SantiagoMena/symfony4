<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlantillasControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/plantillas/index');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'PlantillasController');
    }

    public function testParametros(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/plantillas/parametros');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'parametro');
        $this->assertSelectorTextSame('h2', 'array.parametro');
    }

    
}
