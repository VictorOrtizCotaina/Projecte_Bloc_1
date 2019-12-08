<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb" data-ng-app>

<head>

    <meta charset="UTF-8"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="./theme/images/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title>Foro Programacion &bull; <?php echo $topic->getTitle(); ?></title>

    <link href="./../../theme/comboot/comboot.css" rel="stylesheet"/>
    <link href="./../../theme/comboot/font-awesome.min.css" rel="stylesheet"/>
    <link href="./../../theme/comboot/colorpicker.min.css" rel="stylesheet"/>
    <link href="./../../theme/comboot/lightbox.css" rel="stylesheet"/>
    <link href="./../../theme/comboot/select.min.css" rel="stylesheet"/>
    <link href="./../../theme/comboot/syntax-highlighting.css" rel="stylesheet"/>
    <link href="./../../theme/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../../theme/bootstrap.min.css" rel="stylesheet">

    <script src="./../../theme/comboot/jquery.min.js" type="text/javascript"></script>
    <script src="./../../theme/editor.js" type="text/javascript"></script>
    <script src="./../../theme/comboot/angular.min.js" type="text/javascript"></script>
    <script src="./../../theme/comboot/progressbar.min.js" type="text/javascript"></script>
    <script src="./../../theme/comboot/bootstrap.min.js" type="text/javascript"></script>
    <script src="./../../theme/comboot/colorpicker.min.js" type="text/javascript"></script>
    <script src="./../../theme/comboot/lightbox.min.js" type="text/javascript"></script>
    <script src="./../../theme/comboot/select.min.js" type="text/javascript"></script>
    <script src="./../../theme/comboot/syntax-highlighting.js" type="text/javascript"></script>
    <script src="./../../theme/comboot/comboot.js" type="text/javascript"></script>


    <link href="./../../theme/fontawesome/css/all.min.css" rel="stylesheet"/>
    <script src="./../../theme/fontawesome/js/all.min.js" type="text/javascript"></script>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>


</head>

<body class="section-index ltr">

<?php
require 'partials/header_partial.php';
?>

	<div class="container" id="content-wrapper">

	<div class="panel panel-default">
		<div class="panel-body">
			<h4><?php echo $topic->getTitle(); ?></h4>
            <p><?php echo $topic->getDescription(); ?></p>
		</div>
	</div>


<div class="row mobile-fix">
	
    <div class="col-md-3"></div>
    <div class="col-md-6 text-center col-xs-12">
        <div class="btn-group forum-pagination">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    if ($Previous>0){
                        ?>
                        <li>
                            <a href="<?php echo $_SERVER["PHP_SELF"]."?". "page=topic&id_topic=" . $id_topic . "&num_page=" . $Previous; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo; Previous</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php for($i = 1; $i<= $pages; $i++) : ?>
                        <li><a href="<?php echo $_SERVER["PHP_SELF"]."?". "page=topic&id_topic=" . $id_topic . "&num_page=" . $i; ?>"><?= $i; ?></a></li>
                    <?php endfor; ?>
                    <?php
                    if ($Next <= $pages){
                        ?>
                        <li>
                            <a href="<?php echo $_SERVER["PHP_SELF"]."?". "page=topic&id_topic=" . $id_topic . "&num_page=" . $Next; ?>" aria-label="Next">
                                <span aria-hidden="true">Next &raquo;</span>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </div>

</div>
<div class="clearfix"></div>


        <?php
            foreach ($posts as $post){
        ?>
	<div >
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title first pull-left"><?php echo $post->getTitle(); ?></h3>

				<div class="clearfix"></div>
			</div>
			<div class="panel-body no-padding ">
				<div class="row no-margin">
				
					<div class="col-md-3 col-xs-12 post-info post-info-left">
						<dl id="profile108" class="no-margin-xs">
							<dt class="avatar text-center rounded">
                                <img width="100" height="100" src="<?php echo $target_dir.$post->getUser()->getAvatar(); ?> " alt="avatar">
							</dt>
							<dd class="text-center">
								<a href="<?php echo $_SERVER["PHP_SELF"] . "?page=forum&id_user={$post->getIdUser()}"; ?>">
                                    <?php echo $post->getUser()->getUsername(); ?>
                                </a>
							</dd>
							
						</dl>
						<dl class="hidden-xs">
							<dt>
								<hr/>
							</dt>
							<!--<dd><strong>Posts:</strong> 88</dd>--><dd><strong>Joined:</strong> <?php echo $post->getUser()->getDateAdd()->format("Y-m-d H:i"); ?></dd>
						</dl>
					</div>
				
				<div class="col-md-9 col-xs-12 post-content post-content-right">
					
						<div class="row post-head hidden-xs no-margin-bottom">
							<div class="col-md-6 col-xs-6 author">
								by <strong><a href="<?php echo $_SERVER["PHP_SELF"]."?". "page=forum&id_user=" . $post->getIdUser(); ?>">
                                        <?php echo $post->getUser()->getUsername(); ?></a></strong> &raquo;
                                <?php echo $post->getDateAdd()->format("Y-m-d H:i"); ?>
							</div>
							<div class="col-md-6 col-xs-6 no-padding">
								
							</div>
   						</div>
						<div class="content">
                            <?php echo $post->getText(); ?>
						</div>
						
				</div>
				</div>
			</div>
        </div>
	</div>
        <?php } ?>


<div class="row mobile-fix">

    <div class="col-md-3"></div>
    <div class="col-md-6 text-center col-xs-12">
        <div class="btn-group forum-pagination">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    if ($Previous>0){
                        ?>
                        <li>
                            <a href="<?php echo $_SERVER["PHP_SELF"]."?". "page=topic&id_topic=" . $id_topic . "&num_page=" . $Previous; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo; Previous</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php for($i = 1; $i<= $pages; $i++) : ?>
                        <li><a href="<?php echo $_SERVER["PHP_SELF"]."?". "page=topic&id_topic=" . $id_topic . "&num_page=" . $i; ?>"><?= $i; ?></a></li>
                    <?php endfor; ?>
                    <?php
                    if ($Next <= $pages){
                        ?>
                        <li>
                            <a href="<?php echo $_SERVER["PHP_SELF"]."?". "page=topic&id_topic=" . $id_topic . "&num_page=" . $Next; ?>" aria-label="Next">
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