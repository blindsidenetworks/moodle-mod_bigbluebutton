<?php

/**
 * View and administrate BigBlueButton playback recordings
 *
 * Authors:
 *      Jesus Federico (jesus [at] b l i n ds i de n  e t w o r ks [dt] com)
 *
 * @package   mod_bigbluebutton
 * @copyright 2011 Blindside Networks Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v2 or later
 */


defined('MOODLE_INTERNAL') || die();

global $DB;

$logs = array(
    array('module'=>'recordingsbn', 'action'=>'add', 'mtable'=>'recordingsbn', 'field'=>'name'),
    array('module'=>'recordingsbn', 'action'=>'update', 'mtable'=>'recordingsbn', 'field'=>'name'),
    array('module'=>'recordingsbn', 'action'=>'view', 'mtable'=>'recordingsbn', 'field'=>'name'),
    array('module'=>'recordingsbn', 'action'=>'view all', 'mtable'=>'recordingsbn', 'field'=>'name')
);
