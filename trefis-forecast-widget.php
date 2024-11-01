<?php
// php require_once is relative to the file that originally included this file. 
// this means that we can't be sure how relative paths are going to be resolved.
// one way to deal with this is to prepend the directory that the current file is in
// to make it an absolute path.
require_once(dirname(__FILE__) .'/config.php');

/*
Plugin Name: Trefis Forecast Widget
Description: Lets you embed the Trefis forecast widget in the sidebar, or in any post
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

Based on Debashish Chakrabarty's IFrame Widget:
http://nullpointer.debashish.com/iframe-widget-for-wordpress

*/

// This gets called at the plugins_loaded action
function trefis_forecast_widget_init() {
	
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') ){
		return;	
	}

	// This saves options and prints the widget's config form.
	function trefis_forecast_widget_control() {
		$options = $newoptions = get_option('trefis_fw');
		if ( $_POST['trefis-fw-submit'] ) {
			$newoptions['ticker'] = $_POST['trefis-fw-ticker'];
			$newoptions['userId'] = (int) $_POST['trefis-fw-userid'];
			$newoptions['driver'] = (int)$_POST['trefis-fw-driver'];
			$newoptions['width'] = $_POST['trefis-fw-width'];
		}

		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('trefis_fw', $options);
		}
		?>
		<div style="text-align:right">
		    <p style="text-align:left;"><label for="trefis-fw-intro">Displays a Trefis forecast widget.</label></p>
			<label for="trefis-fw-ticker" style="line-height:35px;display:block;">Default ticker symbol (optional; if not set it will rotate daily): <input type="text" id="trefis-fw-ticker" name="trefis-fw-ticker" value="<?php echo ($options['ticker']); ?>" /></label>
			<label for="trefis-fw-userid" style="line-height:35px;display:block;">UserId of the forecasts to show (optional; if not set the Trefis forecasts will be shown): <input type="text" id="trefis-fw-userid" name="trefis-fw-userid" value="<?php echo ($options['userId']); ?>" /></label>
			<label for="trefis-fw-driver" style="line-height:35px;display:block;">Code for a specific forecast (optional; if not set a selection of top forecasts will be shown): <input type="text" id="trefis-fw-driver" name="trefis-fw-driver" value="<?php echo ($options['driver']); ?>" /></label>
			<label for="trefis-fw-width" style="line-height:35px;display:block;">Widget width: <input type="text" id="trefis-fw-width" name="trefis-fw-width" value="<?php echo $options['width']; ?>" /></label>
			<input type="hidden" name="trefis-fw-submit" id="trefis-fw-submit" value="1" />
		</div>
		<?php
	}

	// This prints the widget
	function trefis_forecast_widget($args) {
		extract($args);
		$options = (array) get_option('trefis_fw');
		?>
		<?php echo $before_widget . $before_title . $title . $after_title; ?>
		<?php echo renderWidget($options); ?>
		<?php echo $after_widget; ?>
		<?php
	}

	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget('Trefis Forecast Widget', 'trefis_forecast_widget');
	register_widget_control('Trefis Forecast Widget', 'trefis_forecast_widget_control');
}

function trefis_forecast_shortcode($atts) {
	$attributes = shortcode_atts(array(
		'width' => '350', // width of the widget
		'ticker' => '',   // ticker of the company to include
		'userid' =>'',    // user id of model to show
		'driver' =>'',    // driver to show
		'comp' =>'',      // competition link to include
		'caweekly'=>'',   // include weekly community average?
		'cadate' =>'',    // include community average as of data
		'noanim' =>''     // skip animation
	), $atts);
	
	$urlOpts = "";
	if (strlen($attributes['ticker']) == 0) {
	  $urlOpts = "type=daily";
	}
	foreach ($attributes as $key => $value) {
	  if (strlen($value) > 0) {
	    if (strlen($urlOpts) > 0)
	      $urlOpts .= '&';
	    $urlOpts .= $key .'='.$value;
	  }
	}
	if(strlen($urlOpts) >	0)
		$urlOpts = "?" . $urlOpts;

	return '<iframe width="'.$attributes['width'].'" height="330" src="'.tf_forecast_context_uri().'/forecastWidget'.$urlOpts.'" frameborder="0" scrolling="no" marginwidth="0" marginheight="0"></iframe>';
}

function trefis_slideshow_shortcode($atts) {
	$includeRelated = tf_slideshow_related();
  $shortcodeDefaults = array(
		'ticker' => 'AAPL',   // ticker of the company to include
		'rhs' => $includeRelated?"1":"3",
		'width' => '600'
	);
  
  
	$attributes = shortcode_atts($shortcodeDefaults, $atts);

	if($includeRelated) {
		$postId = get_the_ID();
		if(isset($postId))
		  $attributes["article"] = $postId;
	}
	
	// only the narrow version of the widget can have a custom width
	if($attributes['rhs'] != '3')
		$attributes['width'] = '960';
	
	$urlOpts = "";
	foreach ($attributes as $key => $value) {
	  if (strlen($value) > 0) {
	    if (strlen($urlOpts) > 0)
	      $urlOpts .= '&';
	    $urlOpts .= $key .'='.$value;
	  }
	}
	if(strlen($urlOpts) >	0)
		$urlOpts = "?" . $urlOpts;

	return '<iframe width="' . $attributes['width'] . '" height="485" class="trefis_slideshow" src="'.tf_forecast_context_uri().'/slideshowWidget'.$urlOpts.'" frameborder="0" scrolling="no" marginwidth="0" marginheight="0" allowtransparency="true"></iframe>';
}
function trefis_sankey_shortcode($atts) {
	$includeRelated = tf_slideshow_related();
  $shortcodeDefaults = array(
		'ticker' => 'AAPL',   // ticker of the company to include
		'width' => '500', // width of widget
		'toprightspace' => '', // allow extra space in the top right for external controls
		'related' => '' // comma separated list of related tickers
	);
  
	$attributes = shortcode_atts($shortcodeDefaults, $atts);

	$urlOpts = "";
	foreach ($attributes as $key => $value) {
	  if (strlen($value) > 0) {
	    if (strlen($urlOpts) > 0)
	      $urlOpts .= '&';
	    $urlOpts .= $key .'='.$value;
	  }
	}
	if(strlen($urlOpts) >	0)
		$urlOpts = "?" . $urlOpts;

	return '<iframe width="' . $attributes['width'] .'" scrolling="no" height="410" frameborder="0" marginheight="0" marginwidth="0" src="'.tf_forecast_context_uri().'/sankeyWidget'.$urlOpts.'"></iframe>';
}


// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_shortcode('trefis_forecast', 'trefis_forecast_shortcode');
add_shortcode('trefis_slideshow', 'trefis_slideshow_shortcode');
add_shortcode('trefis_sankey', 'trefis_sankey_shortcode');
add_action('plugins_loaded', 'trefis_forecast_widget_init');

