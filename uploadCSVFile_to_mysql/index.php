<?php
/**
 * Created by JetBrains PhpStorm.
 * User: HP
 * Date: 01.12.15
 * Time: 1:07
 * To change this template use File | Settings | File Templates.
 */
include_once 'config.php';

if(isset($_POST['submit'])) {
    $file = $_FILES['file']['tmp_name'];

    $handle = fopen($file,"r");

    while(($fileop = fgetcsv($handle,1000,",")) !== false):

        $nazvanie       = $fileop[1];
        $art            = $fileop[2];
        $parent_art     = $fileop[3];
        $price          = $fileop[4];
        $izmerenie      = $fileop[5];

        $query = DB::run()->prepare("INSERT INTO products(nazvanie,art,parent_art,price,izmerenie)
                VALUES(:nazvanie, :art, :parent_art,:price, :izmerenie)");

        $query->execute([
            ':nazvanie'    => $nazvanie,
            ':art'         => $art,
            ':parent_art'  => $parent_art,
            ':price'       => $price,
            ':izmerenie'   => $izmerenie
        ]);
    endwhile;

    if($query) {
        echo 'Данные успешно загружены в базу! Вернутся <a href="index.php">назад.</a>';
    }
}
?>
<h2>Загрузка файла базы</h2>
<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<form action="loadBase.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file"/> | <input type="submit" name="submit" value="Load"/>
</form>
</body>
</html>
