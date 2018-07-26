<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Blog;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function showall()
    {

        $repository = $this->getDoctrine()->getRepository(blog::class);

        $products = $repository->myFindLast4();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }


}
