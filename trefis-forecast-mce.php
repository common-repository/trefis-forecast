<?php
// php require_once is relative to the file that originally included this file. 
// this means that we can't be sure how relative paths are going to be resolved.
// one way to deal with this is to prepend the directory that the current file is in
// to make it an absolute path.
require_once(dirname(__FILE__) .'/config.php');

/*
Plugin Name: Trefis Forecast MCE Button
Description: Adds a GUI for making Trefis Forecast embed snippets
Version: 0.1.8
Author: Trefis
Author URI: http://www.trefis.com

-----------------------------------------------------
Copyright 2010  Insight Guru, Inc.  (email : dev@trefis.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
-----------------------------------------------------

Based on Nick Remeslennikov's CodeColorer TinyMCE Button:
http://wordpress.org/extend/plugins/codecolorer-tinymce-button/

*/

function tr_forecast_addbuttons() {
  // Add only in Rich Editor mode                                                                                                                                                                                
  if ( get_user_option('rich_editing') == 'true') {
    // add the button for wp25 in a new way                                                                                                                                                                        
    add_filter("mce_external_plugins", "add_tf_forecast_mce_plugin", 5);
    add_filter('mce_buttons', 'register_tr_forecast_button', 5);
  }
  }

// used to insert button in wordpress 2.5x editor                                                                                                                                                                      
function register_tr_forecast_button($buttons) {
  array_push($buttons, "separator", "tf_forecast");
  return $buttons;
}

// Load the TinyMCE plugin : editor_plugin.js (wp2.5)                                                                                                                                                                  
function add_tf_forecast_mce_plugin($plugin_array) {
  $plugin_array['tf_forecast'] = get_option('siteurl').'/wp-content/plugins/trefis-forecast/editor_plugin.js';
  return $plugin_array;
}

function tf_forecast_change_tinymce_version($version) {
  return ++$version;
}
// Modify the version when tinyMCE plugins are changed.                                                                                                                                                                
add_filter('tiny_mce_version', 'tf_forecast_change_tinymce_version');
// init process for button control
add_action('init', 'tr_forecast_addbuttons');
