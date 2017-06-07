<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * @link              http://www.anxiouspenguin.com/
 * @since             1.0.0
 * @package           ANXP Social Feeds
 *
 * @wordpress-plugin
 * Plugin Name:       ANXP Social Feeds
 * Plugin URI:        http://www.anxiouspenguin.com/
 * Description:       Twitter, Facebook and Instagram feed widgets.
 * Version:           1.0.0
 * Author:            Anxious Penguin
 * Author URI:        http://www.anxiouspenguin.com/
 * License:           MIT License
 * License URI:       https://github.com/anxiouspenguin/ANXP-Social-Feeds/blob/master/LICENSE
 * Text Domain:       anxpsf
 */
define('ANXPSF_DIR', __DIR__ . '/');
define('ANXPSF_ADMIN_DIR', __DIR__ . '/admin/');

require ANXPSF_ADMIN_DIR . 'functions.php';