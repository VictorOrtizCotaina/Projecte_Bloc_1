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

    <link rel="alternate" type="application/atom+xml" title="Feed - ComBoot Demo"
          href="https://demo.comboot.io/3.0/feed.php"/>
    <link rel="alternate" type="application/atom+xml" title="Feed - New Topics"
          href="https://demo.comboot.io/3.0/feed.php?mode=topics"/>

    <script type="text/javascript" src="./theme/styleswitcher.js"></script>
    <script type="text/javascript" src="./theme/forum_fn.js"></script>

    <link href="print.css" rel="stylesheet" type="text/css" media="print" title="printonly"/>
    <link href="./style.php?style=2&amp;id=2&amp;lang=en&amp;sid=16ded21954d6d0cebedcb072f1286d0b" rel="stylesheet"
          type="text/css" media="screen, projection"/>

    <link href="./theme/comboot/comboot.css" rel="stylesheet"/>
    <link href="./theme/comboot/font-awesome.min.css" rel="stylesheet"/>
    <link href="./theme/comboot/colorpicker.min.css" rel="stylesheet"/>
    <link href="./theme/comboot/lightbox.css" rel="stylesheet"/>
    <link href="./theme/comboot/select.min.css" rel="stylesheet"/>
    <link href="./theme/comboot/syntax-highlighting.css" rel="stylesheet"/>
    <link href="./theme/css/bootstrap.min.css" rel="stylesheet">
    <link href="./theme/bootstrap.min.css" rel="stylesheet">

    <script src="./theme/comboot/jquery.min.js" type="text/javascript"></script>
    <script src="./theme/editor.js" type="text/javascript"></script>
    <script src="./theme/comboot/angular.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/progressbar.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/bootstrap.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/colorpicker.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/lightbox.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/select.min.js" type="text/javascript"></script>
    <script src="./theme/comboot/syntax-highlighting.js" type="text/javascript"></script>
    <script src="./theme/comboot/comboot.js" type="text/javascript"></script>


    <link href="./theme/fontawesome/css/all.min.css" rel="stylesheet"/>
    <script src="./theme/fontawesome/js/all.min.js" type="text/javascript"></script>


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

    <div class="user-details container">

        <div class="user-image rounded">

            <img src="<?php echo $target_dir . $user->getAvatar(); ?>">

        </div>
        <div class="user-info-block panel panel-default">
            <div class="user-heading">
                <h3><?php echo $user->getUsername(); ?></h3>

            </div>
            <ul class="navigation">
                <li class="active">
                    <a><span class="glyphicon glyphicon-user"></span></a>
                </li>
            </ul>
            <div class="user-body panel-body">

                <div class=" row">
                    <div class=" col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading btn-panel">
                                <h3 class="panel-title">
                                    User Config
                                </h3>
                                <span class="pull-right btn-group panel-right">
									
								</span>
                            </div>
                            <div class="panel-body">
                                <div class="form-horizontal">

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Username:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo $user->getUsername(); ?></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Email:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo $user->getEmail(); ?></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <form method="POST"
                                              action="<?php echo $_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"]; ?>"
                                              enctype="multipart/form-data">
                                            <label class="control-label col-md-3">Password:</label>
                                            <div class="col-md-9">
                                                <input class="form-control col-md-8" placeholder="******"
                                                       type="password" id="password" name="password">
                                                <input class="btn-default" type="submit" name="passBtn" value="Change"/>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="form-group">
                                        <form method="POST"
                                              action="<?php echo $_SERVER["PHP_SELF"] . "?" . $_SERVER["QUERY_STRING"]; ?>"
                                              enctype="multipart/form-data">
                                            <label class="control-label col-md-3">Upload a File:</label>
                                            <div class="col-md-9">
                                                <input type="file" name="image"/>
                                                <input type="submit" name="imageBtn" value="Upload"/>
                                            </div>
                                            <?php
                                            if (!empty($imageErrors)) {
                                                foreach ($imageErrors as $error) {
                                                    echo "<p>".$error."</p>";
                                                }
                                            }
                                            ?>
                                        </form>
                                    </div>


                                    <div class="form-group">
                                        <!--Implementació una vegada es tinga en conte el llenguatge.-->
                                        <label class="control-label col-md-3">Idioma:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo $user->getLang(); ?></p>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">User statistics</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Joined:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo $user->getDateAdd()->format("d-m-Y"); ?></p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>