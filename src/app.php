<?php

/**
 * This file is part of the Mahourt project.
 *
 * (c) Benjamin Grandfond <benjamin.grandfond@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

$loader = require_once __DIR__ . '/../vendor/autoload.php';

$app = new Mahourt\Application();
$app->configure();

$app->get('/', function () use ($app) {
    return $app->redirect($app['url_generator']->generate('product_list'));
})
->bind('homepage');

return $app;
