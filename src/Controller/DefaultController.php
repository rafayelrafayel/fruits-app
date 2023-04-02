<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{




    /**
     * @Route("/{vueRouting}", requirements={"vueRouting"="^(?!api|_(wdt|profiler)).*"}, name="home")
     */
    public function index(Request $request): Response
    {
        try {

            return $this->render('default/index.html.twig', []);
        } catch (\Exception $e) {
            return new Response('Error: ' . $e->getMessage(), 500);
        }
    }
}
