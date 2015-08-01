<?php 


?>
<div class="container-quote-of-the-day">
	<div class="container-quote">
		<div class="the-quote tagline">
			<span class="line-quote">Les meilleurs citations du rap français</span>
		</div>
		<div class="background-quote" back-img="https://unsplash.it/1500?random"></div>
		<div class="gradient-background-quote"></div>
	</div>
</div>
<div class="container-trending-quotes">
	<span class="small-title">Citations du moment</span>
	<div style = "clear: both; display: table;"></div>
	<?php
		$TrendingQuotes = Quote::getTrendingQuotes();
		
		for ($i=0; $i < count($TrendingQuotes) ; $i++) { 
			$Quote = $TrendingQuotes[$i];
	?>
		<div class="container-quote <?=($i == 0) ? 'featured-quote' : '' ;?>">
			<div class="the-quote">
				<span class="line-quote"><?= str_replace ("\\n", "<br/>", $Quote->content);?></span>
	            <div style = "clear: both; display: table;"></div>
				<span class="author-quote"><?= $Quote->Artist->name;?></span>
			</div>
			<div class="background-quote" back-img="<?= $Quote->url_image;?>"></div>
			<div class="gradient-background-quote"></div>
			<div class="box-border-white"></div>
		</div>
	<?php
		}
	?>
	<div style = "clear: both; display: table;"></div>
</div>