<?php


namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/api/user")
 */
class UserController extends AbstractRestController
{
    private $entityManager;
    private $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Rest\Post("")
     */
    public function add(Request $request)
    {
        $entity = new User();
        $form = $this->createForm(UserType::class, $entity);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            // on vérifie que le username n'existe pas
            $existingUser = $this->repository->findOneBy(
                ['username' => $entity->getUsername()]
            );
            if ($existingUser != null) {
                return $this->json("L'utilisateur existe déja", 409,[]);
            }
            // on encrypte le mot de passe
            $encodedPassword = password_hash($entity->getPassword(), PASSWORD_BCRYPT);
            $entity->setPassword($encodedPassword);

            $this->entityManager->persist($entity);
            $this->entityManager->flush();
            return $this->json($entity, 200, [],['groups'=>['read']]);
        }
        // form invalid
        return $this->json($form, 400);
    }

}