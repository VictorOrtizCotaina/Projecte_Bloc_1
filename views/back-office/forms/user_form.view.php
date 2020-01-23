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

    <title>Back-Office &bull; Topic</title>

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
                    <h1 class="h2">User</h1></div>
                <div class="table-responsive">
                    <form action="<?=   $route->generateURL('User', 'adminUserEdit', ["id_user" => $id_user]); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title" style="font-size: x-large;">Username</label>
                            <input type="text" class="form-control" id="username" name="username" disabled value="<?php if (isset($username)) echo $username; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="title" style="font-size: x-large;">Email</label>
                            <input type="text" class="form-control" id="email" name="email" disabled value="<?php if (isset($email)) echo $email; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="title" style="font-size: x-large;">Name</label>
                            <input type="text" class="form-control" id="name" name="name" disabled value="<?php if (isset($name)) echo $name; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="title" style="font-size: x-large;">Surnames</label>
                            <input type="text" class="form-control" id="surname" name="surname" disabled value="<?php if (isset($surnames)) echo $surnames; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="title" style="font-size: x-large;">Province</label>
                            <input type="text" class="form-control" id="province" name="province" disabled value="<?php if (isset($province)) echo $province; ?>" >
                        </div>
                        <div class="form-group">
                            <label for="title" style="font-size: x-large;">Lang</label>
                            <input type="text" class="form-control" id="lang" name="lang" disabled value="<?php if (isset($lang)) echo $lang; ?>" >
                        </div>
                        <div class="form-group">
                            <?php if (!empty($avatar)) {?>
                                <img width="100" height="100" src="<?php echo $avatar; ?>">
                            <?php } ?>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="date" style="font-size: x-large">Fecha</label>
                            <input type="date" class="form-control " id="date" name="date" disabled value="<?php if (isset($date)) echo $date; ?>">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="user" style="font-size: x-large">User Group</label>
                            <select class="form-control" id="user_group" name="user_group">
                                <option value="1" <?php if (isset($user_group) && $user_group == 1) echo "selected"; ?> >Admin</option>
                                <option value="2" <?php if (isset($user_group) && $user_group == 2) echo "selected"; ?> >User</option>
                            </select>
<!--                            <input type="text" class="form-control" id="user_group" name="user_group" value="--><?php //if (isset($user_group)) echo $user_group; ?><!--">-->
                            <?php
                            if (isset($errors["user_group"]) && $errors["user_group"]!==true){
                                echo "<p style='color: #6c170c; font-weight: bold;'>".$errors["user_group"]."</p>";
                            }
                            ?>
                        </div>
                        <hr>
                        <input type="submit" class="btn btn-primary" name="edit" value="Aceptar">
                        <a class="btn btn-primary" href="<?= $route->generateURL('User', 'getAdminUser'); ?>">Volver</a>
                    </form>
                </div>
            </main>
        </div>
</body>
</html>
