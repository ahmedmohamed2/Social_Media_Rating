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

$record_per_page = 10;
$page = "";

if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    $page = intval($_GET["page"]);
} else {
    $page = 1;
}

$start_from = ($page - 1) * $record_per_page;

$agents = getAll("*", "app_agents", "ORDER BY agent_id DESC LIMIT $start_from, $record_per_page");

// query to make pagination
$stmtRatingPagination = $connect->prepare("SELECT * FROM app_agents ORDER BY agent_id DESC");
$stmtRatingPagination->execute();
$total_records = $stmtRatingPagination->rowCount();
$total_pages = ceil($total_records / $record_per_page);


if (isset($_POST["addAgent"]) && isset($_POST["agentIdField"]) && empty($_POST["agentIdField"])) {

    $agent_name = trim($_POST["agent_name"]);

    // Username Field Is Less Than 3 Characters
    if (mb_strlen($agent_name, "UTF-8") < 3) {
        $addNewAgentError = "عفوا اسم المستخدم يجب ان يكون اكبر من او يساوى ثلاثه حروف";
    }

    // Username Field Is Larger Than 20 Characters
    if (mb_strlen($agent_name, "UTF-8") > 20) {
        $addNewAgentError = "عفوا اسم المستخدم يجب ان لا يتعدى عشرون حروف";
    }

    if (getByCondition("agent_name", "app_agents", "agent_name = ?", [$agent_name])) {
        $addNewAgentError = "الموظف مسجل مسبقا رجاء اختيار اسم اخر";
    }

    if (!isset($addNewAgentError)) {
        $stmt = $connect->prepare("INSERT INTO app_agents (agent_name) VALUES (?)");
        $stmt->execute([$agent_name]);

        $_SESSION["message"] = "تم اضافة الموظف بنجاح";
        header("LOCATION: agents.php"); 
        exit(); 
    }

}

if (isset($_POST["editAgent"]) || (isset($_POST["agentIdField"]) && !empty($_POST["agentIdField"]))) {

    $agent_name = trim($_POST["agent_name"]);
    $agent_id   = $_POST["agentIdField"]; 

    // Username Field Is Less Than 3 Characters
    if (mb_strlen($agent_name, "UTF-8") < 3) {
        $addNewAgentError = "عفوا اسم المستخدم يجب ان يكون اكبر من او يساوى ثلاثه حروف";
    }

    // Username Field Is Larger Than 20 Characters
    if (mb_strlen($agent_name, "UTF-8") > 20) {
        $addNewAgentError = "عفوا اسم المستخدم يجب ان لا يتعدى عشرون حروف";
    }

    if (getByCondition("agent_name", "app_agents", "agent_name = ? AND agent_id != ?", [$agent_name, $agent_id])) {
        $addNewAgentError = "الموظف مسجل مسبقا رجاء اختيار اسم اخر";
    }

    if (!isset($addNewAgentError)) {
        $stmt = $connect->prepare("UPDATE app_agents SET agent_name = ? WHERE agent_id = ?");
        $stmt->execute([$agent_name, $agent_id]);

        $_SESSION["message"] = "تم تعديل الموظف بنجاح";
        header("LOCATION: agents.php"); 
        exit(); 
    }
}

if (isset($_GET["delete"])) {

    $agent_id = "";
    // Make Sure The Get Request Is Coming From Manage Page Is Number
    if (isset($_GET["agent_id"]) && is_numeric($_GET["agent_id"])) {
        $agent_id = $_GET["agent_id"];
    } else {
        header("LOCATION: agents.php"); 
        exit();         
    }

    // get Agent
    $agent = getByCondition("agent_id", "app_agents", "agent_id = ?", [$agent_id]);

    if ($agent) {
        delete("app_agents", "agent_id = ?", [$agent_id]);
        
        $_SESSION["message"] = "تم حذف الموظف بنجاح";
        header("LOCATION: agents.php"); 
        exit(); 
    } else {
        header("LOCATION: agents.php"); 
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

<?php if (isset($addNewAgentError)): ?>

<script>
    window.onload = function() {
        new swal(
            'خطأ',
            '<?php echo $addNewAgentError; ?>',
            'error'
            );
    }
</script>

<?php endif ?>

<div class="container">
    <h1 class="text-center m-5"><i class="fa fa-users"></i> الموظفين</h1>

    <!-- Start Agents Table -->

    <button type="button" class="btn btn-primary btn-sm mb-3 addAgentBtn">
        اضافه موظف <i class="fa fa-plus-circle"></i>
    </button>

    <div class="table-responsive">
        <table class="table table-bordered text-center main_table myDataTable">
            <thead>
                <th>اسم الموظف</th>
                <th>التحكم</th>
            </thead>
            <tbody>

            <?php foreach ($agents as $agent): ?>
                <tr>
                    <td><?php echo $agent["agent_name"] ?></td>
                    <td>
                        <a id="<?php echo $agent['agent_id'] ?>" data-agent_name="<?php echo $agent['agent_name'] ?>" class="btn btn-success agent_edit btn-sm">تعديل <i class="fa fa-edit"></i></a>
                        <a href="agents.php?delete&agent_id=<?php echo $agent['agent_id'] ?>" class="btn btn-danger btn-sm deleteBtn">حذف <i class="fa fa-times"></i></a>
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
                        <a class="page-link <?php echo $active ?>" href="agents.php?page=<?php echo intval($i) ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>

    </div>

    <!-- End Agents Table -->

</div>

<!-- Start Add Agent Modal -->

<div class="modal fade" id="addAgentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAgentModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
            <!-- Start Form -->

            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">

                <input type="hidden" name="agentIdField" id="agentIdField" value="" />

                <!-- Start agentName Field -->

                <div class="form-group">
                    <label for="agent_name" class="col-form-label"><i class="fa fa-user"></i> اسم الموظف</label>
                    <input 
                        type="text" 
                        name="agent_name"
                        id="agent_name"
                        class="form-control"
                        value="<?php if (isset($agent_name)) { echo $agent_name; } ?>"
                        autocomplete="off"
                        required
                    />
                </div>

                <!-- End agentName Field -->

                <!-- Start Submit Field -->

                <div class="form-group d-grid">
                    <button type="submit" name="addAgent" class="btn btn-primary mt-3 addAgent">
                        <i class="fa fa-user-plus"></i> اضافة موظف جديد
                    </button>
                </div>

                <!-- End Submit Field -->

                <!-- Start Edit Agent Field -->

                <div class="form-group d-grid">
                    <button type="submit" name="editAgent" class="btn btn-success mt-3 editAgent">
                        <i class="fa fa-pencil-square-o"></i> تعديل موظف
                    </button>
                </div>

                <!-- End Agent Field -->

            </form>

            <!-- End Form -->

            </div>
        </div>
    </div>
</div>

<!-- End Add Agent Modal -->

<?php 
    include $templates . "footer.php"; 
    ob_end_flush();
?>