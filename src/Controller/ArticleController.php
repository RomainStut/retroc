<?php

namespace App\Controller;

use App\Entity\Arcade;
use App\Entity\Goodies;
use App\Entity\Nextgen;
use App\Entity\Retro;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    /**
     * @Route("/article", name="article")
     */
    public function typeChoice()
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }


    /**
     * @route("/article/add/{type}", name="addArticle")
     */

    public function addArticle(Request $request, $type)
    {
        $typeAllowed=['arcade', 'retro', 'goodies', 'next-gen'];
        if ($type){
            if (in_array($type,$typeAllowed)){
                if ($type == 'retro'){
                    $article = new Retro();
                }
                elseif ($type == 'arcade'){
                    $article = new Arcade();
                }
                elseif ($type == 'goodies'){
                    $article = new Goodies();
                }
                else{
                    $article = new Nextgen();
                }
            }
        }

        $form = $this->createForm(ArticleType::class, $article);


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
