<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiPostController extends AbstractController
{
    #[Route('/api/post', name: 'api_post_index', methods:"GET")]
    public function index(BookRepository $bookRepository ): Response
    {
        $books = $bookRepository->findAll();

        return $this->json($books , 200, []);

    }

    #[Route('/api/post', name: 'api_post_store', methods:"POST")]
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $jsonGet = $request->getContent();

        $books = $serializer->deserialize($jsonGet, Book::class, 'json');

        $entityManager->persist($books);
        $entityManager->flush();

        return $this->json($books , 201, []);
    }
}
