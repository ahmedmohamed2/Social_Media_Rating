<?php

/**
 * initialize file
 * Here we will include all the important files 
 */

// Routes

$templates = "includes/templates/"; // Template directory
$functions = "includes/functions/"; // Functions directory
$css       = "layout/css/";         // css directory
$js        = "layout/js/";          // js directory

include "connect.php";
include $functions . "SQL_functions.php";
include $functions . "helpers_functions.php";
include $templates . "header.php";

if (isset($navbar)) {
    include $templates . "navbar.php";
}
