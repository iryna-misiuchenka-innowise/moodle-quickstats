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

require_once(__DIR__.'/../../config.php');

require_login();
$context = context_system::instance();
require_capability('moodle/site:config', $context);

$PAGE->set_url('/local/quickstats/index.php');
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'local_quickstats'));
$PAGE->set_heading(get_string('pluginname', 'local_quickstats'));
$PAGE->requires->js_call_amd('local_quickstats/chart', 'init');

echo $OUTPUT->header();

if (!get_config('local_quickstats', 'enable')) {
    echo $OUTPUT->notification(get_string('plugin_disabled', 'local_quickstats'), 'error');
    echo $OUTPUT->footer();
    exit;
}

$days = get_config('local_quickstats', 'days');
global $DB;

$time = (time() - ($days * DAYSECS));
$activeUsers = $DB->count_records_select('user', 'lastaccess >= ?', [$time]);

if (optional_param('refresh', false, PARAM_BOOL)) {
    $record                   = new \stdClass();
    $record->activeuserscount = $activeUsers;
    $record->periodstart      = $time;
    $record->periodend        = time();
    $record->timecreated      = time();
    $DB->insert_record('local_quickstats', $record);

    redirect(
        $PAGE->url,
        get_string('refresh_success', 'local_quickstats'),
        null,
        \core\output\notification::NOTIFY_SUCCESS
    );
}

$sql = "SELECT timecreated, activeuserscount 
          FROM {local_quickstats} 
      ORDER BY timecreated DESC 
         LIMIT 10";

$records = $DB->get_records_sql($sql);

$data = [];
foreach ($records as $record) {
    $data[] = [
        'time'  => date('Y-m-d', $record->timecreated),
        'count' => $record->activeuserscount,
    ];
}

echo html_writer::tag('h3', get_string('active_users', 'local_quickstats'));

echo html_writer::div(
    get_string('active_users_count', 'local_quickstats', $activeUsers),
    'active-users-count'
);

echo html_writer::start_tag('form', ['method' => 'post', 'action' => $PAGE->url->out()]);
echo html_writer::empty_tag('input',
    [
        'type'  => 'submit',
        'name'  => 'refresh',
        'value' => get_string('refresh_button', 'local_quickstats'),
        'class' => 'btn btn-primary',
    ]
);
echo html_writer::end_tag('form');

echo html_writer::div('',
    'chart-container',
    [
        'id'              => 'quickstats-chart',
        'data-chart-data' => json_encode($data),
    ]
);

echo $OUTPUT->footer();
