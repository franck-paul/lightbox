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
    '7.0',
    [
        'date'        => '2026-08-03T10:02:50+0200',
        'requires'    => [['core', '2.39']],
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
