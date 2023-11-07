<?php
/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/*
 * IMPORTANT:
 * This is an example configuration file. Copy this file into your config directory and edit to
 * setup your app permissions.
 *
 * This is a quick roles-permissions implementation
 * Rules are evaluated top-down, first matching rule will apply
 * Each line define
 *      [
 *          'role' => 'role' | ['roles'] | '*'
 *          'prefix' => 'Prefix' | , (default = null)
 *          'plugin' => 'Plugin' | , (default = null)
 *          'controller' => 'Controller' | ['Controllers'] | '*',
 *          'action' => 'action' | ['actions'] | '*',
 *          'allowed' => true | false | callback (default = true)
 *      ]
 * You could use '*' to match anything
 * 'allowed' will be considered true if not defined. It allows a callable to manage complex
 * permissions, like this
 * 'allowed' => function (array $user, $role, Request $request) {}
 *
 * Example, using allowed callable to define permissions only for the owner of the Posts to edit/delete
 *
 * (remember to add the 'uses' at the top of the permissions.php file for Hash, TableRegistry and Request
   [
        'role' => ['user'],
        'controller' => ['Posts'],
        'action' => ['edit', 'delete'],
        'allowed' => function(array $user, $role, Request $request) {
            $postId = Hash::get($request->params, 'pass.0');
            $post = TableRegistry::getTableLocator()->get('Posts')->get($postId);
            $userId = Hash::get($user, 'id');
            if (!empty($post->user_id) && !empty($userId)) {
                return $post->user_id === $userId;
            }
            return false;
        }
    ],
 */

