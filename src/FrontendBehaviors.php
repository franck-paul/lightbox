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

use dcUtils;
use Dotclear\App;

class FrontendBehaviors
{
    public static function publicHeadContent(): string
    {
        $settings = My::settings();
        if (!$settings->enabled) {
            return '';
        }

        echo
        My::cssLoad('modal.css') .
        My::jsLoad('modal.js') .
        dcUtils::jsJson('lightbox', [
            'url'        => App::blog()->getQmarkURL() . 'pf=' . My::id(),
            'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'],
        ]) .
        My::jsLoad('public.js');

        return '';
    }
}
