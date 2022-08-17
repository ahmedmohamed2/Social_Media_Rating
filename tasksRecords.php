<?php
/**
 * Tasks Records Page
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

$where = "";

if (isset($_GET["task_id"]) && isset($_GET["agent_id"]) && $_GET["task_id"] != 0 && $_GET["agent_id"] != 0 && is_numeric($_GET["task_id"]) && is_numeric($_GET["agent_id"]) && isset($_GET["dateFrom"]) && $_GET["dateFrom"] != "" && strtotime($_GET["dateFrom"]) && isset($_GET["dateTo"]) && $_GET["dateTo"] != "" && strtotime($_GET["dateTo"])) {

    $dateFrom   = $_GET["dateFrom"];
    $dateTo     = $_GET["dateTo"];

    $where = "WHERE date(app_tasks_agents.task_started_date) BETWEEN '$dateFrom' AND '$dateTo' AND app_tasks_agents.task_id = " . intval($_GET["task_id"]) . " AND app_tasks_agents.agent_id = " . intval($_GET["agent_id"]);

// if user search by task and agent
} else if (isset($_GET["task_id"]) && isset($_GET["agent_id"]) && $_GET["task_id"] != 0 && $_GET["agent_id"] != 0 && is_numeric($_GET["task_id"]) && is_numeric($_GET["agent_id"])) {

    $where = "WHERE app_tasks_agents.task_id = " . intval($_GET["task_id"]) . " AND app_tasks_agents.agent_id = " . intval($_GET["agent_id"]);

// if user search by task and date
} else if (isset($_GET["task_id"]) && $_GET["task_id"] != 0 && is_numeric($_GET["task_id"]) && isset($_GET["dateFrom"]) && $_GET["dateFrom"] != "" && strtotime($_GET["dateFrom"]) && isset($_GET["dateTo"]) && $_GET["dateTo"] != "" && strtotime($_GET["dateTo"])) {

    $dateFrom   = $_GET["dateFrom"];
    $dateTo     = $_GET["dateTo"];

    $where = "WHERE date(app_tasks_agents.task_started_date) BETWEEN '$dateFrom' AND '$dateTo' AND app_tasks_agents.task_id = " . intval($_GET["task_id"]);

// if user search by agent and date
} else if (isset($_GET["agent_id"]) && $_GET["agent_id"] != 0 && is_numeric($_GET["agent_id"]) && isset($_GET["dateFrom"]) && $_GET["dateFrom"] != "" && strtotime($_GET["dateFrom"]) && isset($_GET["dateTo"]) && $_GET["dateTo"] != "" && strtotime($_GET["dateTo"])) {

    $dateFrom   = $_GET["dateFrom"];
    $dateTo     = $_GET["dateTo"];

    $where = "WHERE date(app_tasks_agents.task_started_date) BETWEEN '$dateFrom' AND '$dateTo' AND app_tasks_agents.agent_id = " . intval($_GET["agent_id"]);

// if user search by task
} else if (isset($_GET["task_id"]) && $_GET["task_id"] != 0 && is_numeric($_GET["task_id"])) {

    $where = "WHERE app_tasks_agents.task_id = " . intval($_GET["task_id"]);

// if user search by agent
} else if (isset($_GET["agent_id"]) && $_GET["agent_id"] != 0 && is_numeric($_GET["agent_id"])) {

    $where = "WHERE app_tasks_agents.agent_id = " . intval($_GET["agent_id"]);

// if user search by date
} else if (isset($_GET["dateFrom"]) && $_GET["dateFrom"] != "" && strtotime($_GET["dateFrom"]) && isset($_GET["dateTo"]) && $_GET["dateTo"] != "" && strtotime($_GET["dateTo"])) {

    $dateFrom   = $_GET["dateFrom"];
    $dateTo     = $_GET["dateTo"];
    $where      = "WHERE date(app_tasks_agents.task_started_date) BETWEEN '$dateFrom' AND '$dateTo' ";
}


$tasksAgents = getAll(
    "app_tasks_agents.*, app_tasks.task_name, app_agents.agent_name",
    "app_tasks_agents",
    "INNER JOIN
	app_tasks
    ON
        app_tasks_agents.task_id = app_tasks.task_id
    INNER JOIN
        app_agents
    ON
        app_tasks_agents.agent_id = app_agents.agent_id
    " . $where . "
    ORDER BY
        app_tasks_agents.task_started_date DESC LIMIT $start_from, $record_per_page");

// query to make pagination
$stmtRatingPagination = $connect->prepare("SELECT * FROM app_tasks_agents " . $where . " ORDER BY task_agent_id DESC");
$stmtRatingPagination->execute();
$total_records = $stmtRatingPagination->rowCount();
$total_pages = ceil($total_records / $record_per_page);

// to return all tasks from database
$tasks  = getAll("*", "app_tasks");
// to return all agents from database
$agents = getAll("*", "app_agents");

$url = $_SERVER['REQUEST_URI'];

$query = parse_url($url, PHP_URL_QUERY);


?>

<div class="container">
    <h1 class="text-center m-5"><i class="fa fa-tasks"></i> سجل التاسكات</h1>

    <button type="button" class="btn btn-info mb-2" data-bs-toggle="modal" data-bs-target="#searchModal">
        <i class="fa fa-search"></i> بحث
    </button>

    <!-- Start Tasks Records Table -->

    <div class="table-responsive">
        <table class="table table-bordered text-center main_table">
            <thead>
                <th>اسم الموظف</th>
                <th>التاسك</th>
                <th>تاريخ تعيين التاسك</th>
            </thead>
            <tbody>
                <?php foreach ($tasksAgents as $taskAgent) { ?>
                    <tr>
                        <td><?php echo $taskAgent["agent_name"]; ?></td>
                        <td><?php echo $taskAgent["task_name"]; ?></td>
                        <td><?php echo $taskAgent["task_started_date"]; ?></td>
                    </tr>
                <?php } ?>
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

                    <?php if ($query) { ?>
                        
                        <?php if (isset($_GET["task_id"]) && isset($_GET["agent_id"]) && isset($_GET["dateFrom"]) && isset($_GET["dateTo"])) { ?>

                            <a class="page-link <?php echo $active ?>" href="tasksRecords.php?task_id=<?php echo intval($_GET["task_id"]) ?>&agent_id=<?php echo intval($_GET["agent_id"]) ?>&dateFrom=<?php echo $_GET["dateFrom"] ?>&dateTo=<?php echo $_GET["dateTo"] ?>&page=<?php echo $i ?>"><?php echo $i; ?></a>

                        <?php } else { ?>

                            <a class="page-link <?php echo $active ?>" href="tasksRecords.php?page=<?php echo intval($i) ?>"><?php echo $i; ?></a>

                        <?php } ?>

                    <?php  } else { ?>

                        <a class="page-link <?php echo $active ?>" href="tasksRecords.php?page=<?php echo intval($i) ?>"><?php echo $i; ?></a>

                    <?php } ?>

                    </li>
                <?php } ?>
            </ul>
        </nav>

    </div>

    <!-- End Tasks Records Table -->

        <!-- Start Search Modal -->

        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">
                        <i class="fa fa-search"></i> بحث
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="GET">

                        <div class="row">
                            <div class="col-md-6">

                                <!-- Start Tasks Field -->

                                <div class="form-group">
                                    <label for="task_id" class="col-form-label"><i class="fa fa-tasks"></i> نوع الخدمه</label>
                                    <select class="form-select" name="task_id" id="task_id">
                                        <option value="0">--</option>
                                        <?php foreach ($tasks as $task): ?>
                                            <option value="<?php echo $task["task_id"] ?>"><?php echo $task["task_name"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <!-- End Tasks Field -->

                            </div>
                            <div class="col-md-6">


                                <!-- Start Agent Name -->

                                <div class="form-group">
                                    <label for="agent_id" class="col-form-label"><i class="fa fa-user"></i> اسم الموظف</label>
                                    <select class="form-select" name="agent_id" id="agent_id">
                                        <option value="0">--</option>
                                        <?php foreach ($agents as $agent): ?>
                                            <option value="<?php echo $agent["agent_id"] ?>"><?php echo $agent["agent_name"] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>

                                <!-- End Agent Name -->


                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">

                                <!-- Start Date From Field -->

                                <div class="form-group">
                                    <label for="dateFrom" class="col-form-label"><i class="fa fa-calendar"></i> من</label>
                                    <input type="date" id="dateFrom" name="dateFrom" class="form-control" />
                                </div>

                                <!-- End Date From Field -->

                            </div>
                            <div class="col-md-6">

                                <!-- Start Date From Field -->

                                <div class="form-group">
                                    <label for="dateTo" class="col-form-label"><i class="fa fa-calendar"></i> الى</label>
                                    <input type="date" id="dateTo" name="dateTo" class="form-control" />
                                </div>

                                <!-- End Date From Field -->

                            </div>
                        </div>


                        <!-- Start Submit Field -->

                        <div class="form-group d-grid mt-3">
                            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i>  بحث</button>
                        </div>

                        <!-- End Submit Field -->

                    </form>


                </div>

            </div>
        </div>
    </div>

    <!-- End Search Modal -->


</div>

<?php 
    include $templates . "footer.php"; 
    ob_end_flush();
?>