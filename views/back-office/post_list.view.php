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

    <title>Foro Programacion &bull; Post</title>

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
    <?php
    require 'partials/admin_header_partial.php';
    ?>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Posts</h1></div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">

                        <thead>
                        <!--                                    <th><input type="checkbox" id="checkall"/></th>-->
                        <th>ID</th>
                        <th>Title</th>
                        <th>Text</th>
                        <th>Date Created</th>
                        <th>Active</th>
                        <th>Id Topic</th>
                        <th>Id User</th>
                        <th>Edit</th>
                        <th>Delete/Active</th>
                        </thead>
                        <tbody>

                        <?php
                        if (isset($posts)) {
                            foreach ($posts as $post) {
                                ?>

                                <tr>
                                    <td><?php echo $post->getIdPost(); ?></td>
                                    <td><?php echo $post->getTitle(); ?></td>
                                    <td><?php echo $post->getText(); ?></td>
                                    <td><?php echo $post->getDateAdd()->format("d-m-Y"); ?></td>
                                    <td><?php echo (int)$post->getActive(); ?></td>
                                    <td><?php echo $post->getIdTopic(); ?></td>
                                    <td><?php echo $post->getIdUser(); ?></td>
                                    <td>
                                        <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                           href="<?= $route->generateURL('Post', 'adminPostEdit', ["id_post" => $post->getIdPost()]); ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        if ($post->getActive() === true) {
                                            ?>
                                            <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                               href="<?= $route->generateURL('Post', 'adminPostDelete', ["id_post" => $post->getIdPost()]); ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                               href="<?= $route->generateURL('Post', 'adminPostActive', ["id_post" => $post->getIdPost()]); ?>">
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
                                    <a href="<?= $route->generateURL('Post', 'getAdminPost') . "?num_page=" . $Previous; ?>"
                                       aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                <li>
                                    <a href="<?= $route->generateURL('Post', 'getAdminPost') . "?num_page=" . $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php
                            if ($Next <= $pages) {
                                ?>
                                <li>
                                    <a href="<?= $route->generateURL('Post', 'getAdminPost') . "?num_page=" . $Next; ?>"
                                       aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>

                    <a class="btn" href="<?= $route->generateURL('Post', 'adminPostAdd'); ?>">
                        <i class="fas fa-plus"></i>
                        Añadir Post
                    </a>
                </div>
            </main>
        </div>
</body>
</html>
