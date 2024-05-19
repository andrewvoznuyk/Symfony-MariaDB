<?php

namespace App\EntityListener;

namespace App\EntityListener;

use App\Entity\Excursion;
use App\Entity\ProductType;
use App\Entity\User;
use DateTime;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;
class ProductTypeEntityListener
{

    /**
     * @param ProductType $productType
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function preRemove(ProductType $productType, LifecycleEventArgs $eventArgs): void
    {
        foreach ($productType->getProducts() as $product){
            $product->setType(null);
        }
    }

}
