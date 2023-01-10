<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_auth_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('pages/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
    
    #[Route('/logout', name: 'app_auth_logout')]
    public function logout(){
        
    }
    
    #[Route('/register', name: 'app_auth_register')]
    public function register(){
        
    }
    
    #[Route('/register-handle', name: 'app_auth_handle_register')]
    public function handleRegister(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): JsonResponse|RedirectResponse
    {
        if($request->isMethod('POST')) {

            $username = $request->get('username');
            $password = $request->get('password');
            
            if($username !== "" && $password !== "") {
                $entityManager = $doctrine->getManager();

                $user = new User();
                $user->setUsername($request->get('username') ?? null);

                $hashedPassword = $passwordHasher->hashPassword($user, $request->get('password') ?? null);
                $user->setPassword($hashedPassword);
                
                $entityManager->persist($user);
                $entityManager->flush();
                
                $this->addFlash('success', 'Inscription, validée, tu peux te connecter');
                return $this->redirectToRoute('app_auth_login');
            }
            else {
                return $this->json([
                    'message' => 'Username or password missing',
                ], 400);
            }
            
        }
        else {
            return $this->json([
                'message' => 'Sorry, we only accept POST method',
            ], 500);
        }


        return $this->redirectToRoute('app_auth_login');


    }
}
