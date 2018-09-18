<?php

namespace Konimbo;

class Utils{

	/*
	** Like file_get_contents, but much better.
	** @param Boolean $proxy - reqeust via proxy? default == false
	** @param Boolean $random_ua - request via random UserAgent? default == false
	** @return String - request's response
	*/
	static public function get($url,$proxy=false,$random_ua=false){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);         // URL for CURL call

		if($proxy):
			curl_setopt($ch, CURLOPT_PROXY, self::get_random_proxy());     // PROXY details with port
			//curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxyauth);   // Use if proxy have username and password
			curl_setopt($ch, CURLOPT_USERAGENT, self::get_random_user_agent()); // Setting a user agent
		endif;

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  // If url has redirects then go to the final redirected URL.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Do not outputting it out directly on screen.
		curl_setopt($ch, CURLOPT_HEADER, 0);   // If you want Header information of response else make 0
		$curl_scraped_page = curl_exec($ch);
		curl_close($ch);

		return $curl_scraped_page;
	}

	/*
	** Returns random proxy from the list which sits in root folder
	** @return
	*/
	static public function getRandomProxy(){
		// Todo
		return '1.1.1.1';
	}

	/*
	** Returns random user agent string from the list which sits in root folder
	** @return
	*/
	static public function getRandomUA(){
		// Todo
		return '1.1.1.1';
	}

}
