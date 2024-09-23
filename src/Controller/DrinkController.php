<?php

namespace App\Controller;

use App\Controller\Base\ApiController;
use App\Entity\Drink;
use App\Form\DrinkType;
use App\Service\FileHandler;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/drink', name: 'drink_')]
class DrinkController extends ApiController {

    protected string $entity = Drink::class;

    /**
     * @param Request $request
     * @param FileHandler $fileHandler
     * @return Response
     */
    #[Route('', name: 'new', methods: ['POST', 'PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Denied.')]
    public function new(Request $request, FileHandler $fileHandler): Response {
        $data = $request->request->all();

        // Décoder les chaînes JSON pour drinkIngredients et etapes
        if (isset($data['drinkIngredients'])) {
            $data['drinkIngredients'] = json_decode($data['drinkIngredients'], true);
        }

        if (isset($data['etapes'])) {
            $data['etapes'] = json_decode($data['etapes'], true);
        }

        // Si l'ID est présent, on tente de charger l'entité existante
        if (isset($data['id'])) {
            $drink = $this->doctrine->getManager()->getRepository($this->entity)->find($data['id']);
        } else {
            $drink = new Drink();
        }

        $form = $this->createForm(DrinkType::class, $drink);
        $form->handleRequest($request);

        $files = $request->files->all();
        $form->submit(array_merge($data, $files));

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $filename = $fileHandler->upload($imageFile, 'images');
                $fileHandler->deleteImage($drink->getImage());
                $drink->setImage($filename);
            }

            $iconFile = $form->get('icon')->getData();
            if ($iconFile) {
                $filename = $fileHandler->upload($iconFile, 'images/icons');
                $fileHandler->deleteIcon($drink->getIcon());
                $drink->setIcon('icons/' . $filename);
            }


            $manager = $this->doctrine->getManager();
            $manager->persist($drink);
            $manager->flush();

            return $this->json([
                'status' => 'success',
                'message' => 'Update successful',
                'data' => [
                    'id' => $drink->getId(),
                    'name' => $drink->getName(),
                    'description' => $drink->getDescription(),
                    // Ajouter d'autres propriétés ici si nécessaire
                ]
            ], Response::HTTP_CREATED);
        }

        return $this->json([
            'status' => 'error',
            'message' => 'Erreur',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param int $id
     * @return BinaryFileResponse|JsonResponse
     */
    #[Route('/image/{id}', name: 'image', methods: ['GET'])]
    public function image(int $id): BinaryFileResponse|JsonResponse {
        // Récupérer l'objet Drink depuis la base de données
        $drink = $this->doctrine->getRepository($this->entity)->find($id);

        // Vérifier si le drink existe
        if (!$drink) {
            return $this->json(['error' => 'Drink not found'], Response::HTTP_NOT_FOUND);
        }

        // Récupérer la propriété 'image' qui contient le chemin relatif de l'image
        $imagePath = $drink->getImage();

        // Chemin absolu vers le fichier dans le dossier public
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/images/';
        $filePath = $publicDirectory . $imagePath;

        // Vérifier si le fichier existe
        if (!file_exists($filePath)) {
            return $this->json(['error' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }

        // Renvoyer le fichier en réponse
        try {
            $file = new File($filePath);
            return $this->file($file, null, ResponseHeaderBag::DISPOSITION_INLINE);
        } catch (FileNotFoundException $e) {
            return $this->json([
                'error' => 'File not found'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param int $id
     * @return BinaryFileResponse|JsonResponse
     */
    #[Route('/icon/{id}', name: 'image', methods: ['GET'])]
    public function icon(int $id): BinaryFileResponse|JsonResponse {
        // Récupérer l'objet Drink depuis la base de données
        $drink = $this->doctrine->getRepository($this->entity)->find($id);

        // Vérifier si le drink existe
        if (!$drink) {
            return $this->json(['error' => 'Drink not found'], Response::HTTP_NOT_FOUND);
        }

        // Récupérer la propriété 'image' qui contient le chemin relatif de l'icône
        $imagePath = $drink->getIcon();

        // Chemin absolu vers le fichier dans le dossier public
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/images/';
        $filePath = $publicDirectory . $imagePath;

        // Vérifier si le fichier existe
        if (!file_exists($filePath)) {
            return $this->json(['error' => 'Icon not found'], Response::HTTP_NOT_FOUND);
        }

        // Renvoyer le fichier en réponse
        try {
            $file = new File($filePath);
            return $this->file($file, null, ResponseHeaderBag::DISPOSITION_INLINE);
        } catch (FileNotFoundException $e) {
            return $this->json([
                'error' => 'File not found'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
