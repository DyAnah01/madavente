<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Articles>
 *
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    public function save(Articles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Articles $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAllArticles(array $id){
        return $this
            ->getEntityManager()
            ->createQueryBuilder()
            ->select('a')
            ->from(Articles::class, 'a', 'a.id')
            ->where('a.id in (:id)')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    
    // select all categorie
    // public function findCategorieAll()
    // {
    //     return $this->createQueryBuilder('a')
    //         ->select('c.id as idCategorie','c.nom as nomCat')
    //         ->innerJoin('App\Entity\Categorie','c', Join::WITH, 'c.id = c.idCategorie')
    //         ->getQuery()
    //         ->getResult();
    // }

    // public function findCategorieOne($value)
    // {
    //     return $this->createQueryBuilder('a')
    //     ->select('c.id as idCategorie','c.nom as nomCat')
    //     ->innerJoin('App\Entity\Categorie','c', Join::WITH, 'c.id = c.idCategorie')
    //     ->andWhere('u.id = :val')
    //     ->setParameter('val', $value)
    //     ->getQuery()	
    //     ->getResult();      
    // }

   public function paginationQuery()
   {
       return $this->createQueryBuilder('a')
           ->orderBy('a.id', 'ASC')
           ->getQuery()
       ;
   }

//       /**
//     * @return Articles[] Returns an array of Articles objects
//     */
//    public function findBySearch($text): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.titre LIKE :val')
//            ->setParameter('val', "%$text%")
//            ->getQuery()
//            ->getResult()
//        ;
//    }


//    public function getArticlesWithIdCat($value){
//     return $this->createQueryBuilder('a')
//     ->Select('c.id as idCat','c.nom','a.id as idArt','a.titre','a.description','a.photo','a.prix','a.dateCreation','a.stock','a.shortDescription')
//     ->innerJoin('App\Entity\Categorie','c', Join::WITH, 'c.id = a.idCategorie')
//     ->andWhere('a.id = :val')
//     ->setParameter('val', $value)
//     ->getQuery()
//     ->getResult();        
// }
// public function getAllA(){
//     return $this->createQueryBuilder('a')
//     ->Select('c.id as idCat','c.nom','a.id as idArt','a.titre','a.description','a.photo','a.prix','a.dateCreation','a.stock','a.shortDescription')
//     ->innerJoin('App\Entity\Categorie','c', Join::WITH, 'c.id = a.idCategorie')
//     ->getQuery()
//     ->getResult();        
// }

//    /**
//     * @return Articles[] Returns an array of Articles objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Articles
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
