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

            return $this->redirectToRoute('showAll');
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
     * @Route("/product/typecat/{type}/{cat}", name="product-type-cat")
     */
    public function showAllTypeCat($type, $cat)
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->findAllType($type, $cat);

        return $this->render('product/all-type-cat.html.twig', array('products' => $products));

    }

    /**
     * @Route("/product/update/{id}", name="update-product", requirements= {"id"="\d+"})
     */
    public function updateProduct(Products $products, Request $request, FileUploader $uploader){

        $fileName = $products->getImage();
        if($products->getImage()) {

            $products->setImage(new File($this->getParameter('articles_image_directory') . '/' . $products->getImage()));
        }
        $form = $this->createForm(ProductType::class, $products);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $products = $form->getData();

            if($products->getImage()){

                $file = $products->getImage();

                $fileName = $uploader->upload($file, $fileName);

                $products->setImage($fileName);

            }
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            $this->addFlash('success', 'Annonce modifiée !');
            return $this->redirectToRoute('userProfil');
        }
        return$this->render('product/modifier.html.twig', array('form' => $form->createView()));
    }


    /**
     * @Route("product/delete/{id}", name = "product-delete", requirements= {"id"="\d+"})
     */

    public function deleteProduct(Products $products){
       //j'utilise mon voter pour déterminer si l'utilisateur peut modifier cette annonce
       // $this->denyAccessUnlessGranted('delete', $products);
        //recuperation de l'entity manager
        $entityManager = $this->getDoctrine()->getManager();
        //je veux supprimer ce produit
        $entityManager->remove($products);

        //j'exécute la requete
        $entityManager->flush();

        //créer un message de succes en flash

        $this->addFlash('success', 'Produit supprimé !');
        return $this->redirectToRoute('userProfil');
    }
}
