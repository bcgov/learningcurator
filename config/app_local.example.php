<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', 'f0728a4f953c8409221101ab521424f69830e813fdd726c3f7819efe112d503e'),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        
        /*'default' => [
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'curator',
            'password' => 'Learning1!',
            'database' => 'the_agent',
            //'schema' => 'myapp',
            'url' => env('DATABASE_URL', null),
        ],*/

        'default' => [
            'className' => 'Cake\Database\Connection',
            'driver' => 'Cake\Database\Driver\Sqlite',
            'persistent' => false,
            'host' => 'localhost',
            'port' => '',
            'login' => '',
            'password' => '',
            'database' => '/path/to/source/db/curator.db',
            'schema' => '',
            'prefix' => '',
            'encoding' => ''
        ],
        /*
         * The test connection is used during the test suite.
         */
        'test' => [
            'host' => 'localhost',
            //'port' => 'non_standard_port_number',
            'username' => 'my_app',
            'password' => 'secret',
            'database' => 'test_myapp',
            //'schema' => 'myapp',
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
