<a href="<?= $app->urlFor('quoteUrl', array('hashID' => $Quote->hashid));?>">
	<div class="container-quote <?= $mode;?>">
		<div class="the-quote">
			<span class="line-quote"><?= str_replace ("\\n", "<br/>", $Quote->content);?></span>
	        <div style = "clear: both; display: table;"></div>
			<span class="author-quote"><?= $Quote->Artist->name;?></span>
		</div>
		<div class="background-quote" back-img="<?= $Quote->url_image;?>"></div>
		<div class="gradient-background-quote"></div>
		<div class="box-border-white"></div>
	</div>
</a>