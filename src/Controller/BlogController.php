<?php

namespace App\Controller;

use App\Form\BlogType;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Blog;
use Symfony\Component\HttpFoundation\File\File;


class BlogController extends Controller
{
    /**
     * @Route("admin/blog", name="admin-blog")
     */
    public function showAll()
    {

        $repository = $this->getDoctrine()->getRepository(Blog::class);

        $blogs = $repository->findAll();
        return $this->render('admin/gestionBlog.html.twig', array('blogs' => $blogs));
    }


    /**
     * @Route("admin/blog/{id}", name="blog", requirements = {"id"="[0-9]+"})
     */
    public function infoArticle($id)
    {
        $repository = $this->getDoctrine()->getRepository(Blog::class);
        $blogs = $repository->Find($id);
        if (!$blogs) {
            throw $this->createNotFoundException('No article found for id ' . $id);
        }
        return $this->render('admin/update-blog.html.twig', array('blogs' => $blogs));

    }

    /**
     * @Route("/admin/add/article/", name="add-article-blog")
     */
    public function addArticleBlog(Request $request, FileUploader $uploader)
    {
        $article = new Blog();
        $form = $this->createForm(BlogType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();
            $article->setDatepost(new \DateTime(date('Y-m-d H:i:s')));
            if ($article->getImage()) {

                $file = $article->getImage();

                $fileName = $uploader->upload($file);
                dump($fileName);
                $article->setImage($fileName);
                dump($article);
            }

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($article);

            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre article est ajouté'
            );

            return $this->redirectToRoute('admin-blog');
        }
        return $this->render('admin/addArticleBlog.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/update/{id}", name="update-article-blog", requirements = {"id"="[0-9]+"})
     */
    public function updateArticle(Blog $blog, Request $request, FileUploader $uploader){
        $fileName = $blog->getImage();
        if($blog->getImage()) {

            $blog->setImage(new File($this->getParameter('articles_image_directory') . '/' . $blog->getImage()));
        }
        $form = $this->createForm(BlogType::class, $blog);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $blog = $form->getData();

            if($blog->getImage()){

                $file = $blog->getImage();

                $fileName = $uploader->upload($file, $fileName);

                $blog->setImage($fileName);

            }
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            $this->addFlash('success', 'Article modifiée !');
            return $this->redirectToRoute('blog', array('id' => $blog->getId()));
        }
        return$this->render('blog/update.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/admin/delete/{id}", name="delete-article-blog", requirements = {"id"="[0-9]+"})
     */
public function deleteArticle(Blog $blog){
    $entityManager = $this->getDoctrine()->getManager();

    $entityManager->remove($blog);

    $entityManager->flush();

    $this->addFlash('success', 'Article supprimé !');
    return $this->redirectToRoute('admin-blog');

}

}
