<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Products;
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


        return $this->render('ajax/send-message.html.twig', array('success' => $res));
    }


};





