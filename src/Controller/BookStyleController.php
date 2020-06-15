<?php


namespace App\Controller;


use App\Repository\BookStyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Rest\Route("/api/bookStyle")
 */
class BookStyleController extends AbstractController
{
    private $entityManager;
    private $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        BookStyleRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Rest\Get("")
     */
    public function getAll(){

        $bookStyles = $this->repository->findAll();

        return $this->json($bookStyles, 200, [], ['groups'=>['read']]);
    }
}