<?php

namespace App\Repository;

use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Score>
 *
 * @method Score|null find($id, $lockMode = null, $lockVersion = null)
 * @method Score|null findOneBy(array $criteria, array $orderBy = null)
 * @method Score[]    findAll()
 * @method Score[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
    }

    public function save(Score $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Score $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Score[] Returns an array of Score objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Score
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * @throws NonUniqueResultException
     */
    public function getMaxScoreFromUser($userId, $gameId): ?Score
    {
        return $this->createQueryBuilder('s')
            ->where('s.user = :user_id AND s.game = :game_id')
            ->setParameters([
                'user_id' => $userId,
                'game_id' => $gameId
            ])
            ->getQuery()
            ->getOneOrNullResult()
        ;
            
    }


    /**
     * @param $gameId
     * @return Score[]
     */
    public function findScoreboardByGame($gameId): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.game = :game_id')
            ->setParameters([
                'game_id' => $gameId
            ])
            ->orderBy('s.score', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
