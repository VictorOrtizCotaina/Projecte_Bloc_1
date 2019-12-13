<?php global $route; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb" data-ng-app>

<head>

    <meta charset="UTF-8"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="./theme/images/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title>Foro Programacion &bull; <?php echo $user->getUsername(); ?></title>

    <link href="./theme/comboot/font-awesome.min.css" rel="stylesheet"/>
    <link href="./theme/comboot/colorpicker.min.css" rel="stylesheet"/>
    <link href="./theme/comboot/lightbox.css" rel="stylesheet"/>
    <link href="./theme/comboot/select.min.css" rel="stylesheet"/>
    <link href="./theme/comboot/syntax-highlighting.css" rel="stylesheet"/>
    <link href="./theme/css/bootstrap.min.css" rel="stylesheet">

    <script src="./theme/comboot/jquery.min.js" type="text/javascript"></script>
    <script src="./theme/editor.js" type="text/javascript"></script>
    <script src="./theme/comboot/angular.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/progressbar.min.js" type="text/javascript"></script>
    <script src="./theme/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/colorpicker.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/lightbox.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/select.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/syntax-highlighting.js" type="text/javascript"></script>


    <link href="./theme/fontawesome/css/all.min.css" rel="stylesheet"/>
    <script src="./theme/fontawesome/js/all.min.js" type="text/javascript"></script>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>

</head>
<body>
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
                            <a class="nav-link" href="<?php echo $_SERVER["PHP_SELF"] . "?page=category_list"; ?>">
                                <span data-feather="file"></span>
                                Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $_SERVER["PHP_SELF"] . "?page=forum_list"; ?>">
                                <span data-feather="shopping-cart"></span>
                                Forums
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $_SERVER["PHP_SELF"] . "?page=topic_list"; ?>">
                                <span data-feather="users"></span>
                                Topics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $_SERVER["PHP_SELF"] . "?page=post_list"; ?>">
                                <span data-feather="bar-chart-2"></span>
                                Posts
                            </a>
                        </li>

                    </ul>

                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Categories</h1></div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">

                        <thead>

                        <!--                                    <th><input type="checkbox" id="checkall"/></th>-->
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date Created</th>
                        <th>Active</th>
                        <th>Id User</th>
                        <th>Edit</th>
                        <th>Delete/Active</th>
                        </thead>
                        <tbody>


                        <?php
                        if (isset($categories)) {
                            foreach ($categories as $category) {
                                ?>

                                <tr>
                                    <!--                                                <td><input type="checkbox" class="checkthis"/></td>-->
                                    <td><?php echo $category->getIdCategory(); ?></td>
                                    <td><?php echo $category->getTitle(); ?></td>
                                    <td><?php echo $category->getDescription(); ?></td>
                                    <td><?php echo $category->getDateAdd()->format("d-m-Y"); ?></td>
                                    <td><?php echo (int)$category->getActive(); ?></td>
                                    <td><?php echo $category->getIdUser(); ?></td>
                                    <td>
                                        <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                           href="<?= $route->generateURL('Category', 'adminCategoryEdit', ["id_category" => $category->getIdCategory()]); ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        if ($category->getActive() === true) {
                                            ?>
                                            <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                               href="<?= $route->generateURL('Category', 'adminCategoryDelete', ["id_category" => $category->getIdCategory()]); ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                               href="<?= $route->generateURL('Category', 'adminCategoryActive', ["id_category" => $category->getIdCategory()]); ?>">
                                                <i class="fas fa-unlock-alt"></i>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>

                            <?php } ?>
                        <?php } ?>

                        </tbody>

                    </table>

                    <div class="clearfix"></div>
                    <ul class="pagination pull-right">
                        <?php
                        if ($pages > 1) {
                            if ($Previous > 0) {
                                ?>
                                <li>
                                    <a href="<?= $route->generateURL('Category', 'getAdminCategory') . "&num_page=" . $Previous; ?>"
                                       aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                <li>
                                    <a href="<?= $route->generateURL('Category', 'getAdminCategory') . "&num_page=" . $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php
                            if ($Next <= $pages) {
                                ?>
                                <li>
                                    <a href="<?= $route->generateURL('Category', 'getAdminCategory') . "&num_page=" . $Next;  ?>"
                                       aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>
                    <a class="btn" href="<?= $route->generateURL('Category', 'adminCategoryAdd') ?>">
                        <i class="fas fa-plus"></i>
                        Añadir Categoria
                    </a>
                </div>
            </main>
        </div>
</body>
</html>
