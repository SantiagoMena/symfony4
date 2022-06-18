<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoutesController extends AbstractController
{
    /**
     * @Route("/routes/ejemplo", name="app_routes_ejemplo")
     * @return Response
     */
    public function ejemplo(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas',
        ]);
    }

    /**
     * @Route("/routes/ejemploGet", name="app_routes_ejemplo_get", methods={"GET", "HEAD"})
     * @return Response
     */
    public function ejemploGet(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas GET',
        ]);
    }

    /**
     * @Route("/routes/ejemploPost", name="app_routes_ejemplo_post", methods={"POST"})
     * @return Response
     */
    public function ejemploPost(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas POST',
        ]);
    }

    /**
     * @Route("/routes/ejemploPut", name="app_routes_ejemplo_put", methods={"PUT"})
     * @return Response
     */
    public function ejemploPut(): Response
    {
        return $this->render('routes/index.html.twig', [
            'title' => 'Ejemplo de rutas PUT',
        ]);
    }

    /**
     * @route("/routes/ejemploDelete", name="app_routes_ejemplo_delete", methods={"DELETE"})
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
    *   "/routes/ejemploCondicionesFirefox", 
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
    *   "/routes/ejemploCondicionesChrome", 
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
     * @Route("/routes/ejemploVariableSlug/{page<\p{L}\d+>}", utf8="true")
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
     * @Route("/routes/ejemploVariableSlug/{codigoEntero}", requirements={"codigoEntero"="\d+"})
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
     * @Route("/routes/ejemploVariableSlug/{slug}", name="app_route_ejemplo_variable_slug", methods={"GET", "HEAD"})
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
     * @Route("/routes/ejemploVariableSlugDefault/{slug}", name="app_route_ejemplo_variable_slug_default", methods={"GET", "HEAD"})
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
     * @Route("/routes/ejemploVariableSlugDefaultAnnotation/{slug<\C+>?defaultAnnotation}", name="app_route_ejemplo_variable_slug_default_annotations", methods={"GET", "HEAD"})
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
     * @Route("/routes/ejemploParamConverter/{id}", name="app_post_view", methods={"HEAD", "GET"})
     */
    public function ejemploParamConverter(Post $post): Response
    {
        return $this->render('post/index.html.twig', [
            'title' => $post->getTitle(),
        ]);
    }

    /**
     * @Route( 
     * "/articles/{_locale}/search.{_format}", 
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
}
