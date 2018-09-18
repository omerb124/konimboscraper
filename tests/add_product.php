<?php

namespace Konimbo\Tests;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../vendor/autoload.php';

use Konimbo\Product;

$product = new Product("http://www.rgallery.co.il/items/904868-%D7%9E%D7%90%D7%A8%D7%96-12-%D7%99%D7%97-%D7%9E%D7%A1%D7%A4%D7%A8%D7%99-%D7%96%D7%99%D7%92%D7%96%D7%92-15-5-%D7%A1-%D7%9E");

var_dump($product);
