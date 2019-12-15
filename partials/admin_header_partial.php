<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 navbar-right"
       href="<?php echo $_SERVER["PHP_SELF"] . "?page=user"; ?>">
        <?php echo $user->getUsername(); ?>
    </a>
    <a class="navbar-brand" href="<?php echo $_SERVER["PHP_SELF"] ?>">Foro Programacion</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap navbar-left">
            <a class="nav-link" href="<?php
            $url = $_SERVER["PHP_SELF"] . "?cerrar_sesion=1";
            echo $url;
            ?>">
                Sign out
            </a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $route->generateURL('Category', 'getAdminCategory'); ?>">
                            <span data-feather="file"></span>
                            Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $route->generateURL('Forum', 'getAdminForum'); ?>">
                            <span data-feather="shopping-cart"></span>
                            Forums
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $route->generateURL('Topic', 'getAdminTopic'); ?>">
                            <span data-feather="users"></span>
                            Topics
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $route->generateURL('Post', 'getAdminPost'); ?>">
                            <span data-feather="bar-chart-2"></span>
                            Posts
                        </a>
                    </li>
                </ul>

            </div>
        </nav>