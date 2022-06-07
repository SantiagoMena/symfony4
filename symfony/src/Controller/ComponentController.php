<?php

namespace App\Controller;
use Symfony\Component\Asset\Package;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use App\AssetVersionStrategy\DateVersionStrategy;

class ComponentController extends AbstractController
{
    public function assets()
    {
        $package = new Package(new EmptyVersionStrategy());
        // %2$s => version_string ; %1$s => asset_dir_string
        $packageV1 = new Package(new StaticVersionStrategy('v1', '%2$s/%1$s'));


        $packageDateVersion = new Package(new DateVersionStrategy());

        return new Response
        ("
            <html>
                <head>
                    <link rel=\"stylesheet\" href=\"". $package->getUrl("/css/test_assets.css") . "\">
                    <link rel=\"stylesheet\" href=\"". $packageV1->getUrl("/css/test_assets.css") . "\">
                    <link rel=\"stylesheet\" href=\"". $packageDateVersion->getUrl("/css/test_assets.css") . "\">
                </head>
                <body>
                    <p>Test Assets</p>
                    <b>Test Assets</b>
                </body>
            </html>
        ");
    }
}