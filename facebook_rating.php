<?php
/**
 * Old Whatsapp Page
 */


include "init.php";

?>

<div class="container">
    <div class="col-md-6 offset-md-3 d-grid mt-2">
    <img src="layout/images/logo.jpg" alt="Company Logo" class="img-thumbnail mx-auto d-block mb-3 p-5" />
        <div class="card">
            <h5 class="card-header">
                <i class="fa fa-whatsapp"></i>  تقييم محادثة الفيس بوك
                <span class="float-end"><i class="fa fa-comment-o"></i> رأيك يهمنا</span>
            </h5>
            <div class="card-body">

                <input type="hidden" id="task_id" value="3" />

                <!-- Start Agent Star Rating  -->
                <p class="text-center rating_name"> تقييم موظف الفيس بوك</p>
                <h1 class="text-center mt-2 mb-4">
                    <svg class="angry_face" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>
                    <i class="fa fa-star star_light agent_star_rating" id="agent_star_rating_1" data-rating="1"></i>
                    <i class="fa fa-star star_light agent_star_rating" id="agent_star_rating_2" data-rating="2"></i>
                    <i class="fa fa-star star_light agent_star_rating" id="agent_star_rating_3" data-rating="3"></i>
                    <i class="fa fa-star star_light agent_star_rating" id="agent_star_rating_4" data-rating="4"></i>
                    <i class="fa fa-star star_light agent_star_rating" id="agent_star_rating_5" data-rating="5"></i>
                    <svg class="smile_face" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>
                </h1>
                <hr />
                <!-- End Agent Star Rating -->

                <!-- Start Company Nomination -->
                <p class="text-center rating_name">  هل ترشح الشركه لاحد من الاصدقاء او الاقارب</p>
                <h1 class="text-center mt-2 mb-4">
                    <svg class="angry_face" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-emoji-frown" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>
                    <i class="fa fa-star star_light company_nomination" id="company_nomination_1" data-rating="1"></i>
                    <i class="fa fa-star star_light company_nomination" id="company_nomination_2" data-rating="2"></i>
                    <i class="fa fa-star star_light company_nomination" id="company_nomination_3" data-rating="3"></i>
                    <i class="fa fa-star star_light company_nomination" id="company_nomination_4" data-rating="4"></i>
                    <i class="fa fa-star star_light company_nomination" id="company_nomination_5" data-rating="5"></i>
                    <svg class="smile_face" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>
                </h1>
                <!-- End Company Nomination -->

                <!-- Start Customer Name Field -->

                <div class="form-group">
                    <label for="customer_name" class="col-form-label"><i class="fa fa-user"></i> اسم العميل</label>
                    <input 
                        type="text" 
                        name="customer_name"
                        id="customer_name"
                        class="form-control"
                        autocomplete="off"
                        />
                </div>

                <!-- End Customer Name Field -->

                <!-- Start Customer Phone Field -->

                <div class="form-group">
                    <label for="customer_phone" class="col-form-label"><i class="fa fa-mobile"></i> رقم الموبايل</label>
                    <input 
                        type="text" 
                        name="customer_phone"
                        id="customer_phone"
                        class="form-control"
                        autocomplete="off"
                        />
                </div>

                <!-- End Customer Phone Field -->

                <!-- Start Customer Comment Field -->

                <div class="form-group">
                    <label for="customer_comment" class="col-form-label"><i class="fa fa-comment"></i> هل يوجد لديكم اى تعليق او اقتراح لتطوير مستوى الخدمه</label>
                    <textarea class="form-control" name="customer_comment" id="customer_comment" rows="5"></textarea>
                </div>

                <!-- End Customer Comment Field -->

                <!-- Start Submit Field -->

                <div class="form-group d-grid mt-3">
                    <button type="button" class="btn btn-primary" id="save_review"><i class="fa fa-star"></i> تقييم الخدمه</button>
                </div>

                <!-- End Submit Field -->

            </div>
        </div>
    </div>
</div>

<?php include $templates . "footer.php"; ?>