<?php

namespace App\Controller;

use App\Entity\Products;
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

            // return $this->redirectToRoute('login');
        }

        return $this->render('product/add-product.html.twig', array(
            'form' => $form->createView()
        ));
    }
}

