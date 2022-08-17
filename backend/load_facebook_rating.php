<?php

include '../connect.php';

if (isset($_POST["action"])) {

    $average_rating_facebook            = 0;
    $total_review_facebook              = 0;
    $total_five_star_review_facebook    = 0;
    $total_four_star_review_facebook    = 0;
    $total_three_star_review_facebook   = 0;
    $total_two_star_review_facebook     = 0;
    $total_one_star_review_facebook     = 0;
    $total_agent_rating                     = 0;

    $facebookReviewsStmt = $connect->prepare("SELECT agent_rate FROM app_rating WHERE task_id = ?");
    $facebookReviewsStmt->execute([3]);
    $facebookReviews = $facebookReviewsStmt->fetchAll();

    foreach ($facebookReviews as $facebookReview) {

        if ($facebookReview["agent_rate"] == "5") {
            $total_five_star_review_facebook++;
        }

        if ($facebookReview["agent_rate"] == "4") {
            $total_four_star_review_facebook++;
        }

        if ($facebookReview["agent_rate"] == "3") {
            $total_three_star_review_facebook++;
        }

        if ($facebookReview["agent_rate"] == "2") {
            $total_two_star_review_facebook++;
        }

        if ($facebookReview["agent_rate"] == "1") {
            $total_one_star_review_facebook++;
        }

        $total_review_facebook++;

        $total_agent_rating = $total_agent_rating + $facebookReview["agent_rate"];
    }

    $average_rating_facebook = $total_agent_rating / $total_review_facebook;

    $output = [
        "average_rating_facebook"           => number_format($average_rating_facebook, 1),
        "total_review_facebook"             => $total_review_facebook,
        "total_five_star_review_facebook"   => $total_five_star_review_facebook,
        "total_four_star_review_facebook"   => $total_four_star_review_facebook,
        "total_three_star_review_facebook"  => $total_three_star_review_facebook,
        "total_two_star_review_facebook"    => $total_two_star_review_facebook,
        "total_one_star_review_facebook"    => $total_one_star_review_facebook,
    ];

    echo json_encode($output);


}