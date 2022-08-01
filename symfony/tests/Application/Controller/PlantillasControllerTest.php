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

    public function testLinks(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/plantillas/links');

        $this->assertResponseIsSuccessful();
        $this->assertSame('/plantillas/links', $crawler->filter('#url_relativa')->attr('href'));
        $this->assertSame('http://localhost/plantillas/links', $crawler->filter('#url_absoluta')->attr('href'));
    }

    public function testAssets(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/plantillas/assets');
        
        $this->assertResponseIsSuccessful();
        $this->assertSame(
            '/assets/plantillas/asset_twig.png',
            $crawler->filter('#asset')->attr('src')
        );
    }

    public function testVariableApp()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/plantillas/variable-app');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame("[id='app.request.host']", "localhost");
        $this->assertSelectorTextSame("[id='app.debug']", "1");
        // $this->assertSelectorTextSame("[id='app.environment']", "dev");
    }
}
