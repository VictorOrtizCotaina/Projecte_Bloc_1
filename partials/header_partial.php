<?php global $route ?>
<header>
    <nav class="navbar navbar-default navbar-fixed-top navbar-fix" id="header-nav" role="navigation">
        <div class="container-fluid">

            <div id="search-menu">
                <a class="navbar-brand" href="<?= $route->generateURL('Category', 'index') ?>"><?= gettext("Foro Programacion") ?></a>

                <?php

                if (!isset($_SESSION["user"])) {
                    ?>
                    <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                       href="<?= $route->generateURL('User', 'login') ?>">
                        <i class="fa fa-user"></i>
                        <?= gettext("Iniciar Sesión") ?>
                    </a>
                    <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                       href="<?= $route->generateURL('User', 'register') ?>">
                        <i class="fa fa-user-plus"></i>
                        <?= gettext("Registro") ?>
                    </a>
                <?php } ?>

                <?php
                if (isset($user)) {
                    ?>
                    <a class="navbar-form navbar-left ng-pristine ng-valid"
                       href="<?= $route->generateURL('User', 'getUser') ?>">
                        <?php echo $user->getUsername(); ?>
                    </a>

                    <a class="navbar-form navbar-left ng-pristine ng-valid"
                       href="<?= $route->generateURL('Category', 'getAdminCategory') ?>">
                        Back-Office
                    </a>

                    <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                       href="<?= $route->generateURL('User', 'logout') ?>">
                        <i class="fas fa-power-off"></i>
                        <?= gettext("Cerrar Sesión") ?>
                    </a>
                <?php } ?>

                <?php
                foreach ($categoriesNavbar as $categoryNavbar) {
                    ?>
                    <div class="btn-group">
                        <div class="btn-group dropright">
                            <a type="button" class="btn btn-secondary"
                               href="<?= $route->generateURL('Category', 'getCategory', ['id_category' => $categoryNavbar->getIdCategory()]) ?>">
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
                                    <li>
                                        <a href="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $categoryNavbar->getIdCategory(), 'id_forum' => $forumNavbar->getIdForum()]) ?>">
                                            <?php echo $forumNavbar->getTitle(); ?>
                                        </a></li>
                                    <li class="divider"></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

                <div class="btn-group dropright">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= gettext("Idioma") ?>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="?lang=es"><?= gettext("Español")?></a>
                        <a class="dropdown-item" href="?lang=va"><?= gettext("Catalán")?></a>
                        <a class="dropdown-item" href="?lang=gb"><?= gettext("Inglés")?></a>
                    </div>
                </div>

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