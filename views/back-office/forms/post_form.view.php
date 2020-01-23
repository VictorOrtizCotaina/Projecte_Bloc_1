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
                    <h1 class="h2">Post</h1></div>
                <div class="table-responsive">
                    <form action="<?= $pageForm; ?>" method="post" enctype="multipart/form-data">
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
                            <label for="text" style="font-size: x-large">Texto</label>
                            <textarea class="form-control " id="text" name="text" ><?php if (isset($text)) echo $text; ?></textarea>
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
                            if (isset($errors["date"]) && $errors["date"]!==true){
                                echo "<p style='color: #6c170c; font-weight: bold;'>".$errors["date"]."</p>";
                            }
                            ?>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="user" style="font-size: x-large">User</label>
                            <input type="text" class="form-control" id="user" name="user" value="<?php if (isset($id_user)) echo $id_user; ?>">
                            <?php
                            if (isset($errors["author"]) && $errors["author"]!==true){
                                echo "<p style='color: #6c170c; font-weight: bold;'>".$errors["author"]."</p>";
                            }
                            ?>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="topic" style="font-size: x-large">Topic</label>
                            <input type="text" class="form-control" id="topic" name="topic" value="<?php if (isset($id_topic)) echo $id_topic; ?>">
                            <?php
                            if (isset($errors["topic"]) && $errors["topic"]!==true){
                                echo "<p style='color: #6c170c; font-weight: bold;'>".$errors["topic"]."</p>";
                            }
                            ?>
                        </div>
                        <hr>
                        <?php
                        if ($page == "post_add"){
                            ?>
                            <input type="submit" class="btn btn-primary" name="add" value="Añadir">
                        <?php } ?>
                        <?php
                        if ($page == "post_edit"){
                            ?>
                            <input type="submit" class="btn btn-primary" name="edit" value="Aceptar">
                        <?php } ?>
                        <a class="btn btn-primary" href="<?= $route->generateURL('Post', 'getAdminPost'); ?>">Volver</a>
                    </form>
                </div>
            </main>
        </div>
</body>
</html>
