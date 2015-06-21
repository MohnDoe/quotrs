<?php
    /**
     * Created by PhpStorm.
     * User: Personne
     * Date: 20/06/2015
     * Time: 16:13
     */

    // require autoload / composer
    require 'model/core.php';

?>

<html>
<head>
    <meta charset = "UTF-8">
</head>
<body>
<h1>S3 upload example</h1>
<?php
    $Quote = new Quote(1, ['isHashID'=>false]);
?>
<img src = "<?php echo $Quote->url_image; ?>" />
<?php
    die();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK && is_uploaded_file ($_FILES['userfile']['tmp_name'])) {
        // FIXME: add more validation, e.g. using ext/fileinfo
        try {
            // FIXME: do not use 'name' for upload (that's the original filename from the user's computer)
            $upload = $_AWS_S3_CLIENT->upload (S3_BUCKET_NAME, $_FILES['userfile']['name'], fopen ($_FILES['userfile']['tmp_name'], 'rb'), 'public-read');

            var_dump ($_AWS_S3_CLIENT->doesObjectExist (S3_BUCKET_NAME, $_FILES['userfile']['name']));

            ?>
            <p>Upload <a href = "<?= htmlspecialchars ($upload->get ('ObjectURL')) ?>">successful</a> :)</p>
        <?php } catch (Exception $e) {
            var_dump ($e);
            ?>
            <p>Upload error :(</p>
        <?php }
    } ?>
<h2>Upload a file</h2>

<form enctype = "multipart/form-data" action = "<?= $_SERVER['PHP_SELF'] ?>" method = "POST">
    <input name = "userfile" type = "file"><input type = "submit" value = "Upload">
</form>
</body>
</html>
