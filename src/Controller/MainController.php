<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\EditPhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/edit-photo/", name="main-edit-photo")
     * @Security("is_granted('ROLE_USER')")
     */
    public function editPhto(Request $request): Response
    {

        $form = $this->createForm(EditPhotoType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $photo = $form->get('photo')->getData();

            if(
                $this->getUser()->getPhoto() != null &&
                file_exists( $this->getParameter('app.user.photo.directory') . $this->getUser()->getPhoto())
            ){
                unlink( $this->getParameter('app.user.photo.directory') . $this->getUser()->getPhoto() );
            }

            do{
                $newFileName = md5( random_bytes(100)) . '.' . $photo->guessExtension();

            } while(file_exists( $this->getParameter('app.user.photo.directory' ) . $newFileName ));

            $this->getUser()->setPhoto($newFileName);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $photo->move(
                $this->getParameter('app.user.photo.directory'),
                $newFileName
            );

            $this->addFlash('success', 'Photo de profil modifiée avec succes');
            return $this->redirectToRoute('main_profil');

        }

        return $this->render('main/editPhoto.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
