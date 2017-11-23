<?php
/**
	ISS Crawler | Degananda Ferdian Priyambada
	Twitter API
**/
include_once('./library/twitteroauth-0.5.3/autoload.php');
/**
	ISS Crawler Lib
**/
include_once('./keyword.php');
use Abraham\TwitterOAuth\TwitterOAuth; // Connect to twitter
class Crawler extends Keyword {
	// twitter auth
	private $connection;
	private $content;
	private $statuses;


	private function twitterAuth(){
		try {
		$access_token = '';
		$access_token_secret = '';
		$this->connection = new TwitterOAuth('LDx4bNBKhYcyOBFpK2G9nbSOH', 'LGgxX0E3cXUDZ4idMFAU9jBTsquh91QaHQfa4Q79NxP9lavLYV', $access_token, $access_token_secret);
		$this->connection->setTimeouts(10, 15);
		$this->content = $this->connection->get("account/verify_credentials");
		} catch(Exception $e){
			echo 'Request time out';
		}
	}


	public function __construct(){
	    set_time_limit(0);
		parent::__construct();
		// set construct
		$this->twitterAuth();
		try {
		$this->statuses = $this->connection->get("search/tweets", 
			array(
				// from:e100ss @e100ss&src=typd
				"q" => "%23setnov",
				"src" => "recent"
			)
		);
		$encoded_raw_message = json_decode(json_encode($this->statuses),true);
		} catch(Exception $e){

		}
		/** 
			Tweets JSON PARSE.
		**/
		foreach($encoded_raw_message['statuses'] as $val){
			print_r($val);
		}

		/**
			Get Next Page
		**/
		@$completed_in = $encoded_raw_message['search_metadata']['completed_in'];
		@$next_results = $encoded_raw_message['search_metadata']['next_results'];
		@$max_id = $encoded_raw_message['search_metadata']['max_id'];
	}


}


$make_crawler = new Crawler();

?>