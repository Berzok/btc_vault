<?php

namespace App\Controller;

use App\Controller\Base\ApiController;
use App\Entity\Ingredient;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ingredient')]
class IngredientController extends ApiController {

    protected string $entity = Ingredient::class;
}
