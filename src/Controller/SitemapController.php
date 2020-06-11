<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request)
        {
        // Get the host name from the uRL
        $hostname = $request->getSchemeAndHttpHost();

        // List URl into an array
        $urls = [];
        $urls[] = ['loc' => $this->generateUrl('default_home')];
        $urls[] = ['loc' => $this->generateUrl('default_about')];
        $urls[] = ['loc' => $this->generateUrl('user_space')];
        $urls[] = ['loc' => $this->generateUrl('movie_details')];
        $urls[] = ['loc' => $this->generateUrl('movie_find')];

        // Dynamic URLs for films
        foreach ($this->getDoctrine()->getRepository(Movie::class)->findAll() as $movie) {
            
            $urls[] = [
                'loc' => $this->generateUrl('movie', [
                    'slug' => $movie->getSlug(),
                ]),
            ];
        }

        // Make the XML response
        $response = new Response(
            $this->renderView('sitemap/index.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200 // ? ask Benoit
        );
        
        // Add headers
        $response->headers->set('Content-Type', 'text/xml');
        
        return $response;




    return $this->render('sitemap/index.html.twig', [
        'controller_name' => 'SitemapController',
    ]);
    }

}
