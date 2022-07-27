<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllersControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/index');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Index');
    }

    public function testRedirect(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/redirect');

        $this->assertResponseRedirects();
    }

    public function testRedirectExterna(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/redirect-externa');

        $this->assertResponseRedirects();
    }

    public function testRenderizarVista(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/renderirzar-vista');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'render');
    }

    public function testObtenerServicio(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/obtener-servicio');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', get_class($router = self::$container->get('Psr\Log\LoggerInterface')));
    }
}
