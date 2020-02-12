<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb" data-ng-app>

<head>

    <meta charset="UTF-8"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="./theme/images/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title>Foro Programacion &bull; Home</title>

    <link rel="alternate" type="application/atom+xml" title="Feed - ComBoot Demo"
          href="https://demo.comboot.io/3.0/feed.php"/>
    <link rel="alternate" type="application/atom+xml" title="Feed - New Topics"
          href="https://demo.comboot.io/3.0/feed.php?mode=topics"/>

    <script type="text/javascript" src="./theme/styleswitcher.js"></script>
    <script type="text/javascript" src="./theme/forum_fn.js"></script>

    <link href="print.css" rel="stylesheet" type="text/css" media="print" title="printonly"/>
    <link href="./style.php?style=2&amp;id=2&amp;lang=en&amp;sid=16ded21954d6d0cebedcb072f1286d0b" rel="stylesheet"
          type="text/css" media="screen, projection"/>


    <?php
    require '../partials/head_partial.php';
    ?>

</head>

<body class="section-index ltr">

<?php
require '../partials/header_partial.php';
?>

<div class="container" id="content-wrapper">

    <?php
    //        if (!isset($categories)) ̣{
    foreach ($categories as $category) {

        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="topiclist">
                <tr>
                    <th class="forum-name"><i class="fa fa-sitemap"></i> <a
                                href="<?= $route->generateURL('Category', 'getCategory', ['id_category' => $category->getIdCategory()]) ?>">
                            <?php echo $category->getTitle(); ?>
                        </a></th>
                    <th class="topics"><i class="fa fa-comments-o"></i> Topics</th>
                    <th class="posts"><i class="fa fa-pencil-square-o"></i> Posts</th>
                    <th class="lastpost"><i class="fa fa-history"></i> <span>Last post</span></th>
                </tr>
                </thead>
                <tbody class="topiclist forums">

                <?php
                if (!empty($category->getForums())) {
                    foreach ($category->getForums() as $key => $forum) {
                        ?>
                        <tr>
                            <td class="forum-name" title="No unread posts">
							<span class="pull-left forum-icon">
								<a href="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $category->getIdCategory(), 'id_forum' => $forum->getIdForum()]) ?>"
                                   class="btn btn-lg btn-default tooltip-link">
                                    <div class="">
                                        <img width="32" height="32"
                                             src="<?php echo $target_dir . $forum->getImage(); ?>">
                                    </div>
                                    <!--									<i class="fa fa-folder fa-fw"></i>-->

								</a>
							</span>
                                <div class="forum-icon-mobile">

                                    <i class="fa fa-folder fa-fw"></i>

                                </div>
                                <a href="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $category->getIdCategory(), 'id_forum' => $forum->getIdForum()]) ?>"
                                   class="forumtitle"><?php echo $forum->getTitle(); ?></a><br/>
                                <small><?php echo $forum->getDescription(); ?></small>

                            </td>
                            <td><span class="badge">No esta implementado</span></td>
                            <td><span class="badge">No esta implementado</span></td>
                            <td><span class="badge">No esta implementado</span></td>
                            <!--<td class="topics"><span class="badge">36</span></td>
                            <td class="posts"><span class="badge">84</span></td>
                            <td class="lastpost"><span>
                        <dfn>Last post</dfn> by <a
                                            href="./memberlist.php?style=2&amp;mode=viewprofile&amp;u=80&amp;sid=16ded21954d6d0cebedcb072f1286d0b">demo</a>
                        <a
                                href="./viewtopic.php?style=2&amp;f=2&amp;p=109&amp;sid=16ded21954d6d0cebedcb072f1286d0b#p109"><img
                                    src="./imageset/icon_topic_latest.gif" width="11" height="9"
                                    alt="View the latest post" title="View the latest post"/></a> <br/>Mon Dec 05,
                        2016 7:44 am</span>
                            </td>-->

                        </tr>
                        <?php
                    }
                }
                ?>

                </tbody>
            </table>
        </div>
        <?php
    } ?>
</div>
</div>
</body>

</html>