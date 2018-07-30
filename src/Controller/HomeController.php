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

    public function showAll()
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->myFindLast4();

        $repository = $this->getDoctrine()->getRepository(Blog::class);

        $blogs = $repository->myFindLastArticle();

        return $this->render('home/index.html.twig',
                                array('products'=> $products,
                                        'blogs' => $blogs
                                    )
        );
    }

    public function searchBarHome()
    {
        $form = $this->createFormBuilder(null)
            ->add('Recherche', TextType::class)
            ->add('Rechercher', SubmitType::class, ['attr' => ['class' => 'btn text-warning navbarColor01 ']])
        ->getForm();

        return $this->render('home/searchbar.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/recherche", name="recherche-titre-home")
     */
    public function searchBarQuery(Request $request)
    {
        $search = $request->request->get('form');

        $repository = $this->getDoctrine()->getRepository(Products::class);
        $products = $repository->findAllWhereTitle($search['Recherche']);

        return $this->render('product/recherche-res.html.twig', array('products' => $products));
    }
    


}
