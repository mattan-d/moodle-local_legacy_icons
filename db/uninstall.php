<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * uninstall
 *
 * @package    local_legacy_icons
 * @copyright  2023 mattandor By CentricApp <mattan@centricapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Custom uninstallation procedure.
 */
function xmldb_local_legacy_icons_uninstall() {
    global $DB, $CFG;

    $mods = $DB->get_records('modules');

    foreach ($mods as $mod) {
        $dir = $CFG->dataroot . '/pix_plugins/mod/' . $mod->name;
        $files = array_diff(scandir($dir), array('.', '..'));

        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            mtrace($path);
            unlink($path);
        }

        rmdir($dir);
    }

    rmdir($CFG->dataroot . '/pix_plugins/mod');

    // Purge all caches.
    purge_all_caches();

    // Output a success message.
    mtrace('All caches purged successfully.');

    return true;
}