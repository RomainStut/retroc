<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InformationsController extends Controller
{
    /**
     * @Route("/informations", name="informations")
     */
    public function index()
    {
        return $this->render('informations/index.html.twig', [
            'controller_name' => 'InformationsController',
        ]);
    }

    /**
     * @Route("/informations/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('informations/contact.html.twig');
    }
    /**
     * @Route("/informations/cgv", name="cgv")
     */
    public function cgv()
    {
        return $this->render('informations/cgv.html.twig');
    }
}
