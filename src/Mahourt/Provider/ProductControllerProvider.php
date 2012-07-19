<?php

/**
 * This file is part of the Mahourt project.
 *
 * (c) Benjamin Grandfond <benjamin.grandfond@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mahourt\Provider;

use Silex\ControllerProviderInterface;
use Silex\Application;
use Silex\ControllerCollection;

/**
 * ProductControllerProvider class.
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class ProductControllerProvider implements ControllerProviderInterface
{
    /**
     * Returns routes to connect to the given application.
     *
     * @param Application $app An Application instance
     *
     * @return ControllerCollection A ControllerCollection instance
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/', function () use ($app) {
            $products = $app['db.orm.em']->getRepository('Mahourt\Entity\Product')->findAll();

            return $app['twig']->render('Product/list.html.twig', array(
                'products' => $products
            ));
        })
            ->bind('product_list');

        $controllers->post('/', function () use ($app) {
            $em = $app['db.orm.em'];

            $values = $app['request']->request->get('product');

            $product = new \Mahourt\Entity\Product();
            $product->setName($values['name']);
            $product->setQuantity($values['quantity']);

            $em->persist($product);
            $em->flush();

            return $app->redirect($app['url_generator']->generate('product_list'));
        })
            ->bind('product_new');

        $controllers->match('/{id}', function ($id) use ($app) {
            $em = $app['db.orm.em'];
            $product = $em->getRepository('Mahourt\Entity\Product')->find($id);

            if (true == $app['request']->isMethod('PUT')) {
                $values = $app['request']->request->get('product');

                $product->setName($values['name']);
                $product->setQuantity($values['quantity']);

                $em->persist($product);
                $em->flush();

                return $app->redirect($app['url_generator']->generate('product_edit', array(
                    'id' => $product->getId()
                )));
            }

            return $app['twig']->render('Product/edit.html.twig', array(
                'product' => $product
            ));
        })
            ->bind('product_edit')
            ->method('GET|PUT')
            ->convert('id', function ($id) { return (int) $id; });

        $controllers->delete('/{id}', function ($id) use ($app) {
            $em = $app['db.orm.em'];
            $product = $em->getRepository('Mahourt\Entity\Product')->find($id);
            $em->remove($product);

            return $app->redirect($app['url_generator']->generate('product_lsit'));
        })
            ->bind('product_delete')
            ->convert('id', function ($id) { return (int) $id; });

        return $controllers;
    }
}
