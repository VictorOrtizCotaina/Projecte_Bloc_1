<?php global $route ?>
<header>
    <nav class="navbar navbar-default navbar-fixed-top navbar-fix" id="header-nav" role="navigation">
        <div class="container-fluid">

            <div id="search-menu">
                <a class="navbar-brand" href="<?= $route->generateURL('Category', 'index') ?>">Foro Programacion</a>

                <?php
                if (!isset($_SESSION["user"])) {
                    ?>
                    <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                       href="<?= $route->generateURL('User', 'login') ?>">
                        <i class="fa fa-user"></i>
                    </a>
                    <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                       href="<?= $route->generateURL('User', 'register') ?>">
                        <i class="fa fa-user-plus"></i>
                    </a>
                <?php } ?>

                <?php
                if (isset($_SESSION["user"])) {
                    ?>
                    <a class="navbar-form navbar-left ng-pristine ng-valid"
                       href="<?= $route->generateURL('User', 'getUser') ?>">
                        <?php echo $user->getUsername(); ?>
                    </a>

                    <?php
                    if ($user->getIdUserGroup() === 1) {
                        ?>
                        <a class="navbar-form navbar-left ng-pristine ng-valid"
                           href="<?php echo $_SERVER["PHP_SELF"] . "?page=category_list"; ?>">
                            Back-Office
                        </a>
                    <?php } ?>

                    <a class="btn navbar-form navbar-left ng-pristine ng-valid" href="<?php
                    $url = $_SERVER["PHP_SELF"] . "?";
                    if (!empty($_SERVER["QUERY_STRING"])) {
                        $url .= $_SERVER["QUERY_STRING"] . "&";
                    }
                    $url .= "cerrar_sesion=1";
                    echo $url;
                    ?>">
                        <i class="fas fa-power-off"></i>
                    </a>
                <?php } ?>
                <?php
                if (isset($_SESSION["user"])) {
                    ?>
                <?php } ?>

                <?php
                foreach ($categoriesNavbar as $categoryNavbar) {
                    ?>
                    <div class="btn-group">
                        <div class="btn-group dropright">
                            <a type="button" class="btn btn-secondary"
                               href="<?php echo $_SERVER["PHP_SELF"] . "?page=category&id_category={$categoryNavbar->getIdCategory()}"; ?>">
                                <?php echo $categoryNavbar->getTitle(); ?>
                            </a>
                            <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="sr-only">Toggle Dropright</span>
                            </button>
                            <ul class="dropdown-menu">
                                <?php
                                foreach ($categoryNavbar->getForums() as $forumNavbar) {
                                    ?>
                                    <li><a href="<?php echo $_SERVER["PHP_SELF"] . "?page=forum&id_forum={$forumNavbar->getIdForum()}"; ?>">
                                            <?php echo $forumNavbar->getTitle(); ?>
                                        </a></li>
                                    <li class="divider"></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </nav>

    <div class="jumbotron no-margin-bottom no-padding-bottom">
        <div class="container text-center">
            <div id="site-logo"><a href="<?= $route->generateURL('Category', 'index') ?>"
                                   title="Board index"><h2>Foro Programacion</h2></a></div>

        </div>
    </div>
</header>