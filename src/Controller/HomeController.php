<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use App\Entity\Blog;



class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */

    public function showAll()
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->myFindLast4();

        $repository = $this->getDoctrine()->getRepository(Blog::class);

        $blogs = $repository->findAll();

        return $this->render('home/index.html.twig',
                                array('products'=> $products,
                                        'blogs' => $blogs
                                    )
        );
    }
}
