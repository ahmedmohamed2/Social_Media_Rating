<?php
/**
 * Login page
 */
ob_start();
session_start();

if (isset($_SESSION["user_name"])) {
    header("LOCATION: index.php");
    exit();
}

include "init.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_name  = htmlentities(strip_tags($_POST["user_name"]), ENT_QUOTES, "UTF-8");
    $password   = $_POST["password"];

    if (empty($user_name) || empty($password)) {
        $loginError = "من فضلك ادخل كلمه المرور واسم المستخدم";
    }

    if (!empty($user_name) && !empty($password)) {
        $returnedValue = getByCondition("user_id, user_name, user_password, user_rank", "app_users", "user_name = ?", [$user_name]);
        if ($returnedValue == true) {

            if (password_verify($password, $returnedValue["user_password"])) {
                $_SESSION["user_name"] = $user_name;
                $_SESSION["rank"]      = $returnedValue["user_rank"];
                header("LOCATION: index.php");
                exit();
            } else {
                $loginError = "عفوا اسم المستخدم او كلمه المرور خطأ";
            }

        } else {
            $loginError = "عفوا اسم المستخدم او كلمه المرور خطأ";
        }
    }

}

?>

<?php if (isset($loginError)): ?>

<script>
    window.onload = function() {
        new swal(
            'خطأ',
            '<?php echo $loginError; ?>',
            'error'
            );
    }
</script>

<?php endif ?>

<!-- Start Login Page -->

<div class="container">
    <div class="col-md-6 offset-md-3 d-grid mt-5">
        <img src="layout/images/logo.jpg" alt="Company Logo" class="img-thumbnail mx-auto d-block mb-5 p-5" />
        <div class="card">
            <h5 class="card-header text-bg-info text-center">
                من فضلك سجل دخولك للمتابعه
            </h5>
            <div class="card-body">
            
                <!-- Start Login Form -->

                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">

                    <!-- Start Username Field -->

                    <div class="form-group">
                        <label for="user_name" class="col-form-label"><i class="fa fa-user"></i> اسم المستخدم</label>
                        <input 
                            type="text" 
                            name="user_name"
                            id="user_name"
                            class="form-control"
                            value="<?php if (isset($user_name)) { echo $user_name; } ?>"
                            autocomplete="off"
                        />
                    </div>

                    <!-- End Username Field -->

                    <!-- Start Password Field -->

                    <div class="form-group">
                        <label for="password" class="col-form-label"><i class="fa fa-lock"></i> كلمه المرور</label>
                        <input 
                            type="password" 
                            name="password"
                            id="password"
                            class="form-control"
                            autocomplete="new-password"
                        />
                    </div>

                    <!-- End Password Field -->

                    <!-- Start Submit Field -->

                    <div class="form-group d-grid mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> تسجيل الدخول</button>
                    </div>

                    <!-- End Submit Field -->

                </form>

                <!-- End Login Form -->

            </div>
        </div>
    </div>
</div>

<!-- End Login Page -->


<?php 
    include $templates . "footer.php"; 
    ob_end_flush();
?>