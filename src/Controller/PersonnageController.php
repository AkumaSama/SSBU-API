<?php

namespace App\Controller;

use App\Entity\Personnage;
use App\Form\PersonnageType;
use App\Repository\PersonnageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * @Route("/personnage")
 */
class PersonnageController extends AbstractController
{
    /**
     * @Route("/", name="personnage_index", methods={"GET"})
     */
    public function index(PersonnageRepository $personnagesRepository): JsonResponse
    {
        return new JsonResponse($personnagesRepository->findAll());
    }

    /**
     * @Route("/new", name="personnage_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $personnage = new Personnage(Uuid::v4());
        $form = $this->createForm(PersonnageType::class, $personnage);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($personnage);
            $entityManager->flush();

            return new JsonResponse($personnage, 201);

        }else{
            $errors = [];
            // Global
            foreach ($form->getErrors() as $error) {
                $errors[$form->getName()][] = $error->getMessage();
            }

            // Fields
            foreach ($form as $child /** @var Form $child */) {
                if (!$child->isValid()) {
                    foreach ($child->getErrors() as $error) {
                        $errors[$child->getName()][] = $error->getMessage();
                    }
                }
            }

            return new JsonResponse([
                'erorrs' => $errors,
            ], 400);
        }
    }

    /**
     * @Route("/{id}", name="personnage_show", methods={"GET"})
     */
    public function show(Personnage $personnage): Response
    {
        return new JsonResponse($personnage);
    }

    /**
     * @Route("/{id}/edit", name="personnage_edit", methods={"PUT"})
     */
    public function edit(Request $request, Personnage $personnage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PersonnageType::class, $personnage);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return new JsonResponse($personnage);
        }else{
            return new JsonResponse([
                'erorrs' => $form->getErrors(),
            ], 400);
        }

        
    }

    /**
     * @Route("/{id}", name="personnage_delete", methods={"DELETE"})
     */
    public function delete(Personnage $personnage, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($personnage);
        $entityManager->flush();

        return new JsonResponse([
            "message" => "Succefully deleted"
        ], 204);
    }
}
