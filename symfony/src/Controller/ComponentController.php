<?php

namespace App\Controller;
use Symfony\Component\Asset\Package;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use App\AssetVersionStrategy\DateVersionStrategy;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\UrlPackage;
use Symfony\Component\Asset\Packages;

class ComponentController extends AbstractController
{
    public function assets()
    {
        // Paquete de activos sin versión
        $package = new Package(new EmptyVersionStrategy());

        // Paquete de activos con versión --> %2$s => version_string ; %1$s => asset_dir_string
        $packageV1 = new Package(new StaticVersionStrategy('v1', '%2$s/%1$s'));

        // Paquete de activos con versión personalizada
        $packageDateVersion = new Package(new DateVersionStrategy());

        // Paquete de activos agrupados por carpetas
        $pathPackage = new PathPackage('css', new EmptyVersionStrategy());

        // Paquetes de activos desde CDN
        $urlPackage = new UrlPackage(
            '//localhost:83/',
            new StaticVersionStrategy('v1', '%2$s/%1$s')
        );

        // Paquetes de activos según el nombre del tipo de paquete
        $emptyVersionStrategy = new EmptyVersionStrategy();
        $defaultPackage = new Package($emptyVersionStrategy);
        $namedPackage = [
            'css' => new UrlPackage('//localhost:83/', $emptyVersionStrategy),
            'v1css' => new UrlPackage(
                '//localhost:83/',
                new StaticVersionStrategy('v1', '%2$s/%1$s')
            )
        ];

        $packages = new Packages($defaultPackage, $namedPackage);

        return new Response
        ("
            <html>
                <head>
                    <link rel=\"stylesheet\" href=\"". $package->getUrl("/css/test_assets.css") . "\">
                    <link rel=\"stylesheet\" href=\"". $packageV1->getUrl("/css/test_assets.css") . "\">
                    <link rel=\"stylesheet\" href=\"". $packageDateVersion->getUrl("/css/test_assets.css") . "\">
                    <link rel=\"stylesheet\" href=\"". $pathPackage->getUrl("test_assets_package.css") . "\">
                    <link rel=\"stylesheet\" href=\"". $urlPackage->getUrl("css/test_assets_cdn.css") . "\">
                </head>
                <body>
                    <p>Test Assets: ". $package->getUrl("/css/test_assets.css") . "</p>
                    <b>Test Assets Versión: ". $packageV1->getUrl("/css/test_assets.css") . "</b>
                    <b>Test Custom Assets Versión: ". $packageDateVersion->getUrl("/css/test_assets.css") . "</b>
                    <a>Test Assets Package: ". $pathPackage->getUrl("test_assets_package.css") . "</a>
                    <h1>Test Assets Package CDN: ". $urlPackage->getUrl("css/test_assets_cdn.css") . "</h1>
                    <h1>Test Assets Packages CDN: ". $packages->getUrl("css/test_assets_cdn.css", 'css') . "</h1>
                    <h1>Test Assets Packages CDN v1: ". $packages->getUrl("css/test_assets_cdn.css", 'v1css') . "</h1>
                </body>
            </html>
        ");
    }
}