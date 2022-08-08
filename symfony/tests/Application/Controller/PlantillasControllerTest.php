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
        $this->assertSelectorTextSame("[id='app.flash']", "flash");
        $this->assertSelectorTextSame("[id='app.environment']", $client->getKernel()->getEnvironment());
        $this->assertSelectorTextSame("[id='app.debug']", "1");
        $this->assertSelectorTextContains("[id='app.token']", "Token");

    }

    public function testSubRenderView()
    {
        $client = static::createClient();
        $param = 'test';
        $crawler = $client->request('GET', '/plantillas/render-view', ['param' => $param]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame("[id='render-view']", $param);
    }

    public function testRenderService()
    {
        $client = static::createClient();
        $param = 'test';
        $crawler = $client->request('GET', '/plantillas/render-service', ['param' => $param]);
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame("[id='twig-service']", $param);
    }

    public function testExistsTemplate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/plantillas/exists');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'existe');
    }

    public function testExtendsTemplate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/plantillas/extends-template');

        $this->assertResponseIsSuccessful();
        $this->assertPageTitleContains('Blog Index');
        $this->assertSame('titulo blog 1', $crawler->filter('h2')->eq(0)->text());
        $this->assertSame('titulo blog 2', $crawler->filter('h2')->eq(1)->text());
    }
}
