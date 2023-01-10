<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/games')]
class GameController extends AbstractController
{
    #[Route('/snake', name: 'game_snake')]
    public function snake(): Response
    {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_auth_login');
        }
        return $this->render('games/snake.html.twig');
    }
    
    #[Route('/towerblocks', name:'game_towerblocks')]
    public function towerblocks(): Response {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_auth_login');
        }
        
        return $this->render('games/towerblocks.html.twig');
    }
    
    #[Route('/colorblast', name: 'game_colorblast')]
    public function colorBlast(): Response {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_auth_login');
        }
        
        return $this->render('games/colorblast.html.twig');
    }

    #[Route('/planetdefender', name: 'game_planetdefender')]
    public function planetDefender(): Response {
        if(!$this->getUser()){
            return $this->redirectToRoute('app_auth_login');
        }
        
        return $this->render('games/planetDefender.html.twig');
    }
}
