<?php

	// include Twitter Oauth Library
	require_once 'inc/lib/twitteroauth.php';
	
	// include config files
	require_once 'inc/config.inc.php';

	// include all models
	require_once 'models/HashtagSearchModel.php';

	// include Slim
	require 'Slim/Slim.php';
	\Slim\Slim::registerAutoloader();

	// initiate Slim in DEBUG mode
	$app = new \Slim\Slim(array(
		'debug' => true,
		'mode' => 'development',
		'log.enables' => true,
		'log.level' => \Slim\Log::DEBUG
	));
	$app->config('debug', true);

	/** Routes */
	$app->map('/fetch-tweets', 'showCustservTweets')
		->via('GET');

	$app->run();


	/**
	 * showCustservTweets() - function catering to route '/'
	 * 
	 * @return renders template `show-tweets.php` with the fetched tweets
	 */
	function showCustservTweets(){
		global $app;

		//final response array to be printed
		$response = array(
			'error'		=> true,
			'tweets'	=> array(),
		);

		// instantiate new hashtagsearch with the given hashtag
		$hashtag_search = new HashtagSearchModel(HASHTAG);

		if(!($hashtag_search->getErrorStatus())){
			$response['error'] = false;

			// get object of matched tweets
			$all_tweets = $hashtag_search->getTweets();
			$all_tweets = json_decode(strip_tags(json_encode($all_tweets)), true);

			foreach($all_tweets['statuses'] as $tweet){
				//To incorporate the retweet filter
				if($tweet['retweet_count'] > 0){	
					$tweet_to_be_added = array(
						'tweet_id'			=> $tweet['id'],
						'text'				=> $tweet['text'],
						'retweet_count'		=> $tweet['retweet_count'],
						'favorite_count'	=> $tweet['favorite_count'],
						'user'				=> array(
							'name'		=> $tweet['user']['name'],
							'handle'	=> $tweet['user']['screen_name'],
							'profile'	=> $tweet['user']['profile_image_url_https'],
						),
						'time'				=> strtotime($tweet['created_at']),
						'tweet_url'			=> 'https://twitter.com/' . $tweet['user']['screen_name'] . '/status/' . $tweet['id'],
						'truncated'			=> $tweet['truncated'],
					);
					array_push($response['tweets'], $tweet_to_be_added);
				}
			}

		}

		echo json_encode($response);

	}

	function renderView(){

	}

