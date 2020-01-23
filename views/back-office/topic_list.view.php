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

    <title>Foro Programacion &bull; Topic</title>

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
                    <h1 class="h2">Topics</h1></div>
                <form action="<?= $route->generateURL('Topic', 'getAdminTopic', ['num_page' => $num_page]); ?>"
                      method="GET" id="topic-search" class="topic-search pull-left" style="margin:0;">
                    <?php if (!empty($_GET["page"])) { ?>
                        <input type="hidden" name="page" value="<?php echo $_GET["num_page"]; ?>"/>
                    <?php } ?>
                    <input type = "hidden" name="num_page" value="<?php echo $num_page; ?>" />
                    <div class="input-group">
                        <select class="form-control" id="forums" name="forums">
                            <option value="0">Selecciona Foro</option>
                            <?php
                                foreach ($forums as $forum){
                            ?>
                                <option value="<?= $forum->getIdForum(); ?>"><?= $forum->getTitle(); ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="input-group">
                        <input class="input-medium search form-control" type="text" name="search_keywords" id="search_keywords"
                               size="20" placeholder="Search this forum…"/>
                    </div>

                    <div class="input-group">
                        <div class = "form-inline">
                            <label>Desde:</label>
                            <input type = "date" class = "form-control" placeholder = "Inicio"  id = "dateIni" name="dateIni"/>
                        </div>
                        <div class = "form-inline">
                            <label>Hasta:</label>
                            <input type = "date" class = "form-control" placeholder = "Final"  id = "dateFin" name="dateFin"/>
                        </div>
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
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date Created</th>
                        <th>Active</th>
                        <th>Id Forum</th>
                        <th>Id User</th>
                        <th>Edit</th>
                        <th>Delete/Active</th>
                        </thead>
                        <tbody>

                        <?php
                        if (isset($topics)) {
                            foreach ($topics as $topic) {
                                ?>

                                <tr>
                                    <td>
                                        <a class="navbar-form navbar-left ng-pristine ng-valid"
                                           href="<?= $route->generateURL('Topic', 'getTopic', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum(), 'id_topic' => $topic->getIdTopic()]) ?>">
                                            <?php echo $topic->getIdTopic(); ?>
                                        </a>
                                    </td>
                                    <td><?php echo $topic->getTitle(); ?></td>
                                    <td><?php echo $topic->getDescription(); ?></td>
                                    <td><?php echo $topic->getDateAdd()->format("d-m-Y"); ?></td>
                                    <td><?php echo (int)$topic->getActive(); ?></td>
                                    <td><?php echo $topic->getIdForum(); ?></td>
                                    <td><?php echo $topic->getIdUser(); ?></td>
                                    <td>
                                        <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                           href="<?= $route->generateURL('Topic', 'adminTopicEdit', ["id_topic" => $topic->getIdTopic()]); ?>">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                        if ($topic->getActive() === true) {
                                            ?>
                                            <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                               href="<?= $route->generateURL('Topic', 'adminTopicDelete', ["id_topic" => $topic->getIdTopic()]); ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn navbar-form navbar-left ng-pristine ng-valid"
                                               href="<?= $route->generateURL('Topic', 'adminTopicActive', ["id_topic" => $topic->getIdTopic()]); ?>">
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
                                    <a href="<?= $route->generateURL('Topic', 'getAdminTopic') . '?' . "num_page=" . $Previous . $id_forum . $search . $dateIni . $dateFin;  ?>"
                                       aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                                <li>
                                    <a href="<?= $route->generateURL('Topic', 'getAdminTopic') . '?' . "num_page=" . $i . $id_forum . $search . $dateIni . $dateFin; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php
                            if ($Next <= $pages) {
                                ?>
                                <li>
                                    <a href="<?= $route->generateURL('Topic', 'getAdminTopic') . '?' . "num_page=" . $Next . $id_forum . $search . $dateIni . $dateFin; ?>"
                                       aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            <?php }
                        } ?>
                    </ul>

                    <a class="btn" href="<?= $route->generateURL('Topic', 'adminTopicAdd'); ?>">
                        <i class="fas fa-plus"></i>
                        Añadir Topic
                    </a>
                </div>
            </main>
        </div>
</body>
</html>
