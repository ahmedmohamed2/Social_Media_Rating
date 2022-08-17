<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="fa fa-telegram"></i> تقييم خدمات مواقع التواصل الاجتماعى</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php"><i class="fa fa-home"></i> الرئيسيه</a>
        </li>

      <?php if (isset($_SESSION["rank"]) && $_SESSION["rank"] == 1) { ?>

          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="dashboard.php"><i class="fa fa-certificate"></i>  احصائيات</a>
          </li>

        <?php } ?>

        <?php if (isset($_SESSION["rank"]) && $_SESSION["rank"] == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="ratings.php"><i class="fa fa-star"></i>  التقييمات</a>
          </li>
        <?php } ?>

        <?php if (isset($_SESSION["rank"]) && $_SESSION["rank"] == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="agents.php"><i class="fa fa-users"></i>  الموظفين</a>
          </li>
        <?php } ?>

        <?php if (isset($_SESSION["rank"]) && $_SESSION["rank"] == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="users.php"><i class="fa fa-user-circle-o"></i>  المستخدمين</a>
          </li>
        <?php } ?>

        <?php if (isset($_SESSION["rank"]) && $_SESSION["rank"] == 1) { ?>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="tasksRecords.php"><i class="fa fa-tasks"></i>  سجل التاسكات</a>
          </li>
        <?php } ?>


      </ul>


      <li class="nav-item dropdown d-flex">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            اعدادات <i class="fa fa-cog"></i>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <!-- <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li> -->
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out"></i> تسجيل الخروج</a></li>
          </ul>
        </li>

    </div>
  </div>
</nav>