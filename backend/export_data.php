<?php

ob_start();
session_start();

if (!isset($_SESSION["user_name"])) {
    header("LOCATION: login.php");
    exit();
} else if (isset($_SESSION["rank"]) && $_SESSION["rank"] != 1) {
    header("LOCATION: index.php");
    exit();
}


include '../connect.php';

// filter the excel data

function filterData(&$str) {
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
}

// Excel file name for download 
$fileName = "rating_data_" . date('Y-m-d') . ".xls"; 

// column names
$fields = ["id", "customer name", "mobile number", "agent rate", "company nomination", "service type", "agent name", "rating date", "customer comments"];

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

$stmt = $connect->prepare("SELECT
                                app_rating.*, app_agents.agent_name, app_tasks.task_name
                            FROM
                                app_rating
                            INNER JOIN
                                app_agents
                            ON
                                app_agents.agent_id = app_rating.agent_id
                            INNER JOIN
                                app_tasks
                            ON
                                app_tasks.task_id = app_rating.task_id
                            ORDER BY rating_id DESC");

$stmt->execute();

$theDataRatings = $stmt->fetchAll();

if ($stmt->rowCount()) {
    foreach ($theDataRatings as $index => $rating) {
        $lineData = [ 
                        $index = $index + 1,
                        $rating["customer_name"],
                        $rating["customer_phone"],
                        $rating["agent_rate"],
                        $rating["company_nomination"],
                        $rating["task_name"],
                        $rating["agent_name"],
                        $rating["rating_date"],
                        $rating["customer_comment"],
                    ];
        array_walk($lineData, "filterData");
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    }
} else {
    $excelData .= 'No records found...'. "\n"; 
}

// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 

// Render excel data 
echo $excelData; 
