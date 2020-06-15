<?php


namespace App\Controller;


use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/book")
 */
class BookController extends AbstractRestController
{
    private $entityManager;
    private $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        BookRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Rest\Get("")
     */
    public function getAll()
    {
        $books = $this->repository->findAll();

        return $this->json($books);
    }

    /**
     * @Rest\Get("/{id}")
     */
    public function getOneById(int $id)
    {
        $book = $this->repository->find($id);
        if ($book == null) {
            return $this->json("Not found", 404);
        }

        return $this->json($book);
    }

    /**
     * @Rest\Post("")
     */
    public function add(Request $request)
    {

        $book = new Book();

        $form = $this->createForm(BookType::class, $book);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // on n'autorise pas un livre avec un couple title/author déja existant
            $existingBook = $this->repository->findOneBy(
                [
                    'title' => $book->getTitle(),
                    'author' => $book->getAuthor(),
                ]
            );
            if ($existingBook != null) {
                return $this->json("Duplicate title/author", 409);
            }

            $this->entityManager->persist($book);
            $this->entityManager->flush();

            return $this->json($book);

        } else {
            return $this->json($form, 400);
        }
    }

    /**
     * @Rest\Put("/{id}")
     */
    public function edit(Request $request, int $id)
    {
        $book = $this->repository->find($id);
        if ($book == null) {
            return $this->json("Not found", 404);
        }

        $form = $this->createForm(BookType::class, $book);

        $form->submit($request->request->all());

        if ($form->isValid()) {

            // on n'autorise pas un livre avec un couple title/author déja existant

            // VERSION 1 AVEC LES METHODES DU REPOSITORY DE BASE
            /*
             $existingBook = $this->repository->findOneBy(
                [
                    'title' => $book->getTitle(),
                    'author' => $book->getAuthor(),
                ]
            );
            // si c'est le même livre ce n'est pas une erreur
            if ($existingBook != null && $existingBook->getId()!=$book->getId()) {
                return $this->json("Duplicate title/author",409);
            }
            */
            // VERSION 2 AVEC UNE METHODE DU REPOSITORY MAISON
            $existing = $this->repository->findSameTitleAuthor(
                $book->getTitle(),
                $book->getAuthor(),
                $book->getId()
            );
            if ($existing != null) {
                return $this->json("Duplicate title/author", 409);
            }

            $this->entityManager->persist($book);
            $this->entityManager->flush();

            return $this->json($book);

        } else {
            return $this->json($form, 400);
        }
    }

    /**
     * @Rest\Delete("/{id}")
     */
    public function delete(int $id){

        $book = $this->repository->find($id);
        if ($book == null) {
            return $this->json("Not found", 404);
        }

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return $this->json("OK");
    }

}