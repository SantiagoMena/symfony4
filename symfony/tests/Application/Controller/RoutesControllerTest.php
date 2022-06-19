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

    /** @dataProvider dataUserAgents */
    public function testEjemplosCondiciones($browser, $userAgent): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/routes/ejemploCondiciones'.$browser, [], [], [
            'HTTP_User-Agent' => $userAgent
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Ejemplo de condiciones '.$browser);
    }

    public function testEjemplosVariableSlug(): void
    {
        $client = static::createClient();
        $slug = "Slug-Test";
        $crawler = $client->request('GET', '/routes/ejemploVariableSlug/'. $slug);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Ejemplo de variable Slug: '.$slug);
    }

    public function testEjemploVariableExpresionRegular(): void
    {
        $client = static::createClient();
        $codigoEntero = random_int(0, 8);
        $crawler = $client->request('GET', '/routes/ejemploVariableSlug/'. $codigoEntero);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Ejemplo de variable con requisito de expresión regular (entero): '.$codigoEntero);

    }

    public function testEjemploVariableUnicode(): void
    {
        $client = static::createClient();
        $stringVar = str_shuffle('asdfghjkl')[0];
        $intVar = random_int(0, 9);
        $var = $stringVar.$intVar;
        $crawler = $client->request('GET', '/routes/ejemploVariableSlug/'. $var);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Ejemplo de variable unicode: '.$var);
    }

    public function testEjemploVariableSlugDefault(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/routes/ejemploVariableSlugDefault');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'Ejemplo de variable Slug Default: default');
    }

    public function testEjemploVariableSlugDefaultAnnotation(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/routes/ejemploVariableSlugDefaultAnnotation');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'Ejemplo de variable Slug Default: defaultAnnotation');
    }

    public function testEjempleParamConverter(): void
    {
        $post = [
            'id' => 1,
            'title' => "New Post"
        ];

        $client = static::createClient();
        $crawler = $client->request('GET', '/routes/ejemploParamConverter/'.$post['id']);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', $post['title']);
    } 

    public function testEjemploParametrosEspeciales(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/routes/ejemploParametrosEspeciales/es/search.json', [], [], [
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJson(\json_encode([ 'response' => 'JSON Format' ]));
    }

    public function testEjemploParametrosAdicionales(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/routes/ejemploParametrosAdicionales');
        $title = "Parametros ";
        $slug = "slug";

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', $title.$slug);
    }

    public function dataMethods()
    {
        yield ['ejemploGet', 'GET'];
        yield ['ejemploPost', 'POST'];
        yield ['ejemploPut', 'PUT'];
        yield ['ejemploDelete', 'DELETE'];
    }

    public function dataUserAgents()
    {
        yield ['Firefox', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.15; rv:103.0) Gecko/20100101 Firefox/103.0'];
        yield ['Chrome', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36'];
    }
}
