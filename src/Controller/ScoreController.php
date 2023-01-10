<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Score;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{
    public function scoreboard(string $gameName, ManagerRegistry $doctrine, string $position = 'top-left',): Response
    {
        $scoreRepository = $doctrine->getManager()->getRepository(Score::class);

        $game = $doctrine->getRepository(Game::class)->findOneByName($gameName);

        if($game !== null) {
            $scores = $scoreRepository->findScoreboardByGame($game);
            
            return $this->render('components/scoreboard.html.twig', [
                'scores' => $scores,
                'position' => $position
            ]);
        }
        return new Response('');
        
        
    }
}
    