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
 * The mod_offlinequiz edit page viewed event.
 *
 * @package    mod_offlinequiz
 * @author  2014 Juergen Zimmer <zimmerj7@univie.ac.at>
 * @copyright 2014 Academic Moodle Cooperation {@link http://www.academic-moodle-cooperation.org}
 * @since Moodle 2.7
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_offlinequiz\event;

defined('MOODLE_INTERNAL') || die();

/**
 * The mod_offlinequiz edit page viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int offlinequizid: the id of the offlinequiz.
 * }
 *
 * @package    mod_offlinequiz
 * @since      Moodle 2.7
 * @copyright  2014 Juergen Zimmer <zimmerj7@univie.ac.at>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class edit_page_viewed extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventeditpageviewed', 'mod_offlinequiz');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the edit page for the offlinequiz with " .
            "the course module id '$this->contextinstanceid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url('/mod/offlinequiz/edit.php', array('cmid' => $this->contextinstanceid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'offlinequiz', 'editquestions', 'view.php?id=' . $this->contextinstanceid,
            $this->other['offlinequizid'], $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['offlinequizid'])) {
            throw new \coding_exception('The \'offlinequizid\' value must be set in other.');
        }
    }
}