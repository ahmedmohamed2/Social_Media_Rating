<?php
/**
 * Edit User Page
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

$user_id = "";
// Make Sure The Get Request Is Coming From Users Page Is Number

if (isset($_GET["user_id"]) && is_numeric($_GET["user_id"])) {
	$user_id = $_GET["user_id"];
} else {
	header("LOCATION: users.php");
	exit();
}

$user = getByCondition("user_id, user_name, user_rank", "app_users", "user_id = ?", [$user_id]);

if (!$user) {
	header("LOCATION: users.php");
	exit();
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id    = $_POST["user_id"];
    $user_name  = $_POST["user_name"];
    $rank       = $_POST["rank"];

    //echo "User Id =  [ " . $user_id . " ] - Username =  [ " . $user_name . " ] - User Rank =  [ " . $rank . " ]";

    // Username Field Is Less Than 3 Characters
    if (mb_strlen($user_name, "UTF-8") < 3) {
        array_push($errors, "عفوا اسم المستخدم يجب ان يكون اكبر من او يساوى ثلاثه حروف");
    }

    // Username Field Is Larger Than 20 Characters
    if (mb_strlen($user_name, "UTF-8") > 20) {
        array_push($errors, "عفوا اسم المستخدم يجب ان لا يتعدى عشرون حرف");
    }
    
    if (getByCondition("user_name", "app_users", "user_name = ? AND user_id != ?", [$user_name, $user_id])) {
        array_push($errors, "اسم المستخدم مسجل مسبقا رجاء اختيار اسم اخر");
    }

    if (count($errors) == 0) {
        $stmt = $connect->prepare("UPDATE app_users SET user_name = ?, user_rank = ? WHERE user_id = ?");
        $stmt->execute([$user_name, $rank, $user_id]);
        $_SESSION["message"] = "تم تعديل المستخدم بنجاح";
        header("LOCATION: users.php"); 
        exit(); 
    }

}

?>

<!-- Start Edit User Page -->

<div class="container">
    <div class="col-md-6 offset-md-3 d-grid mt-5">
        <div class="card mt-5">
            <h5 class="card-header text-bg-info text-center">
                <i class="fa fa-pencil-square-o"></i> تعديل مستخدم
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
                
                <form action="<?php echo $_SERVER["PHP_SELF"] ?>?user_id=<?php echo $_GET['user_id'] ?>" method="POST">
                
					<!-- Start User Id Field -->

					<input 
						type="hidden" 
						name="user_id" 
						value="<?php echo $user['user_id']; ?>" 
						/>

					<!-- End User Id Field -->


                    <!-- Start Username Field -->
                    
                    <div class="form-group">
                        <label for="user_name" class="col-form-label"><i class="fa fa-user"></i> اسم المستخدم</label>
                        <input 
                            type="text" 
                            name="user_name"
                            id="user_name"
                            class="form-control"
                            value="<?php echo $user['user_name']; ?>"
                            autocomplete="off"
                        />
                    </div>

                    <!-- End Username Field -->

                    <!-- Start Rank Field -->

                    <div class="form-group">
                        <label for="rank" class="col-form-label"><i class="fa fa-flash"></i> الدرجه</label>
                        <select class="form-select" name="rank" id="rank">
                            <option value="0" <?php if ($user["user_rank"] == 0) { echo "selected"; } ?>>موظف</option>
                            <option value="1" <?php if ($user["user_rank"] == 1) { echo "selected"; } ?>>مدير</option>
                        </select>
                    </div>

                    <!-- End Rank Field -->

                    <!-- Start Submit Field -->

                    <div class="form-group d-grid">
                        <button type="submit" name="addUser" class="btn btn-primary mt-3">
                            <i class="fa fa-pencil-square-o"></i> تعديل مستخدم
                        </button>
                    </div>
                    
                    <!-- End Submit Field -->

                </form>

                <!-- End Form -->

            </div>
        </div>
    </div>
</div>

<!-- End Edit User Page -->

<?php 
    include $templates . "footer.php"; 
    ob_end_flush();
?>