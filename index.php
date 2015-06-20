<?php
/**
 * Created by PhpStorm.
 * User: Personne
 * Date: 20/06/2015
 * Time: 16:13
 */

    // require autoload / composer
    require 'model/core.php';

    // test HashID with quote
    if(isset($_GET['quote_hashid'])){
        $Quote = new Quote($_GET['quote_hashid']);
    }
    if(isset($_GET['quote_id'])){
        echo "Quote ID";
        $Quote = new Quote($_GET['quote_id'], false);
    }
    ?>
<pre>
    <?php
        var_dump($Quote);
    ?>
</pre>
