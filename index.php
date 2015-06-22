<?php
    /**
     * Created by PhpStorm.
     * User: Personne
     * Date: 20/06/2015
     * Time: 16:13
     */

    // require autoload / composer
    require './model/core.php';
    require './vendor/autoload.php';


?>

<html>
<head>
    <meta charset = "UTF-8">
</head>
<body>
<h1>S3 upload example</h1>
<?php
    $Quote = new Quote(37, ['isHashID'=>false]);
?>
<img src = "<?php echo $Quote->url_image; ?>" />
<?php
    die();
?>
<h2>Upload a file</h2>

<form enctype = "multipart/form-data" action = "<?= $_SERVER['PHP_SELF'] ?>" method = "POST">
    <input name = "userfile" type = "file"><input type = "submit" value = "Upload">
</form>
</body>
</html>
