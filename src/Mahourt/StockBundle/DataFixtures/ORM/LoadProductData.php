<?php

namespace Mahourt\StockBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mahourt\StockBundle\Entity\Product;

/**
 * LoadProductData class.
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class LoadProductData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $milk = new Product();
        $milk->setName('Milk');
        $milk->setQuantity(1);

        $coffee = new Product();
        $coffee->setName('Coffee');
        $coffee->setQuantity(2);

        $manager->persist($milk);
        $manager->persist($coffee);

        $manager->flush();
    }
}
