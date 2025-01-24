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

use advanced_testcase;

/**
 * Unit tests for the QuickStats plugin.
 *
 * This class includes tests for database interaction and active user count calculations.
 *
 * @package   local_quickstats
 * @category  test
 */
class quickstats_test extends advanced_testcase {

    /**
     * Test database interaction for storing and retrieving records.
     *
     * This test verifies that records can be successfully inserted into
     * and retrieved from the 'local_quickstats' database table.
     *
     * @return void
     */
    public function test_database_interaction() {
        global $DB;
    
        $this->resetAfterTest(true);
    
        $record = (object)[
            'activeuserscount' => '2',
            'periodstart' => time() - 10,
            'periodend' => time(),
            'timecreated' => time()
        ];
        $recordid = $DB->insert_record('local_quickstats', $record);
    
        $this->assertNotEmpty($DB->get_record('local_quickstats', ['id' => $recordid]));
    }

    /**
     * Test active user count calculation for a specific time range.
     *
     * This test verifies that the correct number of active users is calculated
     * based on their 'lastaccess' time and the configured active user range.
     *
     * @return void
     */
    public function test_active_user_count() {
        global $DB;

        $this->resetAfterTest();

        $user1 = $this->getDataGenerator()->create_user(['lastaccess' => time() - (2 * DAYSECS)]);
        $user2 = $this->getDataGenerator()->create_user(['lastaccess' => time() - (5 * DAYSECS)]);
        $user3 = $this->getDataGenerator()->create_user(['lastaccess' => time() - (10 * DAYSECS)]);

        set_config('days', 7, 'local_quickstats');

        $days = get_config('local_quickstats', 'days');
        $timecutoff = time()- ($days * DAYSECS);

        $expectedCount = $DB->count_records_select('user', "lastaccess >= ?", [$timecutoff]);

        $this->assertEquals(2, $expectedCount, 'The active user count should be 2 for the last 7 days.');
    }
}