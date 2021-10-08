<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion/", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         // SI l'utilisateur est déjà connecté on le redirigie sur l'accueil
         if ($this->getUser()) {
             return $this->redirectToRoute('main_home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * page de déconnexion
     *
     * @Route("/déconnexion", name="app_logout")
     */
    public function logout(): void
    {
        // le code ici ne sera jamais lu car intercepté par le bundle sécurity
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
