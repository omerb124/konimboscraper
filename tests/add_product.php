<?php

namespace Konimbo\Tests;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../vendor/autoload.php';

use Konimbo\Product;

$product = new Product("https://www.halilit.com/items/939291-Beyerdynamic-DT-1770-PRO-headphones");

var_dump($product);
