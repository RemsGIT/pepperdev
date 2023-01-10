<?php

namespace App\Controller\Api;

use App\Entity\Game;
use App\Entity\Score;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/score')]
class ApiScoreController extends AbstractController
{
    #[Route('/add', name: 'api_score_update')]
    public function updateScore(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $gameName = $request->get('gameName') ?? null;
        $newScore = $request->get('score') ?? null;
        
        if($gameName !== null && $newScore !== null) {
            // Get current user
            if($this->getUser() !== null) {
                $game = $doctrine->getRepository(Game::class)->findOneByName($gameName);
                
                if($game !== null) {
                    $entityManager = $doctrine->getManager();
                    $max = $doctrine->getRepository(Score::class)->getMaxScoreFromUser($this->getUser()->getId(), $game->getId());
                    if($max === null){
                        // New score
                        $score = new Score();
                        $score->setUser($this->getUser());
                        $score->setGame($game);
                        $score->setScore((float)$newScore);
                        
                        $entityManager->persist($score);
                        $entityManager->flush();
                    }
                    else {
                        // Compare score
                        if($max->getScore() < $newScore) {
                            // Update
                            $max->setScore($newScore);
                            $entityManager->persist($max);
                            $entityManager->flush();
                            
                        }
                    }
                }
            }
        }
        
        
        return $this->json([
            'message' => 'Update score',
        ], 200);
    }

    #[Route('/update', name: 'api_score_u')]
    public function u (Request $request){
        
        $request->getSession();
        
        
        return rand(0, 100);
    }
}
