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
 * Install
 *
 * @package    local_legacy_icons
 * @copyright  2023 mattandor By CentricApp <mattan@centricapp.co.il>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Perform the post-install procedures.
 */
function xmldb_local_legacy_icons_install() {
    global $DB, $CFG;

    $mods = $DB->get_records('modules');
    foreach ($mods as $mod) {

        $types = ['png', 'svg'];
        foreach ($types as $type) {
            $sourcepath = $CFG->dirroot . '/local/legacy_icons/pix_plugins/mod/' . $mod->name . '/monologo.' . $type;
            $destinationpath = $CFG->dataroot . '/pix_plugins/mod/' . $mod->name . '/monologo.' . $type;

            // Check if the destination directory exists, and create it if not.
            if (!file_exists($CFG->dataroot . '/pix_plugins/mod/' . $mod->name)) {
                mkdir($CFG->dataroot . '/pix_plugins/mod/' . $mod->name, 0777, true);
            }

            // Use the copy function to copy the file.
            if (copy($sourcepath, $destinationpath)) {
                mtrace('Activity "' . $mod->name . '" copied successfully.');
            }
        }
    }

    // Purge all caches.
    purge_all_caches();

    // Output a success message.
    mtrace('All caches purged successfully.');

    return true;
}
