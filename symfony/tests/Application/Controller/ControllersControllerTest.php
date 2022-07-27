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

    public function testErrorPageOk(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/pagina-404');

        $this->assertResponseIsSuccessful();
    }
    public function testErrorPage404(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/pagina-404', ['error' => true]);
        
        $this->assertResponseStatusCodeSame('404');
    }

    public function testSession(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/sesion');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'session_value');
    }

    public function testAlertasRelampago(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/alerta-relampago');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'flash');
    }

    public function testAjax(): void
    {
        $client = static::createClient();
        $crawler = $client->xmlHttpRequest('GET', '/controllers/consulta-ajax');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'ajax');
    }

    public function testIdiomaBrowser(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/consulta-idioma', [], [], ['HTTP_ACCEPT_LANGUAGE' => 'es']);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'es');
    }
}
