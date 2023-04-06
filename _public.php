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
class lightBoxPublic
{
    public static function publicHeadContent()
    {
        if (!dcCore::app()->blog->settings->lightbox->lightbox_enabled) {
            return;
        }

        echo
        dcUtils::cssModuleLoad('lightbox/css/modal.css') .
        dcUtils::jsModuleLoad('lightbox/js/modal.js') .
        dcUtils::jsJson('lightbox', [
            'url'        => dcCore::app()->blog->getQmarkURL() . 'pf=' . basename(__DIR__),
            'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'],
        ]) .
        dcUtils::jsModuleLoad('lightbox/js/public.js');
    }
}

dcCore::app()->addBehavior('publicHeadContent', [lightBoxPublic::class, 'publicHeadContent']);
