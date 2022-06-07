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

        $urlPackage = new UrlPackage(
            '//localhost:83/',
            new StaticVersionStrategy('v1', '%2$s/%1$s')
        );

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
                    <p>Test Assets</p>
                    <b>Test Assets Versión</b>
                    <a>Test Assets Package</a>
                    <h1>Test Assets Package CDN</h1>
                </body>
            </html>
        ");
    }
}