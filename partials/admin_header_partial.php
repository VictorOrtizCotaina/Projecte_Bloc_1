<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 navbar-right"
       href="<?= $route->generateURL('User', 'getUser') ?>">
        <?php echo $user->getUsername(); ?>
    </a>
    <a class="navbar-brand" href="<?= $route->generateURL('Category', 'index') ?>">Foro Programacion</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap navbar-left">
            <a class="nav-link" href="<?= $route->generateURL('User', 'logout') ?>">
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
                    <?php
                    if ($user->getIdUserGroup() === 1) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $route->generateURL('User', 'getAdminUser'); ?>">
                            <span data-feather="bar-chart-2"></span>
                            Users
                        </a>
                    </li>
                    <?php } ?>
                </ul>

            </div>
        </nav>