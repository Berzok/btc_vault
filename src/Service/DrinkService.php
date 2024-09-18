<?php

namespace App\Service;

use App\Entity\Drink;
use App\Entity\DrinkIngredients;
use App\Entity\Etape;
use App\Entity\Ingredient;
use App\Repository\DrinkIngredientsRepository;
use App\Repository\DrinkRepository;
use App\Repository\EtapeRepository;
use App\Repository\IngredientRepository;
use Symfony\Component\HttpFoundation\Request;

class DrinkService {

    private DrinkRepository $drinkRepository;
    private DrinkIngredientsRepository $drinkIngredientRepository;
    private IngredientRepository $ingredientRepository;
    private EtapeRepository $etapeRepository;

    public function __construct(DrinkRepository            $drinkRepository,
                                DrinkIngredientsRepository $drinkIngredientsRepository,
                                IngredientRepository       $ingredientRepository,
                                EtapeRepository            $etapeRepository) {
        $this->drinkRepository = $drinkRepository;
        $this->ingredientRepository = $ingredientRepository;
        $this->drinkIngredientRepository = $drinkIngredientsRepository;
        $this->etapeRepository = $etapeRepository;
    }

    public function assignDataToDrink(array $data): Drink {
        //Est-ce qu'il s'agit d'une création ou d'une modification ?
        if ($data['id']) {
            $drink = $this->drinkRepository->find($data['id']);
        } else {
            $drink = new Drink();
        }

        $drink->setName($data['name']);
        $drink->setDescription($data['description']);
        $drink->setIcon($data['icon']);
        $drink->setImage($data['image']);


        foreach ($data['drinkIngredients'] as $drinkIngredientArray) {
            //Même raisonnement que le IF précédent
            if ($drinkIngredientArray['id']) {
                $drinkIngredient = $this->drinkIngredientRepository->find($drinkIngredientArray['id']);
            } else {
                $drinkIngredient = new DrinkIngredients();
            }

            $drinkIngredient->setDrink($drink);
            $drinkIngredient->setUnit($drinkIngredientArray['unit']);
            $drinkIngredient->setQuantity($drinkIngredientArray['quantity']);

            if ($drinkIngredientArray['ingredient']['id']) {
                $ingredient = $this->ingredientRepository->find($drinkIngredientArray['ingredient']['id']);
            } else {
                $ingredient = new Ingredient();
            }
            $ingredient->setName($drinkIngredientArray['ingredient']['name']);
            $ingredient->setKarmotrine($drinkIngredientArray['ingredient']['karmotrine']);

            $drinkIngredient->setIngredient($ingredient);
            $drink->addDrinkIngredient($drinkIngredient);
        }

        foreach ($data['etapes'] as $etapeArray) {
            if ($etapeArray['id']) {
                $etape = $this->etapeRepository->find($etapeArray['id']);
            } else {
                $etape = new Etape();
            }
            $etape->setDrink($drink);
            $etape->setStep($etapeArray['step']);
            $etape->setContent($etapeArray['content']);

            $drink->addEtape($etape);
        }

        return $drink;
    }

    public function decodeMultipartRequest(Request $request): Drink {
        $drink = new Drink();

        // Récupérer les données envoyées via le formulaire multipart
        $name = $request->request->get('name'); // Récupère le champ "name"
        $description = $request->request->get('description'); // Récupère le champ "description"
        $icon = $request->request->get('icon');
        $image = $request->request->get('image');
        dd($request->request->get('id'));

        return $drink;
    }
}
