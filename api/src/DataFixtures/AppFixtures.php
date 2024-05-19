<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\ProductType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $types = $manager->getRepository(ProductType::class)->findAll();

        for ($i = 1; $i <= 100; $i++) {
            $product = new Product();
            $product->setCode(mt_rand(1, 10));
            $product->setProductName('Product ' . $i);
            $product->setPrice(mt_rand(10000, 100000) / 100);
            $product->setType($types[array_rand($types)]);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductTypeFixtures::class,
        ];
    }
}