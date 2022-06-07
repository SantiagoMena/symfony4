<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ComponentControllerTest extends WebTestCase
{
    public function testAssets(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/component/assets');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('p', 'Test Assets: /css/test_assets.css');
        $this->assertSelectorTextContains('b', 'Test Assets Versión: /v1/css/test_assets.css');

        $link = $crawler->filter('link');

        $this->assertSame("/css/test_assets.css", $link->eq(0)->attr('href'));
        $this->assertSame("/v1/css/test_assets.css", $link->eq(1)->attr('href'));
        $this->assertSame("/css/test_assets.css?vdate=" . date('Ymd'), $link->eq(2)->attr('href'));
        $this->assertSame("/css/test_assets_package.css", $link->eq(3)->attr('href'));

        $this->assertCount(5, $link);
    }
}
