<?php

namespace App\Controller;

use App\Entity\CoupSpeciaux;
use App\Form\CoupSpeciauxType;
use App\Repository\CoupSpeciauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * @Route("/coupspeciaux")
 */
class CoupSpeciauxController extends AbstractController
{
    /**
     * @Route("/", name="coupspeciaux_index", methods={"GET"})
     */
    public function index(CoupSpeciauxRepository $coupspeciauxsRepository): JsonResponse
    {
        return new JsonResponse([
            'coupspeciauxs' => $coupspeciauxsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="coupspeciaux_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $coupspeciaux = new CoupSpeciaux(Uuid::v4());
        $form = $this->createForm(CoupSpeciauxType::class, $coupspeciaux);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($coupspeciaux);
            $entityManager->flush();

            return new JsonResponse([
                'coupspeciauxs' => $coupspeciaux,
            ], 201);

        }else{
            $errors = [];
            // Global
            foreach ($form->getErrors() as $error) {
                $errors[$form->getName()][] = $error->getMessage();
            }

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
     * @Route("/{id}", name="coupspeciaux_show", methods={"GET"})
     */
    public function show(CoupSpeciaux $coupspeciaux): Response
    {
        return new JsonResponse([
            'coupspeciaux' => $coupspeciaux,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="coupspeciaux_edit", methods={"PUT"})
     */
    public function edit(Request $request, CoupSpeciaux $coupspeciaux, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoupSpeciauxType::class, $coupspeciaux);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return new JsonResponse([
                'coupspeciaux' => $coupspeciaux,
            ]);
        }else{
            return new JsonResponse([
                'erorrs' => $form->getErrors(),
            ], 400);
        }

        
    }

    /**
     * @Route("/{id}", name="coupspeciaux_delete", methods={"DELETE"})
     */
    public function delete(CoupSpeciaux $coupspeciaux, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($coupspeciaux);
        $entityManager->flush();

        return new JsonResponse([
            "message" => "Succefully deleted"
        ], 204);
    }
}
