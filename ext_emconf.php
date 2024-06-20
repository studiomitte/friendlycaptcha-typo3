<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Integration of Friendly Captcha',
    'description' => 'FriendlyCaptcha Integration for EXT:powermail and EXT:form and your custom implementation',
    'category' => 'plugin',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.9.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'StudioMitte\\FriendlyCaptcha\\' => 'Classes',
        ],
    ],
    'state' => 'beta',
    'version' => '0.1.5',
];
