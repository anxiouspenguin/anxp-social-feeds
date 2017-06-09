<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Plugin Name: ANXP Social Feeds
 * Plugin URI:  #anxp-social-feeds
 * Description: Twitter, Facebook and Instagram feed widgets plugin for WordPress.
 * Version:     1.0
 * Author:      Anxious Penguin
 * Author URI:  http://www.anxiouspenguin.com/
 * Text Domain: anxpsf
 * Domain Path: /languages
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * 
 * {Plugin Name} is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 * 
 * {Plugin Name} is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with {Plugin Name}. If not, see {License URI}.
*/
define('ANXPSF_DIR', __DIR__ . '/');
define('ANXPSF_ADMIN_DIR', __DIR__ . '/admin/');

require ANXPSF_ADMIN_DIR . 'functions.php';