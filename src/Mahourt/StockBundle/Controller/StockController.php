<?php

namespace Mahourt\StockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;

class StockController extends Controller
{
    /**
     * @Extra\Route("/")
     * @Extra\Template()
     */
    public function listAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('MahourtStockBundle:Product')
            ->findAll();

        return array('products' => $products);
    }
}
