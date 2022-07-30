<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlantillasControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/plantillas');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'PlantillasController');
    }
}
