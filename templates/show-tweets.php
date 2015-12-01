<?php
	
	include 'header.php';

?>

<body class="container">
	<div class="visibile-lg" style="margin: 5% 0;"></div>
	<div class="container text-center">
		<img class="image-head" src="img/3be2c501646a37b5de1f6381df25a4dd.png">
		<div><p style="font-family: 'Poiret One', cursive;">Showing recent tweets for #custserv with atleast one retweet</p></div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div id="instant_results">
					<?php

						/**
						 * ERROR HANDLING
						 */
						if ( !$error && isset($t_response->statuses) ) {
						
							$tweets = $t_response->statuses;

							foreach($tweets as $tweet){
								// TRICKY: Change the condition to this, if you don't want to display retweets/quoted tweets
								// if ( $tweet->retweet_count == 0 || isset($tweet->retweeted_status) || isset($tweet->quoted_status))
								if ( $tweet->retweet_count == 0){
									continue;	// skip this tweet
								}
								echo "<div class='timeline-tweets'>";
								echo "<img src='".$tweet->user->profile_image_url."' class='img-thumbnail timeline' width='50'>";
								echo "<p><a href='http://twitter.com/intent/user?screen_name=".$tweet->user->screen_name."' target='_blank'>".($tweet->user->name)." <span class='text-muted'>@".$tweet->user->screen_name."</span></a></p>";
								echo ($tweet->text)."<br>";
								echo "<span class='text-muted small'>".date("g:i: A D, F jS Y",strtotime($tweet->created_at))."</span>";
								echo "<p class='tweet-controls'>";
								echo "<a href='https://twitter.com/intent/tweet?in_reply_to=".$tweet->id_str."' target='_blank'> Reply</a>  |  <a href='https://twitter.com/intent/favorite?tweet_id=".$tweet->id_str."' target='_blank'>Favorite</a>  |  <a href='https://twitter.com/intent/retweet?tweet_id=".$tweet->id_str."' target='_blank'>Retweet</a>";
								echo "</p>";
								echo "</div>";
							}

							/**
							 * If Search Metadata is present in Twitter API response,
							 * save the max_id in a hidden input field
							 */
							if( isset($t_response->search_metadata) && isset($t_response->search_metadata->next_results) ){
								echo "<input type='hidden' value='" . $t_response->search_metadata->next_results . "' id='next_results_hidden' />";
							}

						}
						else{

							echo "<h2> Sorry, we encountered a problem in fetching the tweets. Please try again in some time. </h2>";

						}

					?>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-4 loader_gif">

			</div>
		</div>
	</div>
	<div class="visibile-lg" style="margin: 5% 0;"></div>

<?php
	
	include 'footer.php';

?>
