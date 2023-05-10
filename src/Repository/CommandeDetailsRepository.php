<?php

namespace App\Repository;

use App\Entity\CommandeDetails;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<CommandeDetails>
 *
 * @method CommandeDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeDetails[]    findAll()
 * @method CommandeDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeDetails::class);
    }

    public function save(CommandeDetails $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CommandeDetails $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // public function findOneCommande($value)
    // {
    //     return $this->createQueryBuilder('c')
    //             ->Select('c.id as idCommande','v.id as idVehicule','v.titre as titreVehicule','v.marque','v.modele','v.description as descriptionVehicule','v.photo as photoVehicule','v.prix_journalier','a.id as idAgence', 'a.titre as titreAgences','a.adresse','a.ville','a.cp','a.description as descriptionAgences','a.photo as photoAgences','c.date_heure_depart as dayStart', 'c.date_heure_fin as dayEnd', 'c.prix_total as totalPrice','c.date_enregistrement as dateEnregistrement','u.id as idUser','u.email as emailUser')
    //             ->innerJoin('App\Entity\Vehicule','v', Join::WITH, 'v.id = c.id_vehicule')            
    //             ->innerJoin('App\Entity\Agences', 'a' , Join::WITH, 'a.id = c.id_agence')
    //             ->innerJoin('App\Entity\User','u', Join::WITH,'u.id = c.id_user')
    //             ->andWhere('u.id = :val')
    //             ->setParameter('val', $value)
    //             ->getQuery()		
    //             ->getResult();
    // }

    // *******************
        // public function FindOneCommande($value)
        // {
        //     return $this->createQueryBuilder('cd')
        //         ->select('cd.commande.id as idCom' )
        //         ->innerJoin('App\Entity\User','u', Join::WITH,'u.id = cd.id_user')
        //         ->andWhere('u.id = :val')
        //         ->setParameter('val', $value)
        //         ->getQuery()
        //         ->getResult()
        //     ;
        // }
    // *******************

//    /**
//     * @return CommandeDetails[] Returns an array of CommandeDetails objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CommandeDetails
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
