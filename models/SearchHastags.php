<?php

class SearchHastags {

	private $twitter_response = NULL;
	private $error   = false;


	/**
	 * Constuctor function for getting response from Twitter Search API
	 * @param none
	 * @return none | constructor function
	 */
	function __construct(){

		// opening an oauth connection to Twitter API
		$api_connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_ACCESS_TOKEN, OAUTH_ACCESS_TOKEN_SECRET);

		$api_url = BASE_URL . '?q=' . urlencode( '#' . HASHTAG ) . '&include_entities=false&result_type=recent&count=200';

		// making API call on search endpoint along with the given hashtag
		$response = $api_connection->get($api_url);

		if(isset($response->errors) || !isset($response->statuses)){
			$this->error = true;
		}

		$this->twitter_response = $response;

	}


	/**
	 * returnTwitterResponse() - function to get twitter Response returned by API since response is private
	 * 
	 * @param none
	 * @return object, Twitter response object is returned directly
	 */
	public function returnTwitterResponse(){
		return $this->twitter_response;
	}


	/**
	 * returnError() - function to get the bool error flag for SearchHastags object 
	 * 
	 * @param none
	 * @return bool, error status according to response from Twitter API
	 */
	public function returnError(){
		return $this->error;
	}
}