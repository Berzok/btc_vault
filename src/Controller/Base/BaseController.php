<?php

declare(strict_types=1);

namespace App\Controller\Base;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BaseController extends AbstractController {

    protected ManagerRegistry $doctrine;
    protected Serializer $serializer;

    protected string $entity = '';

    public function __construct(ManagerRegistry $doctrine) {
        $this->doctrine = $doctrine;

        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer($classMetadataFactory)];

        $serializer = new Serializer($normalizers, $encoders);
        $this->serializer = $serializer;
    }
}