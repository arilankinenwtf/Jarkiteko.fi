<?php
// Tämä asetus mahdollistaa Concreten käytön Zonerissa:
// (ilman tätä aiheutuu is_dir() error)
return array(
    'session' => array(
        'handler' => 'database'
    )
);