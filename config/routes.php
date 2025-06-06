<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

/*
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 */
/** @var \Cake\Routing\RouteBuilder $routes */
$routes->setRouteClass(DashedRoute::class);

$routes->scope('/', function (RouteBuilder $builder) {
    /*
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use 
     */
    $builder->connect('/', ['controller' => 'PathwaysUsers', 'action' => 'pathways']);

    // Redirect old page to new location (301)
    $builder->connect('/p/anti-racism-in-the-british-columbia-public-service', [], [
        'redirect' => 'https://learningcentre.gww.gov.bc.ca/learninghub/course/anti-racism-in-the-bc-public-service/',
        'status' => 301
    ]);
    $builder->connect('/topic/equity-diversity-and-inclusion/106/anti-racism-in-the-british-columbia-public-service', [], [
        'redirect' => 'https://learningcentre.gww.gov.bc.ca/learninghub/course/anti-racism-in-the-bc-public-service/',
        'status' => 301
    ]);

    /*
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $builder->connect('/pages/*', 'Pages::display');

    $builder->connect('/find', ['controller' => 'Activities', 'action' => 'find'])->setPass(['search']);
    
    $builder->connect('/loginredirect', ['controller' => 'Redirect', 'action' => 'index']);

    // main category view
    $builder->connect('/category/{id}/{slug}', ['controller' => 'Categories', 'action' => 'view'])->setPass(['id']);

    //$builder->connect('/pathways-users/delete', ['controller' => 'PathwaysUsers', 'action' => 'delete']);
    $builder->connect('/pathways/add', ['controller' => 'Pathways', 'action' => 'add']);
    $builder->connect('/pathways/find', ['controller' => 'Pathways', 'action' => 'find']);
    $builder->connect('/pathways/rssfeed', ['controller' => 'Pathways', 'action' => 'rssfeed']);
    $builder->connect('/pathways/jsonfeed', ['controller' => 'Pathways', 'action' => 'jsonfeed']);
    $builder->connect('/pathways/search', ['controller' => 'Pathways', 'action' => 'search']);
    $builder->connect('/pathways-steps/reorder', ['controller' => 'PathwaysSteps', 'action' => 'reorder']);
    $builder->connect('/pathways/import/{topicid}', ['controller' => 'Pathways', 'action' => 'import'])->setPass(['topicid']);
    
    
    
    
    /** 
     * 
     * THE NEW HOTNESS
     * https://www.hanselman.com/blog/urls-are-ui
     * 
     */
    $builder->connect('/topic/{slug}', ['controller' => 'Topics', 'action' => 'view'])->setPass(['slug']);
    $builder->connect('/topic/{topicslug}/{pathwayid}/{pathwayslug}', ['controller' => 'Pathways', 'action' => 'view'])->setPass(['pathwayslug']);
    $builder->connect('/p/{pathwayslug}', ['controller' => 'Pathways', 'action' => 'view'])->setPass(['pathwayslug']);


    $builder->connect('/a/{pathwayslug}/launchreport', ['controller' => 'Pathways', 'action' => 'launchreport'])->setPass(['pathwayslug']);
    $builder->connect('/stats', ['controller' => 'Topics', 'action' => 'stats']);
    
    
    $builder->connect('/topic/{topicslug}/{pathwayid}/{pathwayslug}/{stepid}/{stepslug}', ['controller' => 'Steps', 'action' => 'view'])->setPass(['stepid']);
    $builder->connect('/s/{stepid}', ['controller' => 'Steps', 'action' => 'view'])->setPass(['stepid']);
    $builder->connect('/a/{pathwayslug}', ['controller' => 'Pathways', 'action' => 'all'])->setPass(['pathwayslug']);
    
    /** 
     * 
     * END THE NEW HOTNESS
     * 
     */






    $builder->connect('/{categoryslug}/{topicslug}/pathway/{slug}', ['controller' => 'Pathways', 'action' => 'view'])->setPass(['slug']);
    $builder->connect('/pathways/{slug}', ['controller' => 'Pathways', 'action' => 'view'])->setPass(['slug']);
    $builder->connect('/pathways/{pathslug}/s/{stepid}/{stepslug}', ['controller' => 'Steps', 'action' => 'view'])->setPass(['stepid']);


    $builder->connect('/pathways/{slug}/export', ['controller' => 'Pathways', 'action' => 'export'])->setPass(['slug']);
    $builder->connect('/pathways/{id}/publish', ['controller' => 'Pathways', 'action' => 'publish'])->setPass(['id']);
    $builder->connect('/{categoryslug}/{topicslug}/pathway/{pathslug}/s/{stepid}/{stepslug}', ['controller' => 'Steps', 'action' => 'view'])->setPass(['stepid']);

    $builder->connect('/profile/launches', ['controller' => 'ActivitiesUsers', 'action' => 'launches']);
    $builder->connect('/profile/follows', ['controller' => 'PathwaysUsers', 'action' => 'pathways']);
    $builder->connect('/profile/reports', ['controller' => 'Reports', 'action' => 'reports']);
    $builder->connect('/profile/contributions', ['controller' => 'Pathways', 'action' => 'contributions']);
    /*
     * Connect catchall routes for all controllers.
     *
     * The `fallbacks` method is a shortcut for
     *
     * ```
     * $builder->connect('/:controller', ['action' => 'index']);
     * $builder->connect('/:controller/:action/*', []);
     * ```
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $builder->fallbacks();
});

/*
 * If you need a different set of middleware or none at all,
 * open new scope and define routes there.
 *
 * ```
 * $routes->scope('/api', function (RouteBuilder $builder) {
 *     // No $builder->applyMiddleware() here.
 *     
 *     // Parse specified extensions from URLs
 *     // $builder->setExtensions(['json', 'xml']);
 *     
 *     // Connect API actions here.
 * });
 * ```
 */
