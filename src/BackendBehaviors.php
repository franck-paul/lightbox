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

use Dotclear\Helper\Html\Form\Checkbox;
use Dotclear\Helper\Html\Form\Fieldset;
use Dotclear\Helper\Html\Form\Label;
use Dotclear\Helper\Html\Form\Legend;
use Dotclear\Helper\Html\Form\Para;

class BackendBehaviors
{
    public static function adminBlogPreferencesForm(): string
    {
        echo
        (new Fieldset('lightbox'))
        ->legend((new Legend(__('LightBox'))))
        ->fields([
            (new Para())->items([
                (new Checkbox('lightbox_enabled', My::settings()->enabled))
                    ->value(1)
                    ->label((new Label(__('Enable lightBox'), Label::INSIDE_TEXT_AFTER))),
            ]),
        ])
        ->render();

        return '';
    }

    public static function adminBeforeBlogSettingsUpdate(): string
    {
        My::settings()->put('enabled', !empty($_POST['lightbox_enabled']), 'boolean');

        return '';
    }
}
