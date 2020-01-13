<?php global $route;
global $search;
global $forum;
global $dateIni;
global $dateFin;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb" data-ng-app>

<head>

    <meta charset="UTF-8"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="./theme/images/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title>Foro Programacion &bull; Users</title>

    <?php
    require 'partials/admin_head_partial.php';
    ?>

</head>
<body>
    <?php
    require 'partials/admin_header_partial.php';
    ?>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Users</h1></div>
                <form action="<?= $route->generateURL('User', 'getAdminUser', ['num_page' => $num_page]); ?>"
                      method="GET" id="topic-search" class="topic-search pull-left" style="margin:0;">
                    <input type = "hidden" name="num_page" value="<?php echo $num_page; ?>" />
                    <!--<div class="input-group">
                        <select class="form-control" id="forums" name="forums">
                            <option value="0">Selecciona Foro</option>
                            <?php
/*                                foreach ($users as $user){
                            */?>
                                <option value="<?/*= $user->getIdForum(); */?>"><?/*= $user->getTitle(); */?></option>
                            <?php /*} */?>
                        </select>
                    </div>-->
                    <div class="input-group">
                        <select class="form-control" id="user_group" name="user_group">
                            <option value="0">Selecciona Foro</option>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>

                    <span class="input-group-btn">
                        <input type="submit" class="btn btn-block btn-outline-primary" name="submitFilter" value="Filtrar">
					</span>

                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">

                        <thead>
                        <!--                                    <th><input type="checkbox" id="checkall"/></th>-->
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Surnames</th>
                        <th>Province</th>
                        <th>Lang</th>
                        <th>Date_add</th>
                        <th>User Group</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        </thead>
                        <tbody>

                        <?php
                        if (isset($users)) {
                            foreach ($users as $user) {
                                ?>

                                <tr>
                                    <td>
                                        <a class="navbar-form navbar-left ng-pristine ng-valid">
                                            <?php echo $user->getIdUser(); ?>
                                        </a>
                                    </td>
                                    <td><?php echo $user->getUsername(); ?></td>
                                    <td><?php echo $user->getEmail(); ?></td>
                                    <td><?php echo $user->getName(); ?></td>
                                    <td><?php echo $user->getSurnames(); ?></td>
                                    <td><?php echo $user->getProvince(); ?></td>
                                    <td><?php echo $user->getLang(); ?></td>
                                    <td><?php echo $user->getDateAdd()->format("d-m-Y"); ?></td>
                                    <td>
                                        <?php if ($user->getIdUserGroup() == 1) { ?>
                                            Admin
                                        <?php } else { ?>
                                            User
                                        <?php } ?>
                                    </td>
                                    <!--<td>
                                        <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                           href="<?/*= $route->generateURL('Topic', 'adminTopicEdit', ["id_topic" => $user->getIdTopic()]); */?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
/*                                        if ($user->getActive() === true) {
                                            */?>
                                            <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                               href="<?/*= $route->generateURL('Topic', 'adminTopicDelete', ["id_topic" => $user->getIdTopic()]); */?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php /*} else { */?>
                                            <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                               href="<?/*= $route->generateURL('Topic', 'adminTopicActive', ["id_topic" => $user->getIdTopic()]); */?>">
                                                <i class="fas fa-unlock-alt"></i>
                                            </a>
                                        <?php /*} */?>
                                    </td>-->
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
                                    <a href="<?= $route->generateURL('User', 'getAdminUser', [] ,['num_page' => $Previous, "user_group" => $id_user_group]);  ?>"
                                       aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                <li>
                                    <a href="<?= $route->generateURL('User', 'getAdminUser', [] ,['num_page' => $i, "user_group" => $id_user_group]); ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php
                            if ($Next <= $pages) {
                                ?>
                                <li>
                                    <a href="<?= $route->generateURL('User', 'getAdminUser', [] ,['num_page' => $Next, "user_group" => $id_user_group]); ?>"
                                       aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>

                    <!--<a class="btn" href="<?/*= $route->generateURL('Topic', 'adminTopicAdd'); */?>">
                        <i class="fas fa-plus"></i>
                        Añadir Topic
                    </a>-->
                </div>
            </main>
        </div>
</body>
</html>
