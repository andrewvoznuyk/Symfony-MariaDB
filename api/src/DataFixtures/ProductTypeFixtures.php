<?php

namespace App\DataFixtures;

use App\Entity\ProductType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = ['type-1', 'type-2', 'type-3'];

        foreach ($types as $typeName) {
            $productType = new ProductType();
            $productType->setTypeName($typeName);
            $productType->setDescription('Description for ' . $typeName);

            $manager->persist($productType);
        }

        $manager->flush();
    }
}