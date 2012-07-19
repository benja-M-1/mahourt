<?php

/**
 * This file is part of the Mahourt project.
 *
 * (c) Benjamin Grandfond <benjamin.grandfond@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mahourt;

use Silex\Application as BaseApplication;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Nutwerk\Provider\DoctrineORMServiceProvider;

/**
 * Application class.
 *
 * @author Benjamin Grandfond <benjamin.grandfond@gmail.com>
 */
class Application extends BaseApplication
{
    public function configure()
    {
        $this['root_dir']   = realpath(__DIR__.'/../..');
        $this['src_dir']    = realpath(__DIR__);
        $this['vendor_dir'] = $this['root_dir'].'/vendor';
        $this['cache_dir']  = $this['root_dir'].'/cache';
        $this['log_dir']    = $this['root_dir'].'/log';
        $this['view_dir']   = $this['src_dir'].'/Resources/views';

        if (isset($_SERVER, $_SERVER['REMOTE_ADDR'])) {
            $this['debug'] = $_SERVER['REMOTE_ADDR'] === '127.0.0.1' || $_SERVER['REMOTE_ADDR'] === '::1';
        }

        if (false == file_exists($this['cache_dir'])) {
            mkdir($this['cache_dir']);
        }

        if (false == file_exists($this['log_dir'])) {
            mkdir($this['log_dir']);
        }

        $this->register(new MonologServiceProvider(), array(
            'monolog.logfile' => $this['log_dir'].'/development.log',
        ));

        $this->register(new TwigServiceProvider(), array(
            'twig.options' => array(
                'debug' => $this['debug'],
                'cache' => $this['cache_dir'],
            ),
            'twig.path' => array($this['view_dir']),
        ));

        $this['twig'] = $this->share($this->extend('twig', function($twig, $app) {
            $twig->addGlobal('layout', 'layout.html.twig');

            return $twig;
        }));

        $this->register(new UrlGeneratorServiceProvider());

        $this->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver'   => 'pdo_sqlite',
                'path'     => __DIR__.'/app.db',
            ),
        ));

        $this->register(new DoctrineORMServiceProvider(), array(
            'db.orm.proxies_dir'           => $this['cache_dir'].'/doctrine/Proxy',
            'db.orm.entities'              => array(array(
                'type'      => 'annotation',
                'path'      => __DIR__.'/Entity/',
                'namespace' => 'Mahourt\Entity',
            )),
        ));

        $this->mount('/products', new \Mahourt\Provider\ProductControllerProvider());
    }
}
