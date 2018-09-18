<?php

namespace Konimbo\Tests;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

include_once '../vendor/autoload.php';

use Konimbo\CategoryArchive;

$category = new CategoryArchive("https://www.halilit.com/23679-Studio-Headphones");

var_dump($category->products_urls);
