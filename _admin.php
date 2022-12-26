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
if (!defined('DC_CONTEXT_ADMIN')) {
    return;
}

// dead but useful code, in order to have translations
__('lightBox') . __('lightBox like effect on images using jquery modal');

class lightBoxBehaviors
{
    public static function adminBlogPreferencesForm($settings)
    {
        echo
        '<div class="fieldset"><h4 id="lightbox">lightBox</h4>' .
        '<p><label class="classic">' .
        form::checkbox('lightbox_enabled', '1', $settings->lightbox->lightbox_enabled) .
        __('Enable lightBox') . '</label></p>' .
            '</div>';
    }

    public static function adminBeforeBlogSettingsUpdate($settings)
    {
        $settings->lightbox->put('lightbox_enabled', !empty($_POST['lightbox_enabled']), 'boolean');
    }
}

dcCore::app()->addBehaviors([
    'adminBlogPreferencesFormV2'    => [lightBoxBehaviors::class, 'adminBlogPreferencesForm'],
    'adminBeforeBlogSettingsUpdate' => [lightBoxBehaviors::class, 'adminBeforeBlogSettingsUpdate'],
]);
