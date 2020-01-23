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

    <title>Back-Office &bull; Forum</title>

    <?php
    require '../partials/admin_head_partial.php';
    ?>

</head>
<body>
    <?php
    require '../partials/admin_header_partial.php';
    ?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Forums</h1></div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">

                        <thead>
                        <!--                                    <th><input type="checkbox" id="checkall"/></th>-->
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date Created</th>
                        <th>Active</th>
                        <th>Id Category</th>
                        <th>Id User</th>
                        <th>Edit</th>
                        <th>Delete/Active</th>
                        </thead>
                        <tbody>

                        <?php
                        if (isset($forums)) {
                            foreach ($forums as $forum) {
                                ?>

                                <tr>
                                    <td><?php echo $forum->getIdForum(); ?></td>
                                    <td><?php echo $forum->getTitle(); ?></td>
                                    <td><?php echo $forum->getDescription(); ?></td>
                                    <td><?php echo $forum->getDateAdd()->format("d-m-Y"); ?></td>
                                    <td><?php echo (int)$forum->getActive(); ?></td>
                                    <td><?php echo $forum->getIdCategory(); ?></td>
                                    <td><?php echo $forum->getIdUser(); ?></td>
                                    <td>
                                        <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                           href="<?= $route->generateURL('Forum', 'adminForumEdit', ["id_forum" => $forum->getIdForum()]); ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        if ($forum->getActive() === true) {
                                            ?>
                                            <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                               href="<?= $route->generateURL('Forum', 'adminForumDelete', ["id_forum" => $forum->getIdForum()]); ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                               href="<?= $route->generateURL('Forum', 'adminForumActive', ["id_forum" => $forum->getIdForum()]); ?>">
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
                                    <a href="<?= $route->generateURL('Forum', 'getAdminForum', [], ["num_page" => $Previous]); ?>"
                                       aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                <li>
                                    <a href="<?= $route->generateURL('Forum', 'getAdminForum', [], ["num_page" => $i]); ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php
                            if ($Next <= $pages) {
                                ?>
                                <li>
                                    <a href="<?= $route->generateURL('Forum', 'getAdminForum', [], ["num_page" => $Next]);  ?>"
                                       aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>

                    <a class="btn" href="<?= $route->generateURL('Forum', 'adminForumAdd') ?>">
                        <i class="fas fa-plus"></i>
                        Añadir Forum
                    </a>
                </div>
            </main>
        </div>
</body>
</html>
