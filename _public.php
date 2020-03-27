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

if (!defined('DC_RC_PATH')) {return;}

$core->addBehavior('publicHeadContent', ['lightBoxPublic', 'publicHeadContent']);

class lightBoxPublic
{
    public static function publicHeadContent($core)
    {
        $core->blog->settings->addNameSpace('lightbox');
        if (!$core->blog->settings->lightbox->lightbox_enabled) {
            return;
        }

        echo
        dcUtils::cssLoad($core->blog->getPF('lightbox/css/modal.css')) .
        dcUtils::jsLoad($core->blog->getPF('lightbox/js/modal.js')) .
        dcUtils::jsJson('lightbox', [
            'url'        => $core->blog->getQmarkURL() . 'pf=' . basename(dirname(__FILE__)),
            'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']
        ]) .
        dcUtils::jsLoad($core->blog->getPF('lightbox/js/public.js'));
    }
}
