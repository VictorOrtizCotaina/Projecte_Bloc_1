<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb" data-ng-app>

<head>

	<meta charset="UTF-8" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="shortcut icon" href="./theme/images/favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

	<title>Foro Programacion &bull; Login</title>

	<link href="./theme/comboot/comboot.css" rel="stylesheet" />
	<link href="./theme/comboot/font-awesome.min.css" rel="stylesheet" />
	<link href="./theme/comboot/colorpicker.min.css" rel="stylesheet" />
	<link href="./theme/comboot/lightbox.css" rel="stylesheet" />
	<link href="./theme/comboot/select.min.css" rel="stylesheet" />
	<link href="./theme/comboot/syntax-highlighting.css" rel="stylesheet" />
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

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>


</head>

<body class="section-index ltr">
    <?php
    require 'partials/header_partial.php';
    ?>

    <div class="container">

    <div class="row">
		<div class="col-sm-3"></div>
        <aside class="col-sm-5">
            <h1>Login</h1>

            <div class="card">
                <article class="card-body ">
                <a href="<?= $route->generateURL('User', 'register') ?>" class="float-right btn btn-outline-primary">Registro</a>
                    <h4 class="card-title mb-4 mt-1">Login</h4>
                    <hr>
                    <?php
                        if (!empty($error)){
                    ?>
                        <p class="text-danger text-center">
                            <?php echo $error; ?>
                        </p>
                    <?php } ?>
                    <form action="<?= $route->generateURL('User', 'login') ?>" method="POST">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input type="email" class="form-control" placeholder="Email" id="email" name="email">
                            </div> <!-- input-group.// -->
                        </div> <!-- form-group// -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input class="form-control" placeholder="******" type="password" id="password" name="password">
                            </div> <!-- input-group.// -->
                        </div> <!-- form-group// -->
                        <div class="form-group">
                            <div class="checkbox">
                                <label> <input type="checkbox"> Save email </label>
                            </div> <!-- checkbox .// -->
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block"> Login  </button>
                        </div> <!-- form-group// -->
                    </form>
                </article>
            </div> <!-- card.// -->

        </aside> <!-- col.// -->
		<div class="col-sm-3"></div>

    </div> <!-- row.// -->

</div>
</body>

</html>