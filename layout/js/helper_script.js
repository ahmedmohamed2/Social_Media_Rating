

$(document).ready(function() {

    // Dashboard 

    loadWhatsappRatingData();

    loadTelegramRatingData();

    loadFacebookRatingData();

    // Function To Load Whatsapp Rating Data
    function loadWhatsappRatingData(){
        $.ajax({
            url: "backend/load_rating_whatsapp_data.php",
            method: "POST",
            data: {action: "load_data"},
            dataType: "JSON",
            success:function(data) {
                $("#average_rating_whatsapp").text(data.average_rating_whatsapp);
                $("#total_review_whatsapp").text(data.total_review_whatsapp);

                var count_star = 0;
                $(".main_star_whatsapp").each(function () {
                    count_star = count_star + 1;
                    if (Math.ceil(data.average_rating_whatsapp) >= count_star) {
                        $(this).addClass("text-warning");
                        //$(this).addClass("star_light");
                    }
                });


                $("#total_five_star_review_whatsapp").text(data.total_five_star_review_whatsapp);
                $("#total_four_star_review_whatsapp").text(data.total_four_star_review_whatsapp);
                $("#total_three_star_review_whatsapp").text(data.total_three_star_review_whatsapp);
                $("#total_two_star_review_whatsapp").text(data.total_two_star_review_whatsapp);
                $("#total_one_star_review_whatsapp").text(data.total_one_star_review_whatsapp);

                $("#five_star_progress_whatsapp").css("width", (data.total_five_star_review_whatsapp / data.total_review_whatsapp) * 100 + "%");
                $("#four_star_progress_whatsapp").css("width", (data.total_four_star_review_whatsapp / data.total_review_whatsapp) * 100 + "%");
                $("#three_star_progress_whatsapp").css("width", (data.total_three_star_review_whatsapp / data.total_review_whatsapp) * 100 + "%");
                $("#two_star_progress_whatsapp").css("width", (data.total_two_star_review_whatsapp / data.total_review_whatsapp) * 100 + "%");
                $("#one_star_progress_whatsapp").css("width", (data.total_one_star_review_whatsapp / data.total_review_whatsapp) * 100 + "%");
            }
        })
    }

    // Function To Load Telegram Rating Data
    function loadTelegramRatingData() {

        $.ajax({
            url: "backend/load_telegram_rating.php",
            method: "POST",
            data: {action: "load_data"},
            dataType: "JSON",
            success:function(data) {
                $("#average_rating_telegram").text(data.average_rating_telegram);
                $("#total_review_telegram").text(data.total_review_telegram);

                var count_star = 0;
                $(".main_star_telegram").each(function () {
                    count_star = count_star + 1;
                    if (Math.ceil(data.average_rating_telegram) >= count_star) {
                        $(this).addClass("text-warning");
                        //$(this).addClass("star_light");
                    }
                });


                $("#total_five_star_review_telegram").text(data.total_five_star_review_telegram);
                $("#total_four_star_review_telegram").text(data.total_four_star_review_telegram);
                $("#total_three_star_review_telegram").text(data.total_three_star_review_telegram);
                $("#total_two_star_review_telegram").text(data.total_two_star_review_telegram);
                $("#total_one_star_review_telegram").text(data.total_one_star_review_telegram);

                $("#five_star_progress_telegram").css("width", (data.total_five_star_review_telegram / data.total_review_telegram) * 100 + "%");
                $("#four_star_progress_telegram").css("width", (data.total_four_star_review_telegram / data.total_review_telegram) * 100 + "%");
                $("#three_star_progress_telegram").css("width", (data.total_three_star_review_telegram / data.total_review_telegram) * 100 + "%");
                $("#two_star_progress_telegram").css("width", (data.total_two_star_review_telegram / data.total_review_telegram) * 100 + "%");
                $("#one_star_progress_telegram").css("width", (data.total_one_star_review_telegram / data.total_review_telegram) * 100 + "%");
            }
        });
    }

    function loadFacebookRatingData() {

        $.ajax({
            url: "backend/load_facebook_rating.php",
            method: "POST",
            data: {action: "load_data"},
            dataType: "JSON",
            success:function(data) {

                $("#average_rating_facebook").text(data.average_rating_facebook);
                $("#total_review_facebook").text(data.total_review_facebook);

                var count_star = 0;
                $(".main_star_facebook").each(function () {
                    count_star = count_star + 1;
                    if (Math.ceil(data.average_rating_facebook) >= count_star) {
                        $(this).addClass("text-warning");
                        //$(this).addClass("star_light");
                    }
                });


                $("#total_five_star_review_facebook").text(data.total_five_star_review_facebook);
                $("#total_four_star_review_facebook").text(data.total_four_star_review_facebook);
                $("#total_three_star_review_facebook").text(data.total_three_star_review_facebook);
                $("#total_two_star_review_facebook").text(data.total_two_star_review_facebook);
                $("#total_one_star_review_facebook").text(data.total_one_star_review_facebook);

                $("#five_star_progress_facebook").css("width", (data.total_five_star_review_facebook / data.total_review_facebook) * 100 + "%");
                $("#four_star_progress_facebook").css("width", (data.total_four_star_review_facebook / data.total_review_facebook) * 100 + "%");
                $("#three_star_progress_facebook").css("width", (data.total_three_star_review_facebook / data.total_review_facebook) * 100 + "%");
                $("#two_star_progress_facebook").css("width", (data.total_two_star_review_facebook / data.total_review_facebook) * 100 + "%");
                $("#one_star_progress_facebook").css("width", (data.total_one_star_review_facebook / data.total_review_facebook) * 100 + "%");

            }
        });
    }

    // Users Page

    $(".changeUserPassword").on("click", function() {
        $("#changeUserPasswordModal").modal("show");
        $("#userIdField").val(this.id);
    });


    // agents Page

    $(document).on("click", ".addAgentBtn", function() {
        $("#addAgentModal").modal("show");
        $("#addAgentModalLabel").text("اضافه موظف جديد");
        $("#agentIdField").val("");
        $("#agent_name").val( "" );
        $(".addAgent").show();
        $(".editAgent").hide();

    });


    $(document).on("click", ".agent_edit", function() {
        var agent_id    = $(this).attr("id");
        var agent_name  = $(this).data("agent_name");
        
        $("#addAgentModal").modal("show");
        $("#addAgentModalLabel").text("تعديل اسم الموظف");
        $("#agentIdField").val(agent_id);
        $("#agent_name").val( agent_name );
        $(".addAgent").hide();
        $(".editAgent").show();
    });

    $(".deleteBtn").on("click", function() {
        return confirm("هل انت متأكد من الحذف");
    });

}); 