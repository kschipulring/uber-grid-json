<?php
/**
 * @package Kschipulring
 */
/*
Plugin Name: Portfolio Gallery REST API extension
Plugin URI: https://3ringprototype.com
Description: Extends the Wordpress Portfolio Builder - Portfolio Gallery plugin by making it REST API friendly.
Version: 0.8
Author: kschipulring
Author URI: https://github.com/kschipulring
License: GPLv2 or later
Text Domain: kschipulring
*/

include( "PfhubPortfolioREST.php" );

PfhubPortfolioREST::init();
