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

    public function testAnotaciones(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/paginas/anotaciones');

        $this->assertResponseIsSuccessful();
    }

    public function testTemplate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/paginas/template');

        $this->assertResponseIsSuccessful();
    }
}
