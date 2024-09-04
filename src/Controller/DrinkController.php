<?php

namespace App\Controller;

use App\Controller\Base\ApiController;
use App\Entity\Drink;
use App\Form\DrinkType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/drink', name: 'drink_')]
class DrinkController extends ApiController {

    protected string $entity = Drink::class;

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/new', name: 'new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $drink = new Drink();
        $form = $this->createForm(DrinkType::class, $drink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($drink);
            $entityManager->flush();

            return $this->redirectToRoute('app_drink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('drink/new.html.twig', [
            'drink' => $drink,
            'form' => $form,
        ]);
    }

    /**
     * @param Request $request
     * @param Drink $drink
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'app_drink_update', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function update(Request $request, Drink $drink): JsonResponse {
        $form = $this->createForm(DrinkType::class, $drink);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->doctrine->getManager()->persist($drink);
            $this->doctrine->getManager()->flush();
        }

        return new JsonResponse([]);
    }
}
