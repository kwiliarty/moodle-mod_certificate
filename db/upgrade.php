<?php  //$Id$

// This file keeps track of upgrades to 
// the certificate module
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installation to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the functions defined in lib/ddllib.php

function xmldb_certificate_upgrade($oldversion=0) {

    global $CFG, $THEME, $db;

    $result = true;

    if ($result && $oldversion < 2007061300) {
    /// Add new fields to certificate table

        $table = new XMLDBTable('certificate');
        $field = new XMLDBField('emailothers');
        $field->setAttributes(XMLDB_TYPE_TEXT, 'small', null, null, null, null, null, null, 'emailteachers');
        $result = $result && add_field($table, $field);

        $table = new XMLDBTable('certificate');
        $field = new XMLDBField('printhours');
        $field->setAttributes(XMLDB_TYPE_TEXT, 'small', null, null, null, null, null, null, 'gradefmt');
        $result = $result && add_field($table, $field);

        $table = new XMLDBTable('certificate');
        $field = new XMLDBField('lockgrade');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null, null, '0', 'printhours');
        $result = $result && add_field($table, $field);

        $table = new XMLDBTable('certificate');
        $field = new XMLDBField('requiredgrade');
        $field->setAttributes(XMLDB_TYPE_INTEGER, '4', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null, null, '0', 'lockgrade');
        $result = $result && add_field($table, $field);

    /// Rename field save to savecert
        $field = new XMLDBField('save');
        if (field_exists($table, $field)) {
            $field->setAttributes(XMLDB_TYPE_INTEGER, '2', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null, null, '0', 'emailothers');

        /// Launch rename field savecert
            $result = $result && rename_field($table, $field, 'savecert');
        } else {
            $field = new XMLDBField('savecert');
            $field->setAttributes(XMLDB_TYPE_INTEGER, '2', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null, null, '0', 'emailothers');
            
            $result = $result && add_field($table, $field);
        }

    }

    return $result;
}

?>