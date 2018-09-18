<?php

namespace Konimbo;

class CategoryArchive{

	// @var String category url
	public $url;

	// @var String website main domain
	public $main_domain;

	// @var String category title
	public $title;

	// @var Array of String products url list
	public $products_urls;

	// @var Array of Konimbo\Product category products
	public $products;

	public function __construct($url)
	{
		// Category archive url
		if(filter_var($url, FILTER_VALIDATE_URL)){
			$this->url = $url;
		}
		else{
			throw new Exception(sprintf("Invalid url '%s' for category archive.",$url));
		}

		// Extract main domain url
		$this->_extractMainDomain();

		// Create DOM
		$this->dom = str_get_html(Utils::get($url));
		if(!$this->dom){
			throw new Exception("Cannot create DOM for category archive.");
		}

		// Scrape products urls list
		$this->_scrapeProductsUrlList();

		// Scrape products data
		if(!empty($this->products_urls)){
			$this->_scrapeProducts();
		}
		else{
			// No products were found
			$this->products = false;
		}

		$this->dom->clear();
	}

	/*
	** Scraping products urls list from archive webpage
	** Scraping category title
	** @void
	*/
	private function _scrapeProductsUrlList()
	{
		// Scrape category title
		if($this->dom->find(".element_category_filter h1",0)){
			$this->title = $this->dom->find(".element_category_filter h1",0)->plaintext;
		}
		else{
			var_dump($this->dom->find(".element_category_filter"));
			$this->title = false;
		}

		// Create list of products URL on archive
		$product_elements = $this->dom->find("div.item");
		if(!$product_elements){
			// Cannot find any products
			$this->products_urls = false;
		}
		else{
			// There are products to scrape
			$this->products_urls = array_map(function($v){

				// Handle product url - add 'http'\'https' and main domain if needed
				$prod_url = $v->find(".grid a",0)->href;
				if(!strpos($prod_url,$this->main_domain)){
					return $this->main_domain . trim($prod_url);
				}
				else{
					return trim($prod_url);
				}
			},$product_elements);

			// Loop next pages
			$last_page = false;
			$page_index = 2;
			while(!$last_page){
				// Create DOM
				$page_dom = str_get_html(Utils::get($this->url . '?page=' . $page_index));
				if(!$page_dom){
					// Cant create dom, exit from loop
					$last_page  = true;
					break;
				}

				// Create list of product elements
				$product_elements = $page_dom->find("div.item");
				if(!$product_elements){
					$last_page = true;
				}
				else{
					// There are products to scrape
					$products_urls = array_map(function($v){

						// Handle product url - add 'http'\'https' and main domain if needed
						$prod_url = $v->find(".grid a",0)->href;
						if(!strpos($prod_url,$this->main_domain)){
							return $this->main_domain . trim($prod_url);
						}
						else{
							return trim($prod_url);
						}
					},$product_elements);

					if(!empty($products_urls)){
						// Merge new urls list with exist urls list
						$this->products_urls = array_merge($this->products_urls,$products_urls);

						// Increase page index
						$page_index++;
					}
					else{
						// There are no more products, so this is the last page
						$last_page = true;
					}
				}
			}

		}
	}

	/*
	** Scraping products data
	** @void
	*/
	private function _scrapeProducts()
	{
		// Create empty array
		$this->products = [];

		foreach($this->products_urls as $prod_url){
			// Create new product
			$product = new Product($prod_url);
			if($product !== false){
				// Push product into product list
				array_push($this->products,$product);
			}
		}
	}

	/*
	** Extracts main domain from category url
	** @void
	*/
	private function _extractMainDomain()
	{
		$url = $this->url;

		$main_domain = parse_url($url)['scheme'] . '://' . parse_url($url)['host'];

		$this->main_domain = $main_domain;
	}

}
