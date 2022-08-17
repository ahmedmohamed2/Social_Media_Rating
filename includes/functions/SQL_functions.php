<?php

/**
 * getByCondition Function
 * Function To Return Record By Condition
 * $fields  = All fields I want to retrieve from the database
 * $table   = Table Name
 * $where   = The Condition
 * $values  = Values To Send It To Database
 */

function getByCondition($fields, $table, $where, $values, $allRecords = false) {

    global $connect;

    $stmt = $connect->prepare("SELECT $fields FROM $table WHERE $where");

    $stmt->execute($values);

    if ($allRecords) {
        return $stmt->fetchAll();
    } else {
        return $stmt->fetch();
    }

}

/**
 * getAll Function
 * Function To Get All Record From Table
 * $fields  = All fields I want to retrieve from the database
 * $table   = Table Name
 */

function getAll($fields, $table, $join = "") {

    global $connect;

    $stmt = $connect->prepare("SELECT $fields FROM $table $join");

    $stmt->execute();

    return $stmt->fetchAll();
}


/**
 * delete Function
 * Function To Delete Record
 * $table  	= Table Name
 * $where   = The Condition
 * $values  = Values To Send It To Database
 */

function delete($table, $where, $values) {

    global $connect;

	$stmt = $connect->prepare("DELETE FROM $table WHERE $where");
	$stmt->execute($values);	
}