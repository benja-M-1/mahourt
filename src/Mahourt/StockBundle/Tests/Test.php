<?php

namespace Mahourt\StockBundle\Tests;

$baseDir = __DIR__.'/../../../../';
require_once $baseDir.'/app/bootstrap.php.cache';

use mageekguy\atoum;

/**
 * Test class.
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
abstract class Test extends atoum\test
{
    /**
     * @param \mageekguy\atoum\factory $factory
     */
    public function __construct(atoum\factory $factory = null)
    {
         $this->setTestNamespace('Tests');
         parent::__construct($factory);
    }
}
