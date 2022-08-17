<?php

include '../connect.php';

if (isset($_POST["task_id"])) {

    $customer_name      = htmlentities(strip_tags($_POST["customer_name"]), ENT_QUOTES, "UTF-8");
    $customer_phone     = $_POST["customer_phone"];
    $agent_rate         = $_POST["agent_rating"];
    $company_nomination = $_POST["company_nomination"];
    $customer_comment   = htmlentities(strip_tags($_POST["customer_comment"]), ENT_QUOTES, "UTF-8");
    $task_id            = $_POST["task_id"];


    if ($customer_name == "") {
        $customer_name = "N/A";
    }

    if ($customer_phone == "") {
        $customer_phone = "N/A";
    }

    if ($customer_comment == "") {
        $customer_comment = "N/A";
    }

    $agentFetchStmt = $connect->prepare("SELECT agent_id FROM app_tasks_agents WHERE task_id = ? AND date(app_tasks_agents.task_started_date) = CURRENT_DATE ORDER BY task_started_date DESC LIMIT 1");
    $agentFetchStmt->execute([$task_id]);
    if ($agentFetchStmt->rowCount() > 0) {
        $agent_id = $agentFetchStmt->fetch();
        $stmt = $connect->prepare("INSERT INTO 
                                                app_rating (customer_name, customer_phone, agent_rate, company_nomination, customer_comment, task_id, agent_id) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$customer_name, $customer_phone, $agent_rate, $company_nomination, $customer_comment, $task_id, $agent_id['agent_id']]);

        echo "تم تقييم المحادثه بنجاح";
    }

}