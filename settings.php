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
 * This plugin provides access to Moodle data in form of analytics and reports in real time.
 *
 *
 * @package   quickstats
 * @copyright Copyright (c) 2025 Innowise (https://innowise.com)
 * @license   http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $settings = new admin_settingpage(
        'local_quickstats',
        get_string('pluginname', 'local_quickstats')
    );

    $settings->add(new admin_setting_configcheckbox(
        'local_quickstats/enable',
        get_string('enable', 'local_quickstats'),
        get_string('enable_desc', 'local_quickstats'),
        0
    ));

    $settings->add(new admin_setting_configtext(
        'local_quickstats/days',
        get_string('days', 'local_quickstats'),
        get_string('days_desc', 'local_quickstats'),
        30,
        PARAM_INT
    ));

    $ADMIN->add('localplugins', $settings);
}
