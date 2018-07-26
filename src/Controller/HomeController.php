<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;



class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */

    public function showAll()
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->myFindLast4();

        return $this->render('home/index.html.twig',
                                array('products'=> $products)
        );
    }
}
