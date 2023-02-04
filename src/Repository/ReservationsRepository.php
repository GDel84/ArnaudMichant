<?php

namespace App\Repository;

use App\Entity\Reservations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservations>
 *
 * @method Reservations|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservations|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservations[]    findAll()
 * @method Reservations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservations::class);
    }

    public function save(Reservations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservations $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function nbreservation($start, $end)
    {
        return $this->createQueryBuilder('r')
            ->select('r')
            ->where("r.scheduledTime >= :start")
            ->andWhere("r.scheduledTime <= :end")
            ->setParameter("start", $start)
            ->setParameter("end", $end)
            ->getQuery()
            ->getResult();
    }

    public function nbplace($start, $end)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT SUM(nbcouverts) AS totalcouverts FROM reservations 
            WHERE scheduled_time BETWEEN :start AND :end
            ';
            
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery([
            'start' => $start->format('Y-m-d H:i'), 
            'end' => $end->format('Y-m-d H:i')
        ]);

        return $resultSet->fetchAllAssociative();
    }



//    /**
//     * @return Reservations[] Returns an array of Reservations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reservations
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
