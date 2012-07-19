<?php

/**
 * This file is part of the Mahourt project.
 *
 * (c) Benjamin Grandfond <benjamin.grandfond@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mahourt\Entity;

/**
 * Product class.
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 * @Entity
 * @Table(name="product")
 */
class Product
{
    /**
     * @var Integer
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var String
     * @Column(type="string")
     */
    private $name;

    /**
     * @var Integer
     * @Column(type="integer")
     */
    private $quantity;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}
