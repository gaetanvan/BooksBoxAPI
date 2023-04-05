<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Borrow;
use App\Repository\BookRepository;
use App\Repository\BorrowRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use DateTime;

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

    #[Route('/api/v1/book/{id}/{id_book}/borrow', name: 'api_book_borrow', methods: ["POST"])]
    public function borrow(BookRepository $bookRepository, Request $request, UserRepository $userRepository,EntityManagerInterface $entityManager) :Response
    {

        $userId = $request->get("id");
        $user = $userRepository->find($userId);
        $bookId = $request->get("id_book");
        $book = $bookRepository->find($bookId);
        $borrow = new Borrow();

        $borrow->setIdUser($user);
        $borrow->addBook($book);
        $borrow->setDateBorrow(new DateTime());
        $book->setIsAvailable(false);


        $entityManager->persist($borrow);
        $entityManager->flush();

        return $this->json(["Message" => "Book borrowed"]);
    }

    #[Route('/api/v1/book/{id_book}/return', name: 'api_book_return', methods: ["PATCH"])]
    public function return(BorrowRepository $borrowRepository,BookRepository $bookRepository, Request $request,EntityManagerInterface $entityManager) :Response
    {

        $bookId = $request->get("id_book");
        $book = $bookRepository->find($bookId);
        $borrowId = $book->getIdBorrow();
        $borrow = $borrowRepository->findOneBy(['id' => $borrowId]);

        $borrow->setDateReturn(new DateTime());
        $book->setIsAvailable(true);


        $entityManager->persist($borrow);
        $entityManager->flush();

        return $this->json(["Message" => "Book returned"]);
    }
}
