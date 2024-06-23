<?php

namespace App\Repository;

use App\Class\Search;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * Requête qui renvoie les produits en fonction de la recherche
     * @param Search $search
     * @return Product[]
     */
    public function findWithSearch(Search $search)
    {
        $query = $this
            ->createQueryBuilder('p') // Requête sur la table Product || 'p' [FROM Product p]
            ->select('c', 'p') // Selection des colonnes 'c' et 'p' || [SELECT category c, product p]
            ->join('p.category', 'c'); // Jointure entre 'p' et 'c' || [JOIN category category c]

        if (!empty($search->getCategories())) { // Si le tableau 'categories' n'est pas vide
            $query = $query
                ->andWhere('c.id IN (:categories)') // :categories est un tableau de la classe Search qui contient les ids des categories
                ->setParameter('categories', $search->getCategories()); // Ajoute le tableau 'categories' dans la requête (categorie :categories)
        }

        // EXEMPLE : 
        //
        // SELECT c.*, p.*
        // FROM product p
        // JOIN category c ON p.category_id = c.id
        // WHERE c.id IN (1, 2, 3);

        if (!empty($search->getString())) { // Si le champ 'string' n'est pas vide
            $query = $query 
                ->andWhere('p.name LIKE :string') // Ajoute la requête dans la requête || [WHERE name LIKE :string]
                ->setParameter('string', "%{$search->getString()}%"); // Ajoute la requête dans la requête || [WHERE name LIKE :string]
        }

        return $query->getQuery()->getResult();
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
