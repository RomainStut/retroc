<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @route("/product/add/", name="addProduct")
     */

    public function addArticle(Request $request)
    {
        $article = new Products();
        $form = $this->createForm(ProductType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();

            $article->setIsValidate(false);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($article);

            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre article est soummis à validation de Romain'
            );

            return $this->redirectToRoute('login');
        }

        return $this->render('article/addArticle.html.twig', array(
            'form' => $form->createView()
        ));
    }
}

