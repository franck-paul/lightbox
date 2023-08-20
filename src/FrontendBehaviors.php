<?php
/**
 * @brief lightbox, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Franck Paul and contributors
 *
 * @copyright Franck Paul carnet.franck.paul@gmail.com
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\lightbox;

use dcCore;
use dcUtils;

class FrontendBehaviors
{
    public static function publicHeadContent()
    {
        $settings = dcCore::app()->blog->settings->get(My::id());
        if (!$settings->enabled) {
            return;
        }

        echo
        My::cssLoad('modal.css') .
        My::jsLoad('modal.js') .
        dcUtils::jsJson('lightbox', [
            'url'        => dcCore::app()->blog->getQmarkURL() . 'pf=' . My::id(),
            'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'],
        ]) .
        My::jsLoad('public.js');
    }
}
