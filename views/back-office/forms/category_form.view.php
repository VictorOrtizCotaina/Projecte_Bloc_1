<?php global $route; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-gb" xml:lang="en-gb" data-ng-app>

<head>

    <meta charset="UTF-8"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="/Projecte_Bloc_1/theme/images/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <title>Back-Office &bull; Category</title>

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
                    <h1 class="h2">Categories</h1></div>
                <div class="table-responsive">
                    <?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER["QUERY_STRING"]; ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . "?" . $_SERVER["QUERY_STRING"]; ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title" style="font-size: x-large;">Titulo</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?php if (isset($title)) echo $title; ?>" >
                            <?php
                            if (isset($errors["title"]) && $errors["title"]!==true){
                                echo "<p style='color: #6c170c; font-weight: bold;'>".$errors["title"]."</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="description" style="font-size: x-large">Descripcion</label>
                            <textarea class="form-control " id="description" name="description" ><?php if (isset($description)) echo $description; ?></textarea>
                            <?php
                            if (isset($errors["description"]) && $errors["description"]!==true){
                                echo "<p style='color: #6c170c; font-weight: bold;'>".$errors["description"]."</p>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <?php if (!empty($image)) {?>
                                <img width="100" height="100" src="<?php echo $image; ?>">
                            <?php } ?>
                            <label for="image" style="font-size: x-large">Upload a File:</label>
                            <input type="file" name="image"/>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="date" style="font-size: x-large">Fecha</label>
                            <input type="date" class="form-control " id="date" name="date" value="<?php if (isset($date)) echo $date; ?>">
                            <?php
                            if (isset($errors["date_add"]) && $errors["date_add"]!==true){
                                echo "<p style='color: #6c170c; font-weight: bold;'>".$errors["date_add"]."</p>";
                            }
                            ?>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="user" style="font-size: x-large">User</label>
                            <input type="text" class="form-control" id="user" name="user" value="<?php if (isset($id_user)) echo $id_user; ?>">
                            <?php
                            if (isset($errors["user"]) && $errors["user"]!==true){
                                echo "<p style='color: #6c170c; font-weight: bold;'>".$errors["user"]."</p>";
                            }
                            ?>
                        </div>
                        <hr>
                        <?php
                        if ($page == "category_add"){
                            ?>
                            <input type="submit" class="btn btn-primary" name="add" value="Añadir">
                        <?php } ?>
                        <?php
                        if ($page == "category_edit"){
                            ?>
                            <input type="submit" class="btn btn-primary" name="edit" value="Aceptar">
                        <?php } ?>
                        <a class="btn btn-primary" href="<?= $route->generateURL('Category', 'getAdminCategory');  ?>">Volver</a>
                    </form>
                </div>
            </main>
        </div>
</body>
</html>
