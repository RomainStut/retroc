<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Blog;

class BlogController extends Controller
{
    /**
     * @Route("admin/blog", name="admin-blog")
     */
    public function showAll()
    {

        $repository = $this->getDoctrine()->getRepository(Blog::class);

        $blogs = $repository->findAll();
        return $this->render('admin/gestionBlog.html.twig', array('blogs' => $blogs ));
    }


}
