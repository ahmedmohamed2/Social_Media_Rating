<?php
/**
 * Dashboard Page
 */
ob_start();
session_start();

if (!isset($_SESSION["user_name"])) {
    header("LOCATION: login.php");
    exit();
} else if (isset($_SESSION["rank"]) && $_SESSION["rank"] != 1) {
    header("LOCATION: index.php");
    exit();
}



$navbar = "";

include "init.php";


?>

<div class="container">
    <h1 class="text-center m-5"><i class="fa fa-certificate"></i> احصائيات</h1>
    <div class="row">
        <!-- Start Old Whatsapp Stat -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <h5 class="card-header text-bg-info text-center">
                    الواتس اب
                </h5>
                <div class="card-body">

                    <div class="text-center card_data">

                        <h3 class="text-warning mt-1 mb-1">
                            <b class=""><span id="average_rating_whatsapp">0.0</span> / 5</b>
                        </h3>

                        <div class="mb-3">
                            <i class="fa fa-star star_light mr-1 main_star_whatsapp"></i>
                            <i class="fa fa-star star_light mr-1 main_star_whatsapp"></i>
                            <i class="fa fa-star star_light mr-1 main_star_whatsapp"></i>
                            <i class="fa fa-star star_light mr-1 main_star_whatsapp"></i>
                            <i class="fa fa-star star_light mr-1 main_star_whatsapp"></i>
                        </div>
                        <h3><span id="total_review_whatsapp">0</span> تقييم</h3>

                        <hr />

                        <p>
                            <div class="progress-label-right">
                                <b>5</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_five_star_review_whatsapp">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress_whatsapp"></div>
                            </div>
                        </p>

                        <p>
                            <div class="progress-label-right">
                                <b>4</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_four_star_review_whatsapp">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress_whatsapp"></div>
                            </div>
                        </p>


                        <p>
                            <div class="progress-label-right">
                                <b>3</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_three_star_review_whatsapp">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress_whatsapp"></div>
                            </div>
                        </p>

                        <p>
                            <div class="progress-label-right">
                                <b>2</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_two_star_review_whatsapp">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress_whatsapp"></div>
                            </div>
                        </p>

                        <p>
                            <div class="progress-label-right">
                                <b>1</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_one_star_review_whatsapp">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress_whatsapp"></div>
                            </div>
                        </p>

                    </div>

                </div>
            </div>
        </div>
        <!-- End Old Whatsapp Stat -->

        <!-- Start New Whatsapp Stat -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <h5 class="card-header text-bg-info text-center">
                    التيلجرام
                </h5>
                <div class="card-body">
                
                    <div class="text-center card_data">

                        <h3 class="text-warning mt-1 mb-1">
                            <b class=""><span id="average_rating_telegram">0.0</span> / 5</b>
                        </h3>

                        <div class="mb-3">
                            <i class="fa fa-star star_light mr-1 main_star_telegram"></i>
                            <i class="fa fa-star star_light mr-1 main_star_telegram"></i>
                            <i class="fa fa-star star_light mr-1 main_star_telegram"></i>
                            <i class="fa fa-star star_light mr-1 main_star_telegram"></i>
                            <i class="fa fa-star star_light mr-1 main_star_telegram"></i>
                        </div>
                        <h3><span id="total_review_telegram">0</span> تقييم</h3>

                        <hr />

                        <p>
                            <div class="progress-label-right">
                                <b>5</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_five_star_review_telegram">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress_telegram"></div>
                            </div>
                        </p>

                        <p>
                            <div class="progress-label-right">
                                <b>4</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_four_star_review_telegram">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress_telegram"></div>
                            </div>
                        </p>


                        <p>
                            <div class="progress-label-right">
                                <b>3</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_three_star_review_telegram">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress_telegram"></div>
                            </div>
                        </p>

                        <p>
                            <div class="progress-label-right">
                                <b>2</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_two_star_review_telegram">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress_telegram"></div>
                            </div>
                        </p>

                        <p>
                            <div class="progress-label-right">
                                <b>1</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_one_star_review_telegram">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress_telegram"></div>
                            </div>
                        </p>

                    </div>

                </div>
            </div>
        </div>
        <!-- End New Whatsapp Stat -->

        <!-- Start Facebook Stat -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <h5 class="card-header text-bg-info text-center">
                    الفيس بوك
                </h5>
                <div class="card-body">

                    <div class="text-center card_data">

                        <h3 class="text-warning mt-1 mb-1">
                            <b class=""><span id="average_rating_facebook">0.0</span> / 5</b>
                        </h3>

                        <div class="mb-3">
                            <i class="fa fa-star star_light mr-1 main_star_facebook"></i>
                            <i class="fa fa-star star_light mr-1 main_star_facebook"></i>
                            <i class="fa fa-star star_light mr-1 main_star_facebook"></i>
                            <i class="fa fa-star star_light mr-1 main_star_facebook"></i>
                            <i class="fa fa-star star_light mr-1 main_star_facebook"></i>
                        </div>
                        <h3><span id="total_review_facebook">0</span> تقييم</h3>

                        <hr />

                        <p>
                            <div class="progress-label-right">
                                <b>5</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_five_star_review_facebook">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress_facebook"></div>
                            </div>
                        </p>

                        <p>
                            <div class="progress-label-right">
                                <b>4</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_four_star_review_facebook">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress_facebook"></div>
                            </div>
                        </p>


                        <p>
                            <div class="progress-label-right">
                                <b>3</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_three_star_review_facebook">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress_facebook"></div>
                            </div>
                        </p>

                        <p>
                            <div class="progress-label-right">
                                <b>2</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_two_star_review_facebook">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress_facebook"></div>
                            </div>
                        </p>

                        <p>
                            <div class="progress-label-right">
                                <b>1</b> 
                                <i class="fa fa-star text-warning"></i>
                            </div>

                            <div class="progress-label-left">
                                (<span id="total_one_star_review_facebook">0</span>)
                            </div>

                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress_facebook"></div>
                            </div>
                        </p>

                    </div>

                </div>
            </div>
        </div>
        <!-- End Facebook Stat -->
    </div>
</div>

<?php 
    include $templates . "footer.php"; 
    ob_end_flush();
?>