return [
    'CakeDC/Auth.permissions' => [
        //all bypass
        [
            'prefix' => false,
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => [
                // LoginTrait
                'socialLogin',
                'login',
                'logout',
                'socialEmail',
                'verify',
                // RegisterTrait
                'register',
                'validateEmail',
                // PasswordManagementTrait used in RegisterTrait
                'changePassword',
                'resetPassword',
                'requestResetPassword',
                // UserValidationTrait used in PasswordManagementTrait
                'resendTokenValidation',
                'linkSocial',
                //U2F actions
                'u2f',
                'u2fRegister',
                'u2fRegisterFinish',
                'u2fAuthenticate',
                'u2fAuthenticateFinish',
            ],
            'bypassAuth' => true,
        ],
        [
            'prefix' => false,
            'plugin' => 'CakeDC/Users',
            'controller' => 'SocialAccounts',
            'action' => [
                'validateAccount',
                'resendValidation',
            ],
            'bypassAuth' => true,
        ],
        [
            'prefix' => false,
            'controller' => 'Categories',
            'action' => [
                'api',
            ],
            'bypassAuth' => true,
        ],
        [
            'prefix' => false,
            'controller' => 'Topics',
            'action' => [
                'api',
            ],
            'bypassAuth' => true,
        ],
        [
            'prefix' => false,
            'controller' => 'Pathways',
            'action' => [
                'api',
                'rssfeed',
                'jsonfeed',
            ],
            'bypassAuth' => true,
        ],
        //admin role allowed to all the things
        [
            'role' => 'admin',
            'prefix' => '*',
            'extension' => '*',
            'plugin' => '*',
            'controller' => '*',
            'action' => '*',
        ],
        //specific actions allowed for the all roles in Users plugin
        [
            'role' => '*',
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => ['profile', 'logout', 'linkSocial', 'callbackLinkSocial'],
        ],
        [
            'role' => 'curator',
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => ['index','view','api','search'],
        ],
        [
            'role' => 'manager',
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => ['index','view','api','search'],
        ],
        [
            'role' => '*',
            'plugin' => 'CakeDC/Users',
            'controller' => 'Users',
            'action' => 'resetOneTimePasswordAuthenticator',
            'allowed' => function (array $user, $role, \Cake\Http\ServerRequest $request) {
                $userId = \Cake\Utility\Hash::get($request->getAttribute('params'), 'pass.0');
                if (!empty($userId) && !empty($user)) {
                    return $userId === $user['id'];
                }

                return false;
            }
        ],
        //all roles allowed to Pages/display
        [
            'role' => '*',
            'controller' => 'Pages',
            'action' => 'display',
        ],
        [
            'role' => '*',
            'controller' => 'Redirect',
            'action' => 'index',
        ],
        [
            'role' => '*',
            'controller' => 'Categories',
            'action' => ['index','view','api','home'],
        ],
        [
            'role' => '*',
            'controller' => 'Topics',
            'action' => ['index','view'],
        ],
        [
            'role' => '*',
            'controller' => 'Pathways',
            'action' => ['index','view','follow','status','contributions','search','find'],
        ],
        [
            'role' => 'curator',
            'controller' => 'Pathways',
            'action' => ['edit','add','delete','export','import'],
        ],
        [
            'role' => 'manager',
            'controller' => 'Pathways',
            'action' => ['publish','edit','add','delete','export','import'],
        ],
        [
            'role' => 'curator',
            'controller' => 'PathwaysSteps',
            'action' => ['reorder'],
        ],
        [
            'role' => 'manager',
            'controller' => 'PathwaysSteps',
            'action' => ['reorder'],
        ],
        [
            'role' => '*',
            'controller' => 'PathwaysUsers',
            'action' => ['follow','delete','pathways','complete'],
        ],
        [
            'role' => '*',
            'controller' => 'Steps',
            'action' => ['index','view','status'],
        ],
        [
            'role' => 'curator',
            'controller' => 'Steps',
            'action' => ['edit','add','delete','publishtoggle'],
        ],
        [
            'role' => 'manager',
            'controller' => 'Steps',
            'action' => ['edit','add','delete','publishtoggle'],
        ],
        [
            'role' => '*',
            'controller' => 'Activities',
            'action' => ['index','view','claim','find','like'],
        ],
        [
            'role' => 'curator',
            'controller' => 'Activities',
            'action' => ['edit','delete','add','addtopath','addacttostep','stepfind','getinfo','linkcheck','audit','flagged'],
        ],
        [
            'role' => 'curator',
            'controller' => 'ActivitiesSteps',
            'action' => ['edit','add','sort','requiredToggle','delete'],
        ],
        [
            'role' => 'manager',
            'controller' => 'Activities',
            'action' => ['edit','delete','add','addtopath','addacttostep','stepfind','getinfo','linkcheck','audit','flagged'],
        ],
        [
            'role' => 'manager',
            'controller' => 'ActivitiesSteps',
            'action' => ['edit','add','sort','requiredToggle','delete'],
        ],
        [
            'role' => '*',
            'controller' => 'ActivitiesUsers',
            'action' => ['delete','launches','complete','launch'],
        ],
        [
            'role' => '*',
            'controller' => 'Reports',
            'action' => ['add','reports'],
        ],
        [
            'role' => 'curator',
            'controller' => 'Reports',
            'action' => ['index','edit','add','closed','view'],
        ],
        [
            'role' => 'manager',
            'controller' => 'Reports',
            'action' => ['index','edit','add','closed','view','delete'],
        ],
        [
            'role' => 'user',
            'controller' => 'Reports',
            'action' => ['delete'],
            'allowed' => new \CakeDC\Auth\Rbac\Rules\Owner(
                ['ownerForeignKey' => 'user_id']
            )
        ],
        [
            'role' => '*',
            'controller' => 'Tags',
            'action' => ['index','view'],
        ],
        [
            'role' => 'curator',
            'controller' => 'Tags',
            'action' => ['edit','add'],
        ],
        [
            'role' => 'manager',
            'controller' => 'Tags',
            'action' => ['edit','add'],
        ],
        [
            'role' => '*',
            'controller' => 'ActivityTypes',
            'action' => ['index','view'],
        ],
        [
            'role' => 'curator',
            'controller' => 'ActivityTypes',
            'action' => ['edit','add'],
        ],
        [
            'role' => 'manager',
            'controller' => 'ActivityTypes',
            'action' => ['edit','add','delete'],
        ],
        [
            'role' => '*',
            'controller' => 'Questions',
            'action' => ['index','view'],
        ],
        [
            'role' => 'curator',
            'controller' => 'Questions',
            'action' => ['edit','add'],
        ],
        [
            'role' => 'manager',
            'controller' => 'Questions',
            'action' => ['edit','add','delete'],
        ],
        [
            'role' => '*',
            'plugin' => 'DebugKit',
            'controller' => '*',
            'action' => '*',
            'bypassAuth' => true,
        ],       
    ]
];
