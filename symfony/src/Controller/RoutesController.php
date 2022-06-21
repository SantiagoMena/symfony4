<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/routes", name="routes_")
 */
class RoutesController extends AbstractController
{
    /**
     * @Route("/ejemplo", name="app_routes_ejemplo")
     * @return Response
     */
    public function ejemplo(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas',
        ]);
    }

    /**
     * @Route("/ejemploGet", name="app_routes_ejemplo_get", methods={"GET", "HEAD"})
     * @return Response
     */
    public function ejemploGet(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas GET',
        ]);
    }

    /**
     * @Route("/ejemploPost", name="app_routes_ejemplo_post", methods={"POST"})
     * @return Response
     */
    public function ejemploPost(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas POST',
        ]);
    }

    /**
     * @Route("/ejemploPut", name="app_routes_ejemplo_put", methods={"PUT"})
     * @return Response
     */
    public function ejemploPut(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas PUT',
        ]);
    }

    /**
     * @Route("/ejemploDelete", name="app_routes_ejemplo_delete", methods={"DELETE"})
     * @return Response
     */
    public function ejemploDelete(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas DELETE'
        ]);
    }

    /** 
    * @Route( 
    *   "/ejemploCondicionesFirefox", 
    *   name="app_routes_ejemplo_condiciones_firefox", 
    *   condition="context.getMethod() in ['GET', 'HEAD']" 
    * ) 
    * * expressions can also include configuration parameters: * condition: "request.headers.get('User-Agent') matches '%app.allowed_browsers%'" 
    */
    public function ejemploCondicionesFirefox(Request $request): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de condiciones Firefox '.$request->headers->get('User-Agent')
        ]);
    }

    /**  
    * @Route( 
    *   "/ejemploCondicionesChrome", 
    *   name="app_routes_ejemplo_condiciones_chrome", 
    *   condition="context.getMethod() in ['GET', 'HEAD'] and request.headers.get('User-Agent') matches '/chrome/i'" 
    * ) 
    * * expressions can also include configuration parameters: * condition: "request.headers.get('User-Agent') matches '%app.allowed_browsers%'" 
    */
    public function ejemploCondicionesChrome(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de condiciones Chrome'
        ]);
    }
    /**
     * @Route("/ejemploVariableSlug/{page<\p{L}\d+>}", utf8="true")
     *
     * @param string $page
     * @return Response
     */
    public function ejemploVariableUnicode(string $page): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de variable unicode: '.$page,
        ]);
    }


    /**
     * @Route("/ejemploVariableSlug/{codigoEntero}", requirements={"codigoEntero"="\d+"})
     *
     * @param integer $codigoEntero
     * @return Response
     */
    public function ejemploVariableExpresionRegular(int $codigoEntero): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de variable con requisito de expresión regular (entero): '. $codigoEntero
        ]);
    }

    /**
     * @Route("/ejemploVariableSlug/{slug}", name="app_route_ejemplo_variable_slug", methods={"GET", "HEAD"})
     *
     * @param string $slug
     * @return Response
     */
    public function ejemploVariableSlug(string $slug): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de variable Slug: '.$slug,
        ]);
    }

    /**
     * @Route("/ejemploVariableSlugDefault/{slug}", name="app_route_ejemplo_variable_slug_default", methods={"GET", "HEAD"})
     *
     * @param string $slug
     * @return void
     */
    public function ejemploVariableSlugDefault(string $slug = 'default'): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de variable Slug Default: '.$slug,
        ]);
    }

    /**
     * @Route("/ejemploVariableSlugDefaultAnnotation/{slug<\C+>?defaultAnnotation}", name="app_route_ejemplo_variable_slug_default_annotations", methods={"GET", "HEAD"})
     *
     * @param string $slug
     * @return void
     */
    public function ejemploVariableSlugDefaultAnnotation(string $slug): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de variable Slug Default: '.$slug,
        ]);
    }

    /**
     * @Route("/ejemploParamConverter/{id}", name="app_route_ejemplo_param_converter", methods={"HEAD", "GET"})
     */
    public function ejemploParamConverter(Post $post): Response
    {
        return $this->render('post/index.html.twig', [
            'title' => $post->getTitle(),
        ]);
    }

    /**
     * @Route( 
     * "/ejemploParametrosEspeciales/{_locale}/search.{_format}", 
     *   locale="en", 
     *   format="html|json", 
     *   requirements={ 
     *     "_locale": "en|fr|es", 
     *     "_format": "html|xml|json", 
     *   } 
     * )
     * @return Response
     */
    public function ejemploParametrosEspeciales(): Response
    {
        return new Response(\json_encode([
            'response' => 'JSON Format'
        ]));
    }

    /**
     * @Route("/ejemploParametrosAdicionales/{slug}/{title}", name="app_route_ejemplo_parametros_adicionales", defaults={"slug": "slug", "title": "Parametros "})
     *
     * @return Response
     */
    public function ejemploParametrosAdicionales(string $slug, string $title): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => $title.$slug,
        ]);
    }

    /**
     * @Route("/ejemploCaracteresEspeciales/{slugCaracteresEspeciales}", name="app_route_ejemplo_caracteres_especiales", requirements={"slugCaracteresEspeciales"=".+"})
     *
     * @return Response
     */
    public function ejemploCaracteresEspeciales(string $slugCaracteresEspeciales): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => $slugCaracteresEspeciales
        ]);
    }

    /**
     * Ejemplo nombre de rutas
     * 
     * @Route("/ejemploNombreRuta", methods={"GET", "HEAD"}, name="app_route_ejemplo_nombre_ruta")
     *
     * @return Response
     */
    public function ejemploNombreRuta(Request $request): Response
    {
        $route = $request->attributes->get('_route');
        return $this->render('routes/index.html.twig', [
            'title' => $route,
        ]);
    }

    /**
     * Ejemplo nombre de parametros
     *
     * @Route("/ejemploObtenerParametrosArray-{slug}.{_format}", format="json", methods={"GET", "HEAD"}, name="app_route_ejemplo_nombre_parametro")
     * @param Request $request
     * @return Response
     */
    public function ejemploObtenerArrayParametros(string $slug, Request $request): Response
    {
        return new Response(\json_encode($request->attributes->get('_route_params')));
    }

    /**
     * Ejemplo Redireccionar
     * 
     * @Route("/redireccionado", name="redireccion")
     * @param string $slug
     * @return Response
     */
    public function ejemploRedireccionar(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Redirigido'
        ]);
    }
}
