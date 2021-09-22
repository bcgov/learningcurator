<?php 
use Cake\Routing\Router;
$config = ['Users' => 
                ['Social' => 
                        ['login' => true]
                ],
                'Email' => [
                        // determines if the user should include email
                        'required' => true,
                        // determines if registration workflow includes email validation
                        'validate' => false,
                    ],
                'OAuth' => [
                        'providers' => [
                                'azuread' => [
                                        'service' => 'CakeDC\Auth\Social\Service\OAuth2Service',
                                        'className' => 'TheNetworg\OAuth2\Client\Provider\Azure',
                                        'mapper' => 'CakeDC\Auth\Social\Mapper\Azure',
                                        'options' => [
                                                'userFields' => ['email', 'full_name'],
                                                'redirectUri' => Router::fullBaseUrl() . '/auth/azuread',
                                                'linkSocialUri' => Router::fullBaseUrl() . '/link-social/azuread',
                                                'callbackLinkSocialUri' => Router::fullBaseUrl() . '/callback-link-social/azuread',
                                        ]
                                ]
                        ]
                        ],
                'Auth' => [
                        'AuthenticationComponent' => [
                                'load' => true,
                                'loginRedirect' => '/profile/pathways',
                                'requireIdentity' => false
                        ],
                ]
            ];
return $config;