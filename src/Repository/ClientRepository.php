<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

//    /**
//     * @return Client[] Returns an array of Client objects
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

//    public function findOneBySomeField($value): ?Client
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
 // Enregistrer un nouveau client
 public function save(Client $client): void
 {
     $this->_em->persist($client);
     $this->_em->flush();
 }

 // Mettre à jour un client existant
 public function update(Client $client): void
 {
     $this->_em->flush(); // Doctrine gère la mise à jour automatiquement
 }

 // Supprimer un client par ID
 public function delete(Client $client): void
 {
     $this->_em->remove($client);
     $this->_em->flush();
 }

 // Trouver un client par ID
 public function findById(int $id): ?Client
 {
     return $this->find($id);
 }

 // Récupérer tous les clients
 public function findAllClients(): array
 {
     return $this->findAll();
 }

 // Rechercher des clients par nom
 public function searchByName(string $name): array
 {
     return $this->createQueryBuilder('c')
         ->andWhere('c.name LIKE :name')
         ->setParameter('name', '%' . $name . '%')
         ->orderBy('c.id', 'ASC')
         ->getQuery()
         ->getResult();
 }

 // Trouver un client par téléphone
 public function findByPhoneNumber(string $phoneNumber): ?Client
 {
     return $this->createQueryBuilder('c')
         ->andWhere('c.phoneNumber = :phone')
         ->setParameter('phone', $phoneNumber)
         ->getQuery()
         ->getOneOrNullResult();
 }

 // Récupérer les clients avec et sans compte
 public function findClientsWithAccounts(bool $hasAccount): array
 {
     return $this->createQueryBuilder('c')
         ->andWhere('c.hasAccount = :hasAccount')
         ->setParameter('hasAccount', $hasAccount)
         ->orderBy('c.id', 'ASC')
         ->getQuery()
         ->getResult();
 }
}
