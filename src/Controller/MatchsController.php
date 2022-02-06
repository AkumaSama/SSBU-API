<?php

namespace App\Controller;

use App\Entity\Matchs;
use App\Form\MatchsType;
use App\Repository\MatchsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

/**
 * @Route("/matchs")
 */
class MatchsController extends AbstractController
{
    /**
     * @Route("/", name="match_index", methods={"GET"})
     */
    public function index(MatchsRepository $matchsRepository): JsonResponse
    {
        return new JsonResponse([
            'matchs' => $matchsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="match_new", methods={"POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $match = new Matchs(Uuid::v4());
        $match->setDate(new \DateTime('now'));
        $form = $this->createForm(MatchsType::class, $match);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($match);
            $entityManager->flush();

            return new JsonResponse([
                'matchs' => $match,
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
     * @Route("/{id}", name="match_show", methods={"GET"})
     */
    public function show(Matchs $match): Response
    {
        return new JsonResponse([
            'match' => $match,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="match_edit", methods={"PUT"})
     */
    public function edit(Request $request, Matchs $match, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MatchsType::class, $match);
        $form->submit(json_decode($request->getContent(), true));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return new JsonResponse([
                'match' => $match,
            ]);
        }else{
            return new JsonResponse([
                'erorrs' => $form->getErrors(),
            ], 400);
        }

        
    }

    /**
     * @Route("/{id}", name="match_delete", methods={"DELETE"})
     */
    public function delete(Matchs $match, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($match);
        $entityManager->flush();

        return new JsonResponse([
            "message" => "Succefully deleted"
        ], 204);
    }
}
