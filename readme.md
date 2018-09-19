# Konimbo Scraper Script 

## Installation

The preferred way to install the module is by using [composer](http://getcomposer.org).
add the following code to your __"composer.json"__ file:
```
{

	"repositories": [
		{
			"type": "gitlab",
			"url": "https://gitlab.com/obachar46/konimboScraper"
		}
	],
	"require": {           
			"obachar46/imhungry": "dev-master"
	}
}
```

## How to use

### Scrape single product
```
$product = new Konimbo\Product("{KONIMBO_WEBSITE_PRODUCT_URL}");

print $product->price; // Product price
print $product->name; // Product name
print $product->long_desc; // Product long description
print $product->short_desc; // Product short description
print $product->features; // Product features list
print $product->gallery_images; // Product gallery images list
print $product->main_image_url; // Product main image url
print $product->tech_details; // Product tech details list
```

### Scrape full website
```
$website = new Konimbo\Website("{KONIMBO_WEBSITE_URL_MAIN_PAGE}");

foreach($website->categories as $category){
	
	print($category->title); // Category title
	print($category->url); // Category URL
	
	foreach($category->products as $product){
	
		... execute some code on each product ...
	}
}
```


### Scrape category archive
```
$category_archive = new Konimbo\CategoryArchive("{KONIMBO_WEBSITE_CATEGORY_URL}");

foreach($category_archive->products as $product){

	... some code to execute on each product ...
}
```


## TODOs
* Add full website scraping function
* Add option for using proxies & fake UA
* Add catches for exception in top functions