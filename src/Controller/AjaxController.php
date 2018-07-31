<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Products;
use Symfony\Component\Asset\Packages;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AjaxController extends Controller
{
    /**
     * @route("/product/message/{id}", name="user-message")
     */
    public function sendUserMessage(Products $products, Request $request)
    {
        $message = new Messages();
        dump($request->request->all());

        $repository = $this->getDoctrine()->getRepository(Products::class);
        $product = $repository->find($products);



        $messagesend = $request->request->get('message', 'invalide');

        if(!empty($messagesend)) {

            $message->setDatepost(new \DateTime(date('Y-m-d H:i:s')));
            $message->setExpediteur($this->getUser());
            $message->setProduct($product);
            $message->setDestinataire($product->getUser());
            $message->setContent($messagesend);
            $message->setTitle('titre test');
            dump($message);

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($message);

            $entityManager->flush();

            $message = 'votre message a bien été envoyé!';
        }
        else{
            $message = 'veuillez saisir votre message svp.';
        }

        return $this->render('ajax/send-message.html.twig', array('success' => $message));

    }

    /**
    *@Route("/profil/message", name="message-user")
    */

    public function showMessage()
    {

    	$userId = $this->getUser();

        $repository = $this->getDoctrine()->getRepository(Messages::class);
        $messages = $repository->myfindUserMessage($userId);

        //nous permet de renvoyer un message d'erreur si aucun id ne correspond
        if (!$messages) {
            throw $this->createNotFoundException(
                'No message found for user id '.$userId
            );
        }

        return $this->render('ajax/loadmessage.html.twig',
                                array('messages' => $messages)
        );

    }

    /**
     * @Route("/admin/validation/{id}", name="validation-success", requirements={"id", "\d+"})
     */
    public function validateProduct(Products $products)
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);
        $product = $repository->find($products);

        $product->setIsvalidate(true);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($product);

        $entityManager->flush();

        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->findInvalid();

        return $this->render('admin/gestionAnnoncesAjax.html.twig',
            array('products' => $products));

    }

    /**
    *@Route("/profil/annonce", name="annonce-user")
    */
    public function showProducts()
    {

    	$userId = $this->getUser();

        $repository = $this->getDoctrine()->getRepository(Products::class);
        $products = $repository->myfindUserProducts($userId);

        //nous permet de renvoyer un message d'erreur si aucun id ne correspond
        if (!$products) {
            throw $this->createNotFoundException(
                'No annonce found for user id '.$userId
            );
        }

        return $this->render('ajax/loadproduct.html.twig',
                                array('products' => $products)
        );

    }

    /**
     * @Route("/admin/search-by-title", name="ajax-search-by-title")
     */
    public function searchByTitle(Request $request, Packages $asset)
    {

        $search = $request->request->get('title', 'invalide');

        $repository = $this->getDoctrine()->getRepository(Products::class);
        $products = $repository->findAllWhereTitle($search);

        if(!empty($products)){

            foreach($products as $product){

                $json[] = array('name' => $product->getName(), 'img' => $asset->getUrl('uploads/images/'.$product->getImage()) ,'url' => $this->generateUrl('product', ['id' => $product->getId()]));

            }

            return $this->json(array('status'=>'ok', 'products' => $json));
        }

        return $this->json(array('status'=>'ko', 'erreur' => 'Aucun résultat'));

    }

    /**
     * @Route("/admin/calcule-cote", name="ajax-calcule-cote")
     */
    public function calculeCote(Request $request)
    {
        $search = $request->request->get('title', 'invalide');
        $quality = $request->request->get('quality', 'invalide');

        $repository = $this->getDoctrine()->getRepository(Products::class);
        $products = $repository->findAllWhereTitleQuality($search, $quality);

        if(!empty($products)){

            $total = 0;
            $nb_article = 0;
            $moyenne = 0;

            foreach($products as $product){

                $total += $product->getPrice();

                $nb_article += 1;

            }

            $moyenne = $total/$nb_article;

            return $this->json(array('status'=>'ok', 'cote' => $moyenne));
        }

        return $this->json(array('status'=>'ko', 'erreur' => 'Aucun prix'));
    }

    


}





