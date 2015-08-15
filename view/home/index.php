<?php 


?>
<div class="container-quote-of-the-day">
	<div class="container-quote">
		<div class="the-quote tagline">
			<span class="line-quote">Les meilleurs citations du rap</span>
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
			$mode = "";
			if($i == 0){
				$mode = 'featured-quote';
			}
			$app->render('quotes/container/container-quote.php',
               array(
                   'Quote' => $Quote,
                   'mode' => $mode,
                   'app' => $app
               ));
		}
	?>
	<div style = "clear: both; display: table;"></div>
</div>