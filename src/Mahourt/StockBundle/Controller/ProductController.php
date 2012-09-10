<?php

namespace Mahourt\StockBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration as Extra;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Mahourt\StockBundle\Entity\Product;

/**
 * ProductController class.
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 *
 * @Extra\Route("/product", service="mahourt.product_controller_service")
 */
class ProductController extends ContainerAware
{
    /**
     * @Extra\Route("/search", name="product_search")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return array
     */
    public function searchAction(Request $request)
    {
        $products = $this->container
            ->get('doctrine.orm.entity_manager')
            ->getRepository('MahourtStockBundle:Product')
            ->findLike($request->query->get('q'));

        $results = array();

        array_map(function ($product) use (&$results) {
            $results[] = $product->getName();
        }, $products);

        return new JsonResponse($results);
    }

    /**
     * @Extra\Route("/new", name="product_new")
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        if ($request->isMethod('post')) {
            $product = new Product();
            $product->setName($request->request->get('product[name]'));
            $product->setQuantity($request->request->get('product[quantity]'));

            $this->container
                ->get('doctrine.orm.entity_manager')
                ->persist($product)
                ->flush();

            return new RedirectResponse($this->get('router')->generateUrl('homepage'));
        }

        return new JsonResponse(array(''));
    }
}
