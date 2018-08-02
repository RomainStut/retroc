<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Products;
use App\Entity\Blog;



class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */

    public function showAll(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->myFindLast4();

        $repository = $this->getDoctrine()->getRepository(Blog::class);

        $blogs = $repository->myFindLastArticle();

        $message = $request->query->get('message', null);

        return $this->render('home/index.html.twig',
                                array('products'=> $products,
                                        'blogs' => $blogs,
                                        'message' => $message
                                    )
        );
    }


    /**
     * @Route("/recherche/{search}", defaults={"page":"1"}, methods={"GET"}, name="recherche-titre-home")
     * @Route("/recherche/{search}/page/{page}", requirements={"page": "[1-9]\d*"}, methods={"GET"}, name="recherche_paginated")
     */
    public function searchBarQuery($search, int $page)
    {
        if(empty($search)){
            return $this->redirectToRoute('/');
        }

        $repository = $this->getDoctrine()->getRepository(Products::class);
        $products = $repository->findAllWhereTitlePagination($search, $page);

        return $this->render('product/recherche-res.html.twig', array('products' => $products, 'search' => $search));
    }
    


}
