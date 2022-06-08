<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RoutesControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/routes/ejemplo1');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Ejemplo de rutas #1');
    }
}
