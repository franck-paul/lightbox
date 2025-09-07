<?php

/**
 * @brief listImages, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Olivier Meunier
 *
 * @copyright Olivier Meunier
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
$this->registerModule(
    'lightBox',
    'lightBox like effect on images using jquery modal',
    'Olivier Meunier and contributors',
    '6.0',
    [
        'date'        => '2025-09-07T15:58:53+0200',
        'requires'    => [['core', '2.36']],
        'permissions' => 'My',
        'type'        => 'plugin',
        'settings'    => [
            'blog' => '#params.lightbox',
        ],

        'details'    => 'https://open-time.net/?q=lightbox',
        'support'    => 'https://github.com/franck-paul/lightbox',
        'repository' => 'https://raw.githubusercontent.com/franck-paul/lightbox/main/dcstore.xml',
        'license'    => 'gpl2',
    ]
);
