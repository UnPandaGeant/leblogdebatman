<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\NewArticleFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *
 * @Route("/blog" , name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/nouvelle-publication/", name="new_publication")
     *
     * @Security()ecurity("is_granted('ROLE_ADMIN')")
     */
    public function newPublication(Request $request): Response
    {
        $newArticle = new Article();

        $form = $this->createForm( NewArticleFormType::class, $newArticle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $newArticle
                ->setAuthor($this->getUser())
                ->setPublicationDate(new \DateTime())
            ;

            $em = $this->getDoctrine()->getManager();

            $em->persist($newArticle);

            $em->flush();

            $this->addFlash('success', 'Article publié avec succes');

            return $this->redirectToRoute('main_home');

        }

        return $this->render('blog/newPublication.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
