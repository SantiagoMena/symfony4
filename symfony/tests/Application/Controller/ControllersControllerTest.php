<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\BrowserKit\Cookie;

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

    public function testParametroGet(): void
    {
        $parametro = 'test';
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/parametro-get', ['parametro' => $parametro]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', $parametro);
    }

    public function testParametroPost(): void
    {
        $parametro = 'test-post';
        $client = static::createClient();
        $crawler = $client->request('POST', '/controllers/parametro-post', ['parametro' => $parametro]);
        
        $this->assertResponseIsSuccessful();
    }

    public function testObtenerVariablesServidor(): void
    {
        $server = 'symfony.test';
        $client = static::createClient([], [
            'HTTP_HOST' => $server
        ]);

        $crawler = $client->request('POST', '/controllers/variables-servidor');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', $server);
    }

    public function testObtenerArchivos(): void
    {
        $nombreArchivo = 'archivo.jpg';

        // Crear archivo temporal
        $temp = tmpfile();
        fwrite($temp, "archivo test");
        fseek($temp, 0);
        
        $datosArchivo = stream_get_meta_data($temp);
        $archivo = new UploadedFile($datosArchivo['uri'], $nombreArchivo, null, null, true);
        
        $client = static::createClient();
        $crawler = $client->request('POST', '/controllers/archivos', [], ['archivo' => $archivo]);
        
        // Eliminar archivo temporal
        fclose($temp);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', $nombreArchivo);
    }

    public function testObtenerArchivoError(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/controllers/archivos');

        $this->assertResponseStatusCodeSame('400');
    }

    public function testCookies(): void
    {
        $client = static::createClient();

        $cookie_value = "galleta_value";
        $cookie_name = "galleta";
        $cookie = new Cookie($cookie_name, $cookie_value);

        $client->getCookieJar()->set($cookie);
        $crawler = $client->request('GET', '/controllers/galletas');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', $cookie_value);
        $this->assertBrowserCookieValueSame($cookie_name, $cookie_value);
    }

    public function testCabeceras(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/controllers/cabeceras');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', 'localhost');
    }

    public function testVariablesConfiguracion(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/controllers/variables-configuracion');
        
        $parameter = $client->getKernel()->getContainer()->getParameter('kernel.project_dir');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextSame('h1', $parameter);
    }
}
