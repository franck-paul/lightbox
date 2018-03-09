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

if (!defined('DC_CONTEXT_ADMIN')) {return;}

// dead but useful code, in order to have translations
__('lightBox') . __('lightBox like effect on images using jquery modal');

$core->addBehavior('adminBlogPreferencesForm', array('lightBoxBehaviors', 'adminBlogPreferencesForm'));
$core->addBehavior('adminBeforeBlogSettingsUpdate', array('lightBoxBehaviors', 'adminBeforeBlogSettingsUpdate'));

class lightBoxBehaviors
{
    public static function adminBlogPreferencesForm($core, $settings)
    {
        $settings->addNameSpace('lightbox');
        echo
        '<div class="fieldset"><h4>lightBox</h4>' .
        '<p><label class="classic">' .
        form::checkbox('lightbox_enabled', '1', $settings->lightbox->lightbox_enabled) .
        __('Enable lightBox') . '</label></p>' .
            '</div>';
    }

    public static function adminBeforeBlogSettingsUpdate($settings)
    {
        $settings->addNameSpace('lightbox');
        $settings->lightbox->put('lightbox_enabled', !empty($_POST['lightbox_enabled']), 'boolean');
    }
}
