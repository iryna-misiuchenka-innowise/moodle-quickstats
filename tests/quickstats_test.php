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
            'periodstart'      => time() - 10,
            'periodend'        => time(),
            'timecreated'      => time()
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
    public function test_active_user_count(): void
    {
        global $DB;

        $this->resetAfterTest();

        $currentTime = time();

        $this->createTestUsers([
            $currentTime - (2 * DAYSECS),
            $currentTime - (5 * DAYSECS),
            $currentTime - (10 * DAYSECS),
        ]);

        set_config('days', 7, 'local_quickstats');
        $activeDays = (int)get_config('local_quickstats', 'days');

        $timeCutoff = $currentTime - ($activeDays * DAYSECS);

        $activeUserCount = $DB->count_records_select('user', "lastaccess >= ?", [$timeCutoff]);

        $this->assertEquals(
            2,
            $activeUserCount,
            get_string('active_user_count', 'local_quickstats')
        );
    }

    /**
     * Helper method to create test users with specific last access times.
     *
     * @param array $lastAccessTimes Array of timestamps for user 'lastaccess'.
     * @return void
     */
    private function createTestUsers(array $lastAccessTimes): void
    {
        foreach ($lastAccessTimes as $lastAccess) {
            $this->getDataGenerator()->create_user(['lastaccess' => $lastAccess]);
        }
    }
}
