<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Integration of Friendly Captcha',
    'description' => 'FriendlyCaptcha Integration for EXT:powermail and EXT:form and your custom implementation',
    'category' => 'plugin',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.5-13.4.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'StudioMitte\\FriendlyCaptcha\\' => 'Classes',
        ],
    ],
    'state' => 'stable',
    'version' => '2.1.0',
];
