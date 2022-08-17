<?php

/**
 * filterInt Function
 * filterInt Function Function To Sanitize Integer Numbers
 * $input = User Input
 */

function filterInt($input) {
    return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
}

/**
 * filterFloat Function
 * filterInt Function Function To Sanitize Float Numbers
 * $input = User Input
 */

function filterFloat($input){
    return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

/**
 * filterString Function
 * filterInt Function Function To Sanitize Strings
 * $input = User Input
 */
function filterString($input){
    return htmlentities(strip_tags($input), ENT_QUOTES, "UTF-8");
}

