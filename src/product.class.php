<?php

namespace Konimbo;

class Product{

	// @var String url
	public $url;

	// @var Int price
	public $price;

	// @var String name
	public $name;

	// @var String short description
	public $short_desc;

	// @var String long description
	public $long_desc;

	// @var String tech details
	public $tech_details;

	// @var String main image url
	public $main_image_url;

	// @var Array of Strings images gallery
	public $gallery_images;

	// @var String features field HTML value
	public $features;


	public function __construct($url)
	{
		if(filter_var($url, FILTER_VALIDATE_URL)){
			$this->url = $url;
		}
		else{
			return false;
		}

		// Create DOM
		$this->dom = str_get_html(Utils::get($url));
		if(!$this->dom){
			// If cannot create dom, return false
			return false;
		}

		$this->_scrape();
	}

	/*
	** Scrapes product page
	** @void
	*/
	private function _scrape()
	{

		// Product name
		if($this->dom->find("span[itemprop=name]",0)){
			$this->name = trim($this->dom->find("span[itemprop=name]",0)->plaintext);
		}
		else{
			$this->name = false;
		}

		// Product price
		if($this->dom->find(".price_value",0)){
			$this->price = trim(str_replace("₪","",$this->dom->find(".price_value",0)->plaintext));

		}
		else{
			$this->price = false;
		}

		// Short description
		if($this->dom->find("span[itemprop=description]",0)){
			$short_desc = $this->dom->find("span[itemprop=description]",0)->plaintext;
			$this->short_desc = strlen($short_desc) > 3 ? $short_desc : false;
		}
		else{
			$this->short_desc = false;
		}

		// Main image
		if($this->dom->find("#lightSlider .active img",0)){
			$this->main_image_url = $this->dom->find("#lightSlider .active img",0)->src;
		}
		else{
			// Try another pattern
			if($this->dom->find(".mainImage img",0)){
				$this->main_image_url = $this->dom->find(".mainImage img",0)->attr['src'];
			}
			else{
				$this->main_image_url = false;
			}
		}

		// Images gallery
		$gallery_li_list = $this->dom->find("#lightSlider img");
		if(!$gallery_li_list){
			// Gallery has not been found
			$images_list = false;
		}
		else{
			// Gallery has been found
			$images_list = array_map(function ($v){
				return $v->src;
			},$gallery_li_list);

			if(sizeof($images_list) > 0){
				// Normally, the first image in gallery is the main image
				if(!$this->main_image_url){
					$this->main_image_url = $images_list[0];
				}
			}
		}
		$this->gallery_images = $images_list;

		// If gallery was not found but main image was, lets declare on single image gallery
		if($this->main_image_url !== false && (sizeof($this->gallery_images) == 0 || $this->gallery_images == false)){
			$this->gallery_images = array($this->main_image_url);
		}

		// Long description
		if($this->dom->find(".desc",0)){
			$this->long_desc = trim($this->dom->find(".desc",0)->innertext);
		}
		else{
			// Long description has not been found
			$this->long_desc = false;
		}

		// Tech details
		$tech_details_dom = $this->dom->find("#item_specifications ul li");
		if(!$tech_details_dom){
			// Tech details has not been found
			$this->tech_details = false;
		}
		else{
			$array = array_map(function($v){
				return array(
					'name' => trim($v->find("b",0)->plaintext),
					'value' => trim($v->find("span",0)->plaintext)
				);
			},$tech_details_dom);

			if(sizeof($array) == 0){
				// Tech details has not been found
				$this->tech_details = false;
			}
			else{
				$this->tech_details = $array;
			}

		}

		// Product features
		if($this->dom->find(".features",0)){
			$this->features = trim($this->dom->find(".features",0)->innertext);
		}
		else{
			$this->features = false;
		}

	}




}
