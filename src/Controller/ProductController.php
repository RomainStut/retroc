<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Products;
use App\Form\MessageType;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use App\Service\FileUploader;



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
     * @Route("product/{id}", name="product", requirements = {"id"="[0-9]+"})
     */
    public function infoArticle($id){
        $repository = $this->getDoctrine()->getRepository(Products::class);
        $product = $repository->myFind($id);
        if(!$product){
            throw $this->createNotFoundException('No article found for id '.$id);
        }
        return $this->render('product/infoProduct.html.twig', array('product'=>$product[0]));

    }

    /**
     * @route("/product/add/", name="addProduct")
     */

    public function addProduct(Request $request, FileUploader $uploader)
    {
        $product = new Products();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product = $form->getData();

            $product->setIsValidate(false);

            $product->setUser($this->getUser());

            $product->setDatepost(new \DateTime(date('Y-m-d H:i:s')));

            if($product->getImage()){

                $file = $product->getImage();

                $fileName = $uploader->upload($file);

                $product->setImage($fileName);
            }



            dump($product);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($product);

            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre product est soummis à validation'
            );

            return $this->redirectToRoute('addProduct');
        }

        return $this->render('product/add-product.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @route("/product/all", name="showAll")
     */
    public function showAll(){

        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->myFindAll();

        return $this->render('product/all-products.html.twig',
            array('products'=> $products)
        );

    }


     /**
     * @Route("/product/type/{type}", name="product-type")
     */
    public function showAllType($type)
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->findAllType($type);

        return $this->render('product/all-type.html.twig', array('products' => $products));
    }

    /**
     * @Route("/product/{type}/{cat}", name="product-type-cat")
     */
    public function showAllTypeCat($type, $cat)
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->findAllType($type, $cat);

        return $this->render('product/all-type-cat.html.twig', array('products' => $products));

    }
}
