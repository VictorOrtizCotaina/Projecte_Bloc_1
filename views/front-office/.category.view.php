<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb" data-ng-app>

<head>

    <meta charset="UTF-8"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="./theme/images/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title>Foro Programacion &bull; <?php echo $category->getTitle(); ?></title>


    <?php
    require '../partials/head_partial.php';
    ?>

</head>

<body class="section-index ltr">

<?php
require '../partials/header_partial.php';
?>


<div class="container" id="content-wrapper">


    <div class="page-header">
        <h2><?php echo $category->getTitle(); ?></h2>
    </div>

    <?php
    foreach ($category->getForums() as $key => $forum) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="topiclist">
                <tr>
                    <th class="forum-name"><i class="fa fa-folder-open"></i> Forum</th>
                    <th class="topics"><i class="fa fa-comments-o"></i> Topics</th>
                    <th class="posts"><i class="fa fa-pencil-square-o"></i> Posts</th>
                    <th class="lastpost"><i class="fa fa-history"></i> <span>Last post</span></th>
                </tr>
                </thead>
                <tbody class="topiclist forums">

                <tr>
                    <td class="forum-name" title="No unread posts">
						<span class="pull-left forum-icon">
							<a href="<?= $route->generateURL('Forum', 'getForum', ['id_category' => $category->getIdCategory(), 'id_forum' => $forum->getIdForum()]) ?>"
                               class="btn btn-lg btn-default tooltip-link" title="No unread posts">
                                <div class="">
                                    <img width="32" height="32" src="<?php echo $target_dir . $forum->getImage(); ?>">
                                </div>
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
                        <dfn>Last post</dfn> by <a href="./memberlist.php?style=2&amp;mode=viewprofile&amp;u=80">demo</a>
                        <a href="./viewtopic.php?style=2&amp;f=2&amp;p=109#p109"><img src="./styles/comboot-free/imageset/icon_topic_latest.gif" width="11" height="9" alt="View the latest post" title="View the latest post" /></a> <br />Mon Dec 05, 2016 7:44 am</span>
                    </td>-->

                </tr>

                </tbody>
            </table>
        </div>
    <?php } ?>
</div>
</body>
</html>