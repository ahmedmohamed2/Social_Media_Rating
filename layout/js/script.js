

$(document).ready(function() {

    // variable to save agent rating
    var agent_rating_data = 0;
    var company_nomination_data = 0;

    // When User is hover on agent rating stars
    $(".agent_star_rating").on("mouseenter", function() {

        var rating = $(this).data("rating");

        resetBackground();

        for (var count = 1; count <= rating; count = count + 1) {
            
            $("#agent_star_rating_" + count).addClass("text-warning");

        }
    });

    // When user is mouse leave over on agent rating stars

    $(".agent_star_rating").on("mouseleave", function() {
        resetBackground();

        for(var count = 1; count <= agent_rating_data; count++)
        {
            $('#agent_star_rating_'+ count).removeClass('star_light');
            $('#agent_star_rating_'+ count).addClass('text-warning');
        }
    }); 

    // When user is clicked on agent rating star
    $(".agent_star_rating").on("click", function() {
        agent_rating_data = $(this).data("rating");
    });

    // function to remove Gold Color From agent rating Stars
    function resetBackground() {
        for (var count = 1; count <= 5; count = count + 1) {
            $("#agent_star_rating_" + count).addClass("star_light");
            $("#agent_star_rating_" + count).removeClass("text-warning");
        }
    }


    // When User is hover on company nomination stars
    $(".company_nomination").on("mouseenter", function() {

        var rating = $(this).data("rating");

        resetCompanyNominationBackground();

        for (var count = 1; count <= rating; count = count + 1) {
            
            $("#company_nomination_" + count).addClass("text-warning");

        }
    });

    // When user is mouse leave over on company nomination  stars

    $(".company_nomination").on("mouseleave", function() {
        resetCompanyNominationBackground();

        for(var count = 1; count <= company_nomination_data; count++)
        {
            $('#company_nomination_'+ count).removeClass('star_light');
            $('#company_nomination_'+ count).addClass('text-warning');
        }
    }); 

    // When user is clicked on company nomination rating star

    $(".company_nomination").on("click", function() {
        company_nomination_data = $(this).data("rating");
    });

    // function to remove Gold Color From agent rating Stars
    function resetCompanyNominationBackground() {
        for (var count = 1; count <= 5; count = count + 1) {
            $("#company_nomination_" + count).addClass("star_light");
            $("#company_nomination_" + count).removeClass("text-warning");
        }
    }



    $("#save_review").on("click", function() {

        var task_id             = $("#task_id").val();
        var agent_rating        = agent_rating_data;
        var company_nomination  = company_nomination_data;
        var customer_name       = $("#customer_name").val();
        var customer_phone      = $("#customer_phone").val();
        var customer_comment    = $("#customer_comment").val();

        if (agent_rating == 0) {
            new swal(
                "خطأ",
                "من فضلك قم بتقييم الموظف على الاقل",
                "error"
            );

            return false;
        } else {

            $.ajax({
                url: "backend/submit_rating.php",
                method: "POST",
                data: {
                        task_id: task_id,
                        agent_rating: agent_rating,
                        company_nomination: company_nomination,
                        customer_name: customer_name,
                        customer_phone: customer_phone,
                        customer_comment: customer_comment,
                    },
                success: function(data) {
                    new swal(
                        "تم بنجاح",
                        data,
                        "success"
                    );
                    resetBackground();
                    resetCompanyNominationBackground();
                    $("#customer_name").val("");
                    $("#customer_phone").val("");
                    $("#customer_comment").val("");
                    agent_rating_data = 0;
                    company_nomination_data = 0;
                    $(".card").hide(500);
                }
            });

        }

    });



});
