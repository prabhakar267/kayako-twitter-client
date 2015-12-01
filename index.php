<?php

	// include Open Source Twitter OAuth Library
	require_once 'inc/lib/twitteroauth.php';
	
	require_once 'inc/config.inc.php';
	require_once 'models/SearchHastags.php';


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


	// Routes
	$app->map('/', 'renderView')
		->via('GET');

	$app->map('/fetch-tweets', 'returnTwitterResponse')
		->via('GET');

	$app->run();


	/**
	 * returnTwitterResponse() - function to fetch tweets for the api having all the tweets
	 * 				 - and shows a JSON array 
	 * @param none
	 * @return none
	 */
	function returnTwitterResponse(){
		global $app;

		//final response array to be printed
		$response = array(
			'error'		=> true,
			'tweets'	=> array(),
		);

		// instantiate new hashtagsearch with the given hashtag
		$searched_hashtag = new SearchHastags(HASHTAG);

		if(!($searched_hashtag->returnError())){
			$response['error'] = false;

			// get object of matched tweets
			$all_tweets = $searched_hashtag->returnTwitterResponse();
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
							'image_pr'	=> $tweet['user']['profile_image_url_https'],
						),
						'time'				=> strtotime($tweet['created_at']),
						'tweet_url'			=> 'https://twitter.com/' . $tweet['user']['screen_name'] . '/status/' . $tweet['id'],
					);
					array_push($response['tweets'], $tweet_to_be_added);
				}
			}
		}
		echo json_encode($response);
	}


	/**
	 * renderView() - function to fetch tweets for the api having all the tweets
	 * 				 - and shows a JSON array 
	 * @param - none
	 * @return - Renders the display for '/' route
	 */
	function renderView(){
		global $app;
		// render the view and send the matched tweets object
		$app->render (
			'homepage.php',
			array(),
			200
		);
	}