<?php

declare(strict_types=1);

namespace App\Controller\Base;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api", name="api_")
 */
#[Route('/', name: 'api_')]
class ApiController extends BaseController {

    protected ManagerRegistry $doctrine;
    protected Serializer $serializer;
    protected string $entity = '';

    /**
     * @return JsonResponse
     */
    #[Route('/all', name: 'get_all')]
    public function getAll(): Response {
        $data = $this->doctrine->getRepository($this->entity)->findAll();

        $json = $this->serializer->serialize($data, 'json');
        return JsonResponse::fromJsonString($json, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/{id}', name: 'get_by_id', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function get(int $id): JsonResponse {
        $data = $this->doctrine->getManager()->find($this->entity, $id);

        $json = $this->serializer->serialize($data, 'json');
        return JsonResponse::fromJsonString($json, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return Response
     */
    #[Route('/{id}', name: 'delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): Response {
        $em = $this->doctrine->getManager();
        $data = $em->find($this->entity, $id);

        $em->remove($data);
        $em->flush();
        return new JsonResponse('ok');
    }
}
