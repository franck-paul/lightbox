<?php
/**
 * @brief lightbox, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugins
 *
 * @author Jean-Christian Denis, Franck Paul and contributors
 *
 * @copyright Jean-Christian Denis, Franck Paul
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
declare(strict_types=1);

namespace Dotclear\Plugin\lightbox;

use dcCore;
use dcNamespace;
use Dotclear\Core\Process;
use Exception;

class Install extends Process
{
    public static function init(): bool
    {
        return self::status(My::checkContext(My::INSTALL));
    }

    public static function process(): bool
    {
        if (!self::status()) {
            return false;
        }

        try {
            // Update
            $old_version = dcCore::app()->getVersion(My::id());
            if (version_compare((string) $old_version, '3.0', '<')) {
                // Change settings names (remove lightbox_ prefix in them)
                $rename = function (string $name, dcNamespace $settings): void {
                    if ($settings->settingExists('lightbox_' . $name, true)) {
                        $settings->rename('lightbox_' . $name, $name);
                    }
                };
                $settings = My::settings();
                foreach (['enabled'] as $name) {
                    $rename($name, $settings);
                }
            }

            // Init
            $settings = My::settings();
            $settings->put('enabled', false, dcNamespace::NS_BOOL, '', false, true);
        } catch (Exception $e) {
            dcCore::app()->error->add($e->getMessage());
        }

        return true;
    }
}
