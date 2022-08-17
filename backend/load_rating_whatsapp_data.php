<?php

include '../connect.php';

if (isset($_POST["action"])) {

    // Loading Whatsapp Data

    $average_rating_whatsapp            = 0;
    $total_review_whatsapp              = 0;
    $total_five_star_review_whatsapp    = 0;
    $total_four_star_review_whatsapp    = 0;
    $total_three_star_review_whatsapp   = 0;
    $total_two_star_review_whatsapp     = 0;
    $total_one_star_review_whatsapp     = 0;
    $total_agent_rating                 = 0;

    $whatsappReviewsStmt = $connect->prepare("SELECT agent_rate FROM app_rating WHERE task_id = ?");
    $whatsappReviewsStmt->execute([1]);
    $whatsappReviews = $whatsappReviewsStmt->fetchAll();

    foreach ($whatsappReviews as $whatsappReview) {

        if ($whatsappReview["agent_rate"] == "5") {
            $total_five_star_review_whatsapp++;
        }

        if ($whatsappReview["agent_rate"] == "4") {
            $total_four_star_review_whatsapp++;
        }

        if ($whatsappReview["agent_rate"] == "3") {
            $total_three_star_review_whatsapp++;
        }

        if ($whatsappReview["agent_rate"] == "2") {
            $total_two_star_review_whatsapp++;
        }

        if ($whatsappReview["agent_rate"] == "1") {
            $total_one_star_review_whatsapp++;
        }

        $total_review_whatsapp++;

        $total_agent_rating = $total_agent_rating + $whatsappReview["agent_rate"];
    }

    $average_rating_whatsapp = $total_agent_rating / $total_review_whatsapp;

    $output = [
        "average_rating_whatsapp"           => number_format($average_rating_whatsapp, 1),
        "total_review_whatsapp"             => $total_review_whatsapp,
        "total_five_star_review_whatsapp"   => $total_five_star_review_whatsapp,
        "total_four_star_review_whatsapp"   => $total_four_star_review_whatsapp,
        "total_three_star_review_whatsapp"  => $total_three_star_review_whatsapp,
        "total_two_star_review_whatsapp"    => $total_two_star_review_whatsapp,
        "total_one_star_review_whatsapp"    => $total_one_star_review_whatsapp,
    ];

    echo json_encode($output);

}