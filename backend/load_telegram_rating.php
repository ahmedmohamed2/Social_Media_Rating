<?php

include '../connect.php';

if (isset($_POST["action"])) {
    
    $average_rating_telegram            = 0;
    $total_review_telegram              = 0;
    $total_five_star_review_telegram    = 0;
    $total_four_star_review_telegram    = 0;
    $total_three_star_review_telegram   = 0;
    $total_two_star_review_telegram     = 0;
    $total_one_star_review_telegram     = 0;
    $total_agent_rating                     = 0;


    $telegramReviewsStmt = $connect->prepare("SELECT agent_rate FROM app_rating WHERE task_id = ?");
    $telegramReviewsStmt->execute([2]);
    $telegramReviews = $telegramReviewsStmt->fetchAll();

    foreach ($telegramReviews as $telegramReview) {

        if ($telegramReview["agent_rate"] == "5") {
            $total_five_star_review_telegram++;
        }

        if ($telegramReview["agent_rate"] == "4") {
            $total_four_star_review_telegram++;
        }

        if ($telegramReview["agent_rate"] == "3") {
            $total_three_star_review_telegram++;
        }

        if ($telegramReview["agent_rate"] == "2") {
            $total_two_star_review_telegram++;
        }

        if ($telegramReview["agent_rate"] == "1") {
            $total_one_star_review_telegram++;
        }

        $total_review_telegram++;

        $total_agent_rating = $total_agent_rating + $telegramReview["agent_rate"];
    }

    $average_rating_telegram = $total_agent_rating / $total_review_telegram;


    $output = [
        "average_rating_telegram"           => number_format($average_rating_telegram, 1),
        "total_review_telegram"             => $total_review_telegram,
        "total_five_star_review_telegram"   => $total_five_star_review_telegram,
        "total_four_star_review_telegram"   => $total_four_star_review_telegram,
        "total_three_star_review_telegram"  => $total_three_star_review_telegram,
        "total_two_star_review_telegram"    => $total_two_star_review_telegram,
        "total_one_star_review_telegram"    => $total_one_star_review_telegram,
    ];
    
    echo json_encode($output);
}