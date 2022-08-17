<?php
/**
 * Users Page
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

$record_per_page = 10;
$page = "";

if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    $page = intval($_GET["page"]);
} else {
    $page = 1;
}

$start_from = ($page - 1) * $record_per_page;

$users = getAll("*", "app_users", "ORDER BY user_id DESC LIMIT $start_from, $record_per_page");

// query to make pagination
$stmtRatingPagination = $connect->prepare("SELECT * FROM app_users ORDER BY user_id DESC");
$stmtRatingPagination->execute();
$total_records = $stmtRatingPagination->rowCount();
$total_pages = ceil($total_records / $record_per_page);


if (isset($_POST["changeUserPassword"])) {

    $user_id            = $_POST["userIdField"];
    $user_password      = $_POST["user_password"];
    $password_confirm   = $_POST["password_confirm"];

    // If Password Field Is Less Than 8 Chars
    if (mb_strlen($user_password, "UTF-8") < 8) {
        $_SESSION["errorMessage"] = "عفوا كلمه المرور يجب ان تكون اكبر من او تساوى ثمانيه خانات";
    }

    if ($user_password != $password_confirm) {
        $_SESSION["errorMessage"] = "كلمتا المرور غير متطابقتين";
    }

    if (!isset($_SESSION["errorMessage"])) {

        // Hash Password To Save In Database
        $passwordHash = password_hash($user_password, PASSWORD_DEFAULT);

        $statementToUpdatePassword = $connect->prepare("UPDATE app_users SET user_password = ? WHERE user_id = ?");
        $statementToUpdatePassword->execute(array($passwordHash, $user_id));
        $_SESSION["message"] = "تم تعديل كلمه المرور بنجاح";
        header("LOCATION: users.php"); 
        exit(); 
    }

}

if (isset($_GET["delete"])) {

    $user_id = "";
    // Make Sure The Get Request Is Coming From Users Page Is Number
    if (isset($_GET["user_id"]) && is_numeric($_GET["user_id"])) {
        $user_id = $_GET["user_id"];
    } else {
        header("LOCATION: users.php"); 
        exit();         
    }

    // get Agent
    $user = getByCondition("user_id", "app_users", "user_id = ?", [$user_id]);

    if ($user) {
        delete("app_users", "user_id = ?", [$user_id]);
        
        $_SESSION["message"] = "تم حذف المستخدم بنجاح";
        header("LOCATION: users.php"); 
        exit(); 
    } else {
        header("LOCATION: users.php"); 
        exit();
    }
}

?>


<?php if (isset($_SESSION["message"])): ?>

<script>
    window.onload = function() {
        new swal(
            'تم بنجاح',
            '<?php echo $_SESSION["message"]; ?>',
            'success'
            );
    }
</script>

<?php 
    unset($_SESSION["message"]);
    endif 
?>

<?php if (isset($_SESSION["errorMessage"])): ?>

<script>
    window.onload = function() {
        new swal(
            'خطأ',
            '<?php echo $_SESSION["errorMessage"]; ?>',
            'error'
            );
    }
</script>

<?php 
    unset($_SESSION["errorMessage"]);
    endif 
?>


<div class="container">
    <h1 class="text-center m-5"><i class="fa fa-user-circle-o"></i> المستخدمين</h1>

    <!-- Start Users Table -->

    <a href="addUser.php" class="btn btn-primary btn-sm mb-3">اضافه مستخدم <i class="fa fa-plus-circle"></i></a>

    <div class="table-responsive">
        <table class="table table-bordered text-center main_table myDataTable">
            <thead>
                <th>اسم المستخدم</th>
                <th>الدرجه</th>
                <th>التحكم</th>
            </thead>
            <tbody>

                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user["user_name"] ?></td>
                        <td>
                            <?php if ($user["user_rank"] == 1) { ?>
                                مدير
                            <?php } else { ?>
                                مستخدم
                            <?php } ?>
                        </td>
                        <td>
                            <button type="button" class='btn btn-info btn-sm changeUserPassword' id="<?php echo $user['user_id'] ?>">
                                تعديل كلمه المرور <i class="fa fa-key"></i>
                            </button>
                            <a href="editUser.php?user_id=<?php echo $user["user_id"] ?>" class="btn btn-success btn-sm">تعديل <i class="fa fa-edit"></i></a>
                            <a href="users.php?delete&user_id=<?php echo $user['user_id'] ?>" class="btn btn-danger btn-sm deleteBtn">حذف <i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>

        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i<= $total_pages; $i = $i + 1) { ?>
                    <?php 
                        $active = "";
                        if ($page == $i) {
                            $active = "active";
                        } else {
                            $active = "";
                        }
                    ?>
                    <li class="page-item">
                        <a class="page-link <?php echo $active ?>" href="users.php?page=<?php echo intval($i) ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

    </div>

    <!-- End Users Table -->

</div>

<!-- Start Change User Password Modal -->

<div id="changeUserPasswordModal" data-bs-backdrop="static" class="modal fade">  
    <div class="modal-dialog">  
        <div class="modal-content">  
            <div class="modal-header">
                <h5 class="modal-title" id="changeUserPasswordModalLabel"><i class="fa fa-key"></i> تعديل كلمه مرور المستخدم </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>  
            <div class="modal-body">

                <!-- Start Form -->

                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">

                    <input type="hidden" name="userIdField" id="userIdField" value="" />

                    <!-- Start User Password Field -->

                    <div class="form-group">
                        <label for="user_password" class="col-form-label"><i class="fa fa-key"></i> كلمه المرور الجديده</label>
                        <input 
                            type="password" 
                            name="user_password"
                            id="user_password"
                            class="form-control"
                            autocomplete="off"
                            required
                        />
                    </div>

                    <!-- End User Password Field -->

                    <!-- Start Confirm Password Field -->

                    <div class="form-group">
                        <label for="password_confirm" class="col-form-label"><i class="fa fa-key"></i>  تأكيد كلمه المرور</label>
                        <input 
                            type="password" 
                            name="password_confirm"
                            id="password_confirm"
                            class="form-control"
                            autocomplete="off"
                            required
                        />
                    </div>

                    <!-- Start Confirm Password Field -->

                    <!-- Start Submit Field -->

                    <div class="form-group d-grid">
                        <button type="submit" name="changeUserPassword" class="btn btn-info mt-3">
                            <i class="fa fa-unlock"></i> تعديل كلمه المرور
                        </button>
                    </div>

                    <!-- End Submit Field -->

                </form>

                <!-- End Form -->

            </div> 
        </div>  
    </div>  
</div>


<!-- End Change User Password Modal -->

<?php 
    include $templates . "footer.php"; 
    ob_end_flush();
?>