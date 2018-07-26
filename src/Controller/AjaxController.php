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
     * @route("/product/message", name="user-message")
     */
    public function sendUserMessage(Request $request)
    {
        $message = new Messages();
        dump($request->request->all());

        $product = new Products();

        $messagesend = $request->request->get('message', 'invalide');

        $message->setDatepost(new \DateTime(date('Y-m-d H:i:s')));
        $message->setExpediteur($this->getUser());
        $message->setProduct($product->getId());
        $message->setDestinataire($product->getUser());
        $message->setContent($messagesend);
        $message->setTitle('titre test');
        dump($message);

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($message);

        if($entityManager->flush()){
            $res = "message envoyé";
        } else {
            $res = "bande de boloss";
        }


        return $this->render('ajax/send-message.html.twig', array('success' => $res));
    }
}
