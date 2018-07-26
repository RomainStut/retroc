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


    /**
     * @Route("admin/blog/{id}", name="blog", requirements = {"id"="[0-9]+"})
     */
    public function infoArticle($id){
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $blogs = $repository->Find($id);
        if(!$blogs){
            throw $this->createNotFoundException('No article found for id '.$id);
        }
        return $this->render('admin/update-blog.html.twig', array('blogs'=>$blogs));

    }


}
