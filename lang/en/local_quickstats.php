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

$string['pluginname']            = 'QuickStats';
$string['enable']                = 'Enable QuickStats';
$string['enable_desc']           = 'Enable or disable the QuickStats plugin';
$string['days']                  = 'Number of active days';
$string['days_desc']             = 'Specify the number of days to consider a user as active';
$string['active_users']          = 'Active Users';
$string['active_users_count']    = 'There are currently {$a} active users';
$string['refresh_button']        = 'Refresh Statistics';
$string['refresh_success']       = 'Statistics updated successfully!';
$string['plugin_disabled']       = 'QuickStats plugin is disabled';
$string['active_user_count_err'] = 'The active user count should be 2 for the last 7 days.';
