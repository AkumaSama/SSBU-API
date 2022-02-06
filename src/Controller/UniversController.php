<?php

namespace App\Controller;

use App\Entity\Univers;
use App\Form\UniversType;
use App\Repository\UniversRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * @Route("/univers")
 */
class UniversController extends AbstractController
{
    /**
     * @Route("/", name="univers_index", methods={"GET"})
     */
    public function index(UniversRepository $universRepository): JsonResponse
    {
        return new JsonResponse($universRepository->findAll());
    }

    /**
     * @Route("/new", name="univers_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $univer = new Univers(Uuid::v4());
        $form = $this->createForm(UniversType::class, $univer);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($univer);
            $entityManager->flush();

            return new JsonResponse($univer, 201);

        }else{
            return new JsonResponse([
                'erorrs' => $form->getErrors(),
       	    ], 400);
        }
    }

    /**
     * @Route("/{id}", name="univers_show", methods={"GET"})
     */
    public function show(Univers $univer): Response
    {
        return new JsonResponse($univer);
    }

    /**
     * @Route("/{id}/edit", name="univers_edit", methods={"PUT"})
     */
    public function edit(Request $request, Univers $univer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UniversType::class, $univer);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return new JsonResponse($univer);
        }else{
            return new JsonResponse([
                'erorrs' => $form->getErrors(),
            ], 400);
        }

        
    }

    /**
     * @Route("/{id}", name="univers_delete", methods={"DELETE"})
     */
    public function delete(Univers $univer, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($univer);
        $entityManager->flush();

        return new JsonResponse([
            "message" => "Succefully deleted"
        ], 204);
    }
}
