<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\DTO\ClientSearchDTO;
use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientSearchType;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(ClientRepository $clientRepository): Response
    {
        // Récupérer tous les clients pour affichage
        $clients = $clientRepository->findAll();

        return $this->render('client/index.html.twig', [
            'clients' => $clients,
        ]);
    }

    // Route pour la création de client avec compte utilisateur
    #[Route('/client/new', name: 'client_create')]
    public function create(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);

        // Traitement du formulaire de création de client
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si la case pour créer un compte utilisateur est cochée
            if ($form->get('createAccount')->getData()) {
                // Création d'un nouveau compte utilisateur
                $user = new User();
                $user->setEmail($client->getTelephone()); // Utiliser le téléphone comme e-mail

                // Hasher le mot de passe de l'utilisateur
                $user->setPassword($passwordHasher->hashPassword($user, plainPassword: 'password123')); 

                // Lier le client à son compte utilisateur
                $client->setUser($user);

                // Persister l'utilisateur
                $em->persist($user);
            }

            // Persister le client
            $em->persist($client);
            $em->flush();

            // Rediriger vers la page d'index après la création
            return $this->redirectToRoute('app_client');
        }

        return $this->render('client/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // Route pour rechercher des clients
    #[Route('/client/search', name: 'client_search')]
    public function search(Request $request, ClientRepository $clientRepository): Response
    {
        $searchDTO = new ClientSearchDTO();
        $form = $this->createForm(ClientSearchType::class, $searchDTO);
        $form->handleRequest($request);
        
        $clients = [];
        
        if ($form->isSubmitted() && $form->isValid()) {
            // Recherche des clients en fonction des critères spécifiés
            $clients = $clientRepository->searchByCriteria($searchDTO);
        }

        return $this->render('client/search.html.twig', [
            'form' => $form->createView(),
            'clients' => $clients,
        ]);
    }

    // Route pour afficher les détails d'un client
    #[Route('/client/{id}', name: 'client_show')]
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }
}
