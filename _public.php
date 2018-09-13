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

        $url = $core->blog->getQmarkURL() . 'pf=' . basename(dirname(__FILE__));
        echo
        '<style type="text/css">' . "\n" .
        '@import url(' . $url . '/css/modal.css);' . "\n" .
        "</style>\n" .
        '<script type="text/javascript" src="' . $url . '/js/modal.js"></script>' . "\n" .
        '<script type="text/javascript">' . "\n" .
        '$(function() {' . "\n" .
        'var lb_settings = {' . "\n" .
        "loader_img : '" . html::escapeJS($url) . "/img/loader.gif',\n" .
        "prev_img   : '" . html::escapeJS($url) . "/img/prev.png',\n" .
        "next_img   : '" . html::escapeJS($url) . "/img/next.png',\n" .
        "close_img  : '" . html::escapeJS($url) . "/img/close.png',\n" .
        "blank_img  : '" . html::escapeJS($url) . "/img/blank.gif'\n" .
            "};" .
            '$("div.post").each(function() {' . "\n" .
            '$(this).find(\'a[href$=".jpg"],a[href$=".jpeg"],a[href$=".png"],a[href$=".gif"],' .
            'a[href$=".JPG"],a[href$=".JPEG"],a[href$=".PNG"],a[href$=".GIF"]\').modalImages(lb_settings);' . "\n" .

            "})\n" .
            "});\n" .
            "</script>\n";
    }
}
