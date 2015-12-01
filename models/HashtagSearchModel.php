<?php

/**
 * Class to fetch search results from GET/search/tweets
 * using Twitter API
 * 
 */
class HashtagSearchModel {

	private $t_response = NULL;
	private $error_status   = false;

	/**
	 * Constuctor function for HashtagSearchModel class
	 * fetches tweets containing the given hashtag
	 * 
	 * @param $hashtag, Hashtag for which tweets are to be searched on Twitter
	 */
	function __construct($hashtag = NULL, $next_results = NULL){

		// opening an oauth connection to Twitter API
		$api_connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, OAUTH_ACCESS_TOKEN, OAUTH_ACCESS_TOKEN_SECRET);

		if( $next_results ){
			// form the search endpoint with required parameters
			$api_url = BASE_URL . $next_results;
		} else {
			// form the search endpoint with required parameters
			$api_url = BASE_URL . '?q=' . urlencode( '#' . $hashtag ) . '&include_entities=false&result_type=recent&count=200';
		}

		// making API call on search endpoint along with the given hashtag
		$response = $api_connection->get( $api_url );

		/**
		 * Enable error-checking when this kind of response is returned
		 * {"errors":[{"message":"Could not authenticate you","code":32}]}
		 * {"errors":[{"message":"Rate limit exceeded","code":88}]}
		 */
		if ( isset($response->errors) || !isset($response->statuses) ) {
			$this->error_status = true;
		}

		$this->t_response = $response;

	}

	/**
	 * getErrorStatus() - function for getting the error_status flag for current HashtagSearchModel object 
	 * 
	 * @return bool, whatever is the error status after fetching tweets from Twitter API
	 */
	public function getErrorStatus(){
		return $this->error_status;
	}

	/**
	 * getTweets() - function for getting access to the tweets returned by API for the given hashtag
	 * 
	 * @return object, Twitter tweets response object is returned directly
	 */
	public function getTweets(){
		return $this->t_response;
	}

}
