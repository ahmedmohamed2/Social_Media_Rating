<?php
/**
 * Add User Page
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

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Receive Values From Form And Save It In Variables

    $user_name = filterString( strtolower( $_POST["user_name"] ) );
    $password   = $_POST["password"];
    $rank       = $_POST["rank"];

    // Username Field Is Less Than 3 Characters
    if (mb_strlen($user_name, "UTF-8") < 3) {
        array_push($errors, "عفوا اسم المستخدم يجب ان يكون اكبر من او يساوى ثلاثه حروف");
    }

    // Username Field Is Larger Than 20 Characters
    if (mb_strlen($user_name, "UTF-8") > 20) {
        array_push($errors, "عفوا اسم المستخدم يجب ان لا يتعدى عشرون حروف");
    }

    // If Password Field Is Less Than 8 Chars
    if (mb_strlen($password, "UTF-8") < 8) {
        array_push($errors, "عفوا كلمه المرور يجب ان تكون اكبر من او تساوى ثمانيه خانات");
    }

    if (getByCondition("user_name", "app_users", "user_name = ?", [$user_name])) {
        array_push($errors, "اسم المستخدم مسجل مسبقا رجاء اختيار اسم اخر");
    }

    if (count($errors) == 0) {
        // Hash Password To Save In Database
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connect->prepare("INSERT INTO app_users (user_name, user_password, user_rank) VALUES (?, ?, ?)");
        $stmt->execute([$user_name, $hashPassword, $rank]);

        $_SESSION["message"] = "تم اضافه المستخدم بنجاح";
        header("LOCATION: users.php"); 
        exit(); 
    }
}

?>

<!-- Start Add User Page -->

<div class="container">



    <div class="col-md-6 offset-md-3 d-grid mt-5">
        <div class="card mt-5">
            <h5 class="card-header text-bg-info text-center">
                <i class="fa fa-user-plus"></i> اضافه مستخدم جديد
            </h5>
            <div class="card-body">

            <?php if (count($errors) > 0) { ?>
                    <div class="alert alert-danger">
                        <ul>
                        <?php foreach ($errors as $error) { ?>
                            <li><?php echo $error; ?></li>
                        <?php } ?>
                        </ul>
                    </div>
            <?php } ?>

            <!-- Start Form -->

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
                            required
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
                            required
                        />
                    </div>

                    <!-- End Password Field -->

                    <!-- Start Rank Field -->

                    <div class="form-group">
                        <label for="rank" class="col-form-label"><i class="fa fa-flash"></i> الدرجه</label>
                        <select class="form-select" name="rank" id="rank">
                            <option value="0">موظف</option>
                            <option value="1">مدير</option>
                        </select>
                    </div>

                    <!-- End Rank Field -->

                    <!-- Start Submit Field -->

                    <div class="form-group d-grid">
                        <button type="submit" name="addUser" class="btn btn-primary mt-3">
                            <i class="fa fa-user-plus"></i> اضافة مستخدم جديد
                        </button>
                    </div>

                    <!-- End Submit Field -->

            </form>

            <!-- End Form -->

            </div>
        </div>
    </div>

</div>

<!-- End Add User Page -->

<?php 
    include $templates . "footer.php"; 
    ob_end_flush();
?>