<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary' => env('pdf'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => env('img'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
