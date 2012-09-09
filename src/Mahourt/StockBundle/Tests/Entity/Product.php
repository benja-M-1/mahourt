<?php

namespace Mahourt\StockBundle\Tests\Entity;

require_once __DIR__.'/../Test.php';

use Mahourt\StockBundle\Tests\Test;
use Mahourt\StockBundle\Entity;

/**
 * ProductTest class.
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class Product extends Test
{
    /**
     * @dataProvider valuesProvider
     */
    public function testSetGet($name, $value)
    {
        $this
            ->assert(sprintf('set "%s" get "%s"', $name, $value))
                ->if($product = new Entity\Product())
                ->and($setter = "set".ucfirst($name))
                ->and($getter = "get".ucfirst($name))
                ->and($product->$setter($value))
                ->then()
                    ->variable( $product->$getter())->isEqualTo($value);
    }

    public function valuesProvider()
    {
        return array(
            array('name', 'foo'),
            array('quantity', 2)
        );
    }
}
