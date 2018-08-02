<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Category;
use App\Entity\Message;
use App\Entity\Products;
use App\Entity\Type;
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
     * @Route("product/{id}", name="product", requirements = {"id"="[0-9]+"})
     */
    public function infoArticle($id){
        $repository = $this->getDoctrine()->getRepository(Products::class);
        $product = $repository->myFind($id);

         if(!$product){
            throw $this->createNotFoundException('No article found for id '.$id);
        }
        return $this->render('product/infoProduct.html.twig', array('product'=>$product[0]));
        // nous permet de renvoyer un message d'erreur si aucun id ne correspond

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
                'Votre annonce est soummise à validation'
            );

            return $this->redirectToRoute('showAll');
        }

        return $this->render('product/add-product.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @route("/product/all", defaults={"page":"1"}, methods={"GET"} ,name="showAll")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, methods={"GET"}, name="showAll_paginated")
     */
    public function showAll(int $page)
    {

        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->myFindAll($page);

        return $this->render('product/all-products.html.twig',
            array('products'=> $products)
        );

    }


     /**
     * @Route("/product/type/{type}", defaults={"page":"1"}, methods={"GET"}, name="product-type")
      * @Route("/product/type/{type}/page/{page}", requirements={"page": "[1-9]\d*"}, methods={"GET"}, name="product-type_paginated")
     */
    public function showAllType($type, int $page)
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->findAllType($type, $page);

        $repo = $this->getDoctrine()->getRepository(Type::class);

        $typename = $repo->find($type);

        return $this->render('product/all-type.html.twig', array('products' => $products, 'type' => $typename));
    }

    /**
     * @Route("/product/typecat/{type}/{cat}", defaults={"page":"1"}, methods={"GET"}, name="product-type-cat", requirements={"type"="\d+", "cat"="\d+"})
     * @Route("/product/type/{type}/cat/{cat}/page/{page}", requirements={"page": "[1-9]\d*"}, methods={"GET"}, name="product-type-cat_paginated")
     */
    public function showAllTypeCat(Type $type, Categories $cat, int $page)
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->showAllTypeCat($type, $cat, $page);

        $repositoryType = $this->getDoctrine()->getRepository(Type::class);

        $typename = $repositoryType->find($type);

        $repositoryCat = $this->getDoctrine()->getRepository(Categories::class);

        $catname = $repositoryCat->find($cat);

        return $this->render('product/all-type-cat.html.twig', array('products' => $products, 'type' => $typename, 'categorie' => $catname));

    }

    /**
     * @Route("/product/update/{id}", name="update-product", requirements= {"id"="\d+"})
     */
    public function updateProduct(Products $products, Request $request, FileUploader $uploader){

        $this->denyAccessUnlessGranted('edit', $products);
        $fileName = $products->getImage();
        if($products->getImage()) {

            $products->setImage(new File($this->getParameter('articles_image_directory') . '/' . $products->getImage()));
        }
        $form = $this->createForm(ProductType::class, $products);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $products = $form->getData();
            $products->setIsValidate(false);
            if($products->getImage()){

                $file = $products->getImage();

                $fileName = $uploader->upload($file, $fileName);

            }
            $products->setImage($fileName);
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            $this->addFlash('success', 'Annonce modifiée !');
            return $this->redirectToRoute('userProfil');
        }
        return$this->render('product/modifier.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("admin/product/modif-product/{id}", name="modif-product", requirements= {"id"="\d+"})
     */
    public function ModifProduct(Products $products, Request $request, FileUploader $uploader){

        $this->denyAccessUnlessGranted('edit', $products);

        $repository = $this->getDoctrine()->getRepository(Products::class);

        $product = $repository->find($products);

        $user = $product->getUser();

        $fileName = $products->getImage();

        if($products->getImage()) {

            $products->setImage(new File($this->getParameter('articles_image_directory') . '/' . $products->getImage()));
        }

        $form = $this->createForm(ProductType::class, $products);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $products = $form->getData();

            $products->setIsValidate(false);

            if($products->getImage()){

                $file = $products->getImage();

                $fileName = $uploader->upload($file, $fileName);

            }

            $products->setImage($fileName);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('validation-annonce');

           
            
        }

        return $this->render('ajax/modifProduct.html.twig', array('form' => $form->createView(), 'user' => $user));
        
    }  



}
