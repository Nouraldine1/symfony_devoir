<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    // Enregistrer un nouvel utilisateur
    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // Mettre à jour un utilisateur existant
    public function update(User $user): void
    {
        $this->_em->flush(); // Doctrine gère la mise à jour automatiquement
    }

    // Supprimer un utilisateur par ID
    public function delete(User $user): void
    {
        $this->_em->remove($user);
        $this->_em->flush();
    }

    // Trouver un utilisateur par ID
    public function findById(int $id): ?User
    {
        return $this->find($id);
    }

    // Récupérer tous les utilisateurs
    public function findAllUsers(): array
    {
        return $this->findAll();
    }

    // Rechercher des utilisateurs par nom d'utilisateur
    public function searchByUsername(string $username): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :username')
            ->setParameter('username', '%' . $username . '%')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Trouver un utilisateur par email
    public function findByEmail(string $email): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    // Récupérer les utilisateurs par rôle
    public function findUsersByRole(string $role): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.role = :role')
            ->setParameter('role', $role)
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
