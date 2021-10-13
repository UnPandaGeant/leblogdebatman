<?php

namespace App\Controller;

use App\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * Contrôleur de la page d'accueil
     *
     * @Route("/", name="main_home")
     */
    public function home(): Response
    {

        // Récupération des derniers articles publiés
        $articleRepo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $articleRepo->findBy([], ['publicationDate' => 'DESC'], $this->getParameter('app.article.last_article_number'));

        return $this->render('main/home.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * Page de profil
     *
     * @Route("/mon-profil/", name="main_profil")
     * @Security("is_granted('ROLE_USER')")
     */
    public function profil(): Response
    {

        return $this->render('main/profil.html.twig');
    }

    /**
     * @Route("/test/", name="test")
     */
    public function test(): Response
    {
        $names = ['Alice', 'Bob', 'Jean', 'Renaud'];

        return $this->json([
            'names' => $names
        ]);
    }

}
