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

namespace local_quickstats\task;

use core\task\scheduled_task;

/**
 * Task to update active user statistics.
 *
 * This scheduled task calculates the number of active users
 * within a specific period and stores the result in the database.
 *
 * @package   local_quickstats
 */
class update_active_users extends scheduled_task
{

    /**
     * Get the task's name.
     *
     * This name will be displayed in the scheduled tasks page.
     *
     * @return string Task name.
     */
    public function get_name()
    {
        return get_string('taskname', 'local_quickstats');
    }

    /**
     * Execute the scheduled task.
     *
     * This method calculates the number of active users
     * within a specific period and saves the data into the database table.
     *
     * @return void
     */
    public function execute()
    {
        global $DB;

        $days = get_config('local_quickstats', 'days');
        $time = (time() - ($days * DAYSECS));

        $count = $DB->count_records_select('user', 'lastaccess >= ?', [$time]);

        $record = (object)[
            'activeuserscount' => $count,
            'periodstart'      => $time,
            'periodend'        => time(),
            'timecreated'      => time()
        ];

        $DB->insert_record('local_quickstats', $record);

    }
}
