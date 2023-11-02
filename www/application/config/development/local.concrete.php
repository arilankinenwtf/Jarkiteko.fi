<?php
// poista/kommentoi alla olevat rivit, jos Concrete5:ssä tulee errori
// PATH_INFO tai ORIG_PATH_INFO liittyen
return [
    'session' => [
        'handler' => 'database'
    ],
    'seo' => [
        'url_rewriting' => true,
    ],
    'cache' => [
        'blocks' => false,
        'assets' => false,
        'theme_css' => false,
        'overrides' => false,
        'pages' => '0',
        'full_page_lifetime' => 'default',
        'full_page_lifetime_value' => null,
    ],
    'theme' => [
        'compress_preprocessor_output' => false,
        'generate_less_sourcemap' => false,
    ],
    'debug' => [
        'display_errors' => true,
        'detail' => 'debug',
    ],
];