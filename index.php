<?php
/**
 * Index Page
 */
ob_start();
session_start();

if (!isset($_SESSION["user_name"])) {
    header("LOCATION: login.php");
    exit();
}


$navbar = "";


include "init.php";

$agents = getAll("*", "app_agents");
$tasks  = getAll("*", "app_tasks");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $agent_id  = $_POST["agent_id"];

    if ($agent_id == 0) {
        $assignTaskError = "يجب اختيار الموظف والتاسك الخاص به";
    } else {

        if (isset($_POST["task_id"])) {
            $assignedTasks = $_POST["task_id"];

            foreach ($assignedTasks as $task) {

                $stmt = $connect->prepare("INSERT INTO app_tasks_agents (task_id, agent_id) VALUES (?, ?)");
                $stmt->execute([$task, $agent_id]);

            }

            $_SESSION["message"] = "تم تعيين التاسك بنجاح";
            header("LOCATION: index.php"); 
            exit();
        } else {
            $assignTaskError = "يجب اختيار الموظف والتاسك الخاص به";
        }
    }

}


function returnTaskAgent($taskId, $agentName, $taskAssignedDate) {
    $taskAgent = getAll(
                        "app_tasks_agents.*, app_agents.agent_name, app_tasks.task_name",
                        "app_tasks_agents",
                        "INNER JOIN 
                            app_agents 
                        ON 
                            app_tasks_agents.agent_id = app_agents.agent_id
                        INNER JOIN
                            app_tasks
                        ON
                            app_tasks_agents.task_id = app_tasks.task_id
                        WHERE
                            app_tasks_agents.task_id = " . $taskId . "
                        AND
                            date(app_tasks_agents.task_started_date) = CURRENT_DATE
                        ORDER BY 
                            task_started_date
                        DESC LIMIT 1");

    if ($agentName == true && count($taskAgent) > 0) {
        return $taskAgent[0]["agent_name"];
    }

    if ($taskAssignedDate == true && count($taskAgent) > 0) {
        return $taskAgent[0]["task_started_date"];
    }

}


?>

<?php if (isset($assignTaskError)): ?>

<script>
    window.onload = function() {
        new swal(
            'خطأ',
            '<?php echo $assignTaskError; ?>',
            'error'
            );
    }
</script>

<?php endif ?>

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


<div class="container">
    <h1 class="text-center m-5"><i class="fa fa-home"></i> الصفحة الرئيسيه</h1>
    <div class="col-md-6 offset-md-3 d-grid mt-5">
        <div class="card">
            <h5 class="card-header text-bg-primary text-center">
                تعيين تاسك
            </h5>
            <div class="card-body">

                <!-- Start Task Agent Form -->

                <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">

                    <!-- Start Agent Field -->

                    <div class="form-group">
                        <label for="agent_id" class="col-form-label"><i class="fa fa-user"></i> اسم الموظف</label>
                        <select class="form-select" name="agent_id" id="agent_id">
                            <option value="0">--</option>
                            <?php foreach ($agents as $agent): ?>
                                <option value="<?php echo $agent["agent_id"] ?>"><?php echo $agent["agent_name"] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <!-- End Agent Field -->

                    <!-- Start Tasks Field -->

                    <div class="form-group">
                        <label class="col-form-label"><i class="fa fa-tasks"></i> التاسك</label>
                    </div>
                    <div class="row">

                        <?php foreach ($tasks as $task): ?>
                        
                            <div class="col-md-4">
                                <input class="form-check-input" type="checkbox" name="task_id[]" value="<?php echo $task["task_id"] ?>" id="check<?php echo $task["task_id"]; ?>">
                                <label class="form-check-label" for="check<?php echo $task["task_id"]; ?>">
                                    <?php echo $task["task_name"] ?>
                                </label>
                            </div>

                        <?php endforeach ?>

                    </div>
                    <hr />

                    <!-- End Tasks Field -->

                    <!-- Start Submit Field -->

                    <div class="form-group d-grid mt-3">
                        <button type="submit" class="btn btn-success"><i class="fa fa-tasks"></i>  تعيين التاسك</button>
                    </div>

                    <!-- End Submit Field -->
                </form>

                <!-- End Task Agent Form -->

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col md-4 mt-5">
            <div class="card">
                <h5 class="card-header text-bg-info text-center">
                    الموظف المعين حاليا للواتس اب
                </h5>
                <div class="card-body text-center">
                    <h5><i class="fa fa-user"></i> <?php echo returnTaskAgent(1, true, false) ?></h5>
                    <hr />
                    <h5><i class="fa fa-calendar"></i> <?php echo returnTaskAgent(1, false, true)  ?></h5>
                </div>
            </div>
        </div>
        <div class="col md-4 mt-5">
            <div class="card">
                <h5 class="card-header text-bg-info text-center">
                    الموظف المعين حاليا للتيلجرام
                </h5>
                <div class="card-body text-center">
                    <h5><i class="fa fa-user"></i> <?php echo returnTaskAgent(2, true, false) ?></h5>
                    <hr />
                    <h5><i class="fa fa-calendar"></i> <?php echo returnTaskAgent(2, false, true) ?></h5>
                </div>
            </div>
        </div>
        <div class="col md-4 mt-5">
            <div class="card">
                <h5 class="card-header text-bg-info text-center">
                    الموظف المعين حاليا للفيس بوك
                </h5>
                <div class="card-body text-center">
                    <h5><i class="fa fa-user"></i> <?php echo returnTaskAgent(3, true, false) ?></h5>
                    <hr />
                    <h5><i class="fa fa-calendar"></i> <?php echo returnTaskAgent(3, false, true) ?></h5>
                </div>
            </div>
        </div>
    </div>

</div>

<?php 
    include $templates . "footer.php"; 
    ob_end_flush();
?>