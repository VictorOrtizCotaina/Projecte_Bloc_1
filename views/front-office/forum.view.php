<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb" data-ng-app>

<head>

    <meta charset="UTF-8"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="./theme/images/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title>Foro Programacion &bull; <?php if (isset($forum)) echo $forum->getTitle(); ?></title>

    <?php
    require 'partials/head_partial.php';
    ?>


</head>

<body class="section-viewforum ltr">

    <?php
    require 'partials/header_partial.php';
    ?>

    <div class="container" id="content-wrapper">

        <?php if (isset($forum)){ ?>
        <div class="page-header">
            <h2><?php echo $forum->getTitle(); ?></h2>
            <p><?php echo $forum->getDescription(); ?></p>
        </div>
        <?php } ?>
        <?php if (isset($userTopic)){ ?>
            <div class="page-header">
                <h2><?php echo $userTopic->getUserName(); ?></h2>
<!--                <p>--><?php //echo $userTopic->getDescription(); ?><!--</p>-->
            </div>
        <?php } ?>

        <div>
            <!-- NOTE: remove the style="display: none" when you want to have the forum description on the forum body -->
        </div>

        <div class="row mobile-fix">

<!--            <div class="col-md-3 col-xs-12">
                (Actualmente no funciona)
                <a class="btn btn-primary btn-labeled" href=""><span
                            class="btn-label"><i class="fa fa-pencil-square-o"></i></span> Post a new topic</a>
            </div>
-->
            <div class="col-md-3 col-xs-12"></div>
            <div class="col-md-6 text-center col-xs-12">
                <div class="btn-group forum-pagination">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php
                            if ($Previous>0){
                                ?>
                                <li>
                                    <!--                                    --><?php //echo $_SERVER["PHP_SELF"]."?". "page=forum" . $query_Forum . $query_User . "&num_page=" . $Previous . $search . $dateIni . $dateFin; ?>
                                    <a href="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum()]) . '?' . "page=" . $Previous . $search . $dateIni . $dateFin;  ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php for($i = 1; $i<= $pages; $i++) : ?>
                                <!--                                --><?php //echo $_SERVER["PHP_SELF"]."?". "page=forum" . $query_Forum . $query_User . "&num_page=" . $i . $search . $dateIni . $dateFin; ?>
                                <li><a href="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum()]) . '?' . "page=" . $i . $search . $dateIni . $dateFin; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <?php
                            if ($Next <= $pages){
                                ?>
                                <li>
                                    <!--                                    --><?php //echo $_SERVER["PHP_SELF"]."?". "page=forum" . $query_Forum . $query_User . "&num_page=" . $Next . $search . $dateIni . $dateFin; ?>
                                    <a href="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum()]) . '?' . "page=" . $Next . $search . $dateIni . $dateFin; ?>" aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>


            <div class="col-md-3 col-xs-12 pull-right">
                <form action="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum()]) . "?page=" . $page; ?>"
                      method="GET" id="topic-search" class="topic-search pull-right" style="margin:0;">
                    <input type = "hidden" name="page" value="<?php echo $_GET["page"]; ?>" />
                    <?php if (!empty($id_forum)) { ?>
                    <input type = "hidden" name="id_forum" value="<?php echo $id_forum; ?>" />
                    <?php } ?>
                    <?php if (!empty($id_user)) { ?>
                    <input type = "hidden" name="id_user" value="<?php echo $id_user; ?>" />
                    <?php } ?>
                    <input type = "hidden" name="num_page" value="<?php echo $page; ?>" />
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
                        <input type="submit" class="btn btn-default" name="submitFilter" value="Filtrar">
					</span>

                </form>
            </div>

        </div >

        <div class="forumbg table-responsive ">
            <table class="table table-striped table-bordered">
                <thead class="topiclist">
                <tr class="header">
                    <th class="forum-name"><i class="fa fa-comments-o"></i> Topics</th>
                    <th class="posts"><i class="fa fa-reply"></i> Replies</th>
                    <th class="views"><i class="fa fa-eye"></i> Views</th>
                    <th class="lastpost"><i class="fa fa-history"></i> <span>Last post</span></th>
                </tr>
                </thead>
                <tbody class="topiclist topics">

                <?php
                foreach ($topics as $key => $topic) {
                    ?>

                    <tr class="t-row">
                        <td class="topic-name " title="No unread posts">
                            <div class="pull-left forum-topic-icon">
								<span>
                                    <a href="<?= $route->generateURL('Topic', 'getTopic', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum(), 'id_topic' => $topic->getIdTopic()]) ?>"
                                       class="btn btn-default btn-lg tooltip-link">
                                        <div class="">
                                            <img width="32" height="32" src="<?php echo "../".$target_dir.$topic->getImage(); ?>">
                                        </div>
<!--										<i class="fa fa-file-text-o fa-fw"></i>-->
								</a></span>
                            </div>
                            <div class="pull-right topic-pagination">
                                <div class="btn-group pagination-line">
                                    <a class="btn btn-default btn-xs tooltip-link"
                                       href="<?= $route->generateURL('Topic', 'getTopic', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum(), 'id_topic' => $topic->getIdTopic()]) ?>"
                                       title="Last post"><i class="fa fa-angle-double-right"></i></a>
                                </div>
                            </div>
                            <div class="forum-topic-icon-mobile">
                                <i class="fa fa-file-text-o"></i>
                            </div>
                            <a href="<?= $route->generateURL('Topic', 'getTopic', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum(), 'id_topic' => $topic->getIdTopic()]) ?>" class="topictitle">
                                <strong><?php echo $topic->getTitle(); ?></strong>
                            </a>
                            <br/>
                            <small>by <a href="<?php echo $_SERVER["PHP_SELF"]."?". "page=forum&id_user=" . $topic->getIdUser(); ?>">
                                    <?php echo $topic->getUser()->getUsername(); ?>
                                </a> &raquo;
                                <?php echo $topic->getDateAdd()->format("d-m-Y"); ?></small>

                            <?php
                            if (isset($user))
                                if ($user->getIdUser() === $topic->getUser()->getIdUser()){
                            ?>
                            <a href="<?php echo $_SERVER["PHP_SELF"]."?". "page=topic_edit&id_topic=" . $topic->getIdTopic(); ?>" class="topictitle">
                                <strong>Editar</strong>
                            </a>
                            <?php } ?>
                        </td>
                        <td ><span class="badge">No esta implementado</span></td>
                        <td ><span class="badge">No esta implementado</span></td>
                        <td ><span class="badge">No esta implementado</span></td>

                        <!--<td class="posts">
                            <span class="badge">1</span>
                        </td>
                        <td class="views">
                            <span class="badge">147</span>
                        </td>
                        <td class="lastpost"><span><dfn>Last post </dfn>by <a
                                        href="./memberlist.php?style=2&amp;mode=viewprofile&amp;u=80">demo</a>
							<a href="./viewtopic.php?style=2&amp;f=2&amp;t=44&amp;p=109#p109"><img
                                        src="./imageset/icon_topic_latest.gif" width="11" height="9"
                                        alt="View the latest post" title="View the latest post"/></a> <br/>Mon Dec 05, 2016 7:44 am</span>
                        </td>-->
                    </tr>
                <?php } ?>


                </tbody>
            </table>
        </div>

        <div class="row mobile-fix">

            <div class="col-md-3 col-xs-12"></div>
            <div class="col-md-6 text-center col-xs-12">
                <div class="btn-group forum-pagination">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php
                            if ($Previous>0){
                                ?>
                                <li>
<!--                                    --><?php //echo $_SERVER["PHP_SELF"]."?". "page=forum" . $query_Forum . $query_User . "&num_page=" . $Previous . $search . $dateIni . $dateFin; ?>
                                    <a href="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum()]) . '?' . "page=" . $Previous . $search . $dateIni . $dateFin;  ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo; Previous</span>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php for($i = 1; $i<= $pages; $i++) : ?>
<!--                                --><?php //echo $_SERVER["PHP_SELF"]."?". "page=forum" . $query_Forum . $query_User . "&num_page=" . $i . $search . $dateIni . $dateFin; ?>
                                <li><a href="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum()]) . '?' . "page=" . $i . $search . $dateIni . $dateFin; ?>"><?= $i; ?></a></li>
                            <?php endfor; ?>
                            <?php
                            if ($Next <= $pages){
                                ?>
                                <li>
<!--                                    --><?php //echo $_SERVER["PHP_SELF"]."?". "page=forum" . $query_Forum . $query_User . "&num_page=" . $Next . $search . $dateIni . $dateFin; ?>
                                    <a href="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $forum->getIdCategory(), 'id_forum' => $forum->getIdForum()]) . '?' . "page=" . $Next . $search . $dateIni . $dateFin; ?>" aria-label="Next">
                                        <span aria-hidden="true">Next &raquo;</span>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
</body>
</html>