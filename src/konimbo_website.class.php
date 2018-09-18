<?php
	namespace Konimbo;

	class KonimboWebsite
	{

		// @var String - website url
		public $website_url;

		// @var Array of Strings - list of category's archives urls
		private $_category_archives;

		// @var Array - list of products
		private $_products;

		public function __construct($website_url)
		{
			// Validate URL
			if(filter_var($website_url, FILTER_VALIDATE_URL)){
				$this->website_url = $website_url;
			}
			else{
				// Throw an exception
				throw new \Exception("Website's url is invalid.");
			}

			// Scrape category archives urls
			$this->_category_archives = $this->_scrapeCategoryArchives();



		}

		/*
		** Scraping category archives urls
		** @void
		*/
		private function _scrapeCategoryArchives()
		{
			// Create empty array
			$array = [];

			// Get HTML response of main page on website
			$website_html = Utils::get($this->website_url);

			// Create DOM
			$dom = str_get_html($website_html);

			// Find categories list's ul element from footer
			$ul = $dom->find("#footer_middle_groups .store_categories li ul li a");
			if($ul == null){
				throw new \Exception("Cant find categories list ul element on footer.");
			}
			else{
				// Push archive url to array
				$array = array_map(function($v) use ($array){
					return $v->href;
				},$ul);

				if(sizeof($array) == 0){
					throw new Exception("Cannot find any products categories archives");
				}

				return $array;
			}

		}

		/*
		** Scraping products using categories archives
		** @return
		*/
		private function _scrapeProducts()
		{
			// Loop each category archive and scrape it's products
			foreach($this->_category_archives as $archive_url){

				// Create category object
				$category = new CategoryArchive($archive_url);
			}
		}


	}

?>
