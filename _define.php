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
if (!defined('DC_RC_PATH')) {
    return;
}

$this->registerModule(
    'lightBox',                                          // Name
    'lightBox like effect on images using jquery modal', // Description
    'Olivier Meunier and contributors',                  // Author
    '1.6.1',
    [
        'requires'    => [['core', '2.23']],                        // Dependencies
        'permissions' => 'admin',                                   // Permissions
        'type'        => 'plugin',                                  // Type
        'settings'    => [
            'blog' => '#params.lightbox',
        ],

        'details'    => 'https://open-time.net/?q=lightbox',       // Details URL
        'support'    => 'https://github.com/franck-paul/lightbox', // Support URL
        'repository' => 'https://raw.githubusercontent.com/franck-paul/lightbox/master/dcstore.xml',
    ]
);
