=== Trefis Forecast Charts ===
Contributors: trefis, alokito
Tags: trefis, stock, finance, investing, flash, widget, embed, buttom, editor, tinymce, business
Requires at least: 2.9
Tested up to: 3.0.1
Stable tag: 0.1.8

This is a bundle of two plugins which enable you to use the rich text editor to easily add Trefis forecast charts to your blog.

== Description ==

Easily embed Trefis Forecast charts in your blog with this download. Trefis forecast charts connect 
products and services with stock price, and are a great addition to posts about the impact of news 
events on a company's business and stock price.

For example, if you are writing about Apple's iPhones and wondering what could the impact be on 
Apple's stock if 20% of cell phones sold turn out to be iPhones, this plugin could be useful. 
You could simply a) select company "Apple" b) select division "iPhones", c) select driver 
"iPhone's market share" and hit "insert" to embed a modifiable chart for iPhone's market share 
within your write-up. Your readers will then simply be able to drag the iPhone's market share 
trend-line on this chart, to try different "what-if" scenarios and see their impact on Apple's 
stock. You will most likely see a strong jump in user engagement on your articles. For an example 
of such a chart in action: see the first widget on www.trefis.com/widgets 

There are two plugins in this download. The first, "Trefis Forecast MCE Button", adds a button to the rich text editor 
that allows you to easily generate shortcodes for forecast charts. The shortcodes will appear similar to the following 
in the editor: [forecasts ticker="AAPL" driver="10289"]. The second plugin, "Trefis Forecast Widget", add a filter that 
translates the shortcodes into HTML markup that corresponds to the embedded chart.

Related Links:

* <a href="http://www.trefis.com" title="Trefis Homepage">Trefis Homepage</a>
* <a href="http://www.trefis.com/widgets" title="Trefis Widgets">Trefis Widgets</a>

*This release has only been tested with Wordpress 2.9 and 3.0.1. Please email dev@trefis.com know if you find it works with other versions*

== Installation ==

1. Upload the full directory into your wp-content/plugins directory
2. Activate the "Trefis Forecast MCE Button" plugin at the plugin administration page
3. Activate the "Trefis Forecast Widget" plugin at the plugin administration page
4. Make a new post and confirm that the trefis buttons shows up on the "Visual" tab

== Frequently Asked Questions == 

= How can I get a new feature added? =

Please email dev@trefis.com with any feature requests.

= How can I report a bug? =

Please email dev@trefis.com with any bug reports.

= My question isn't answered here =

Please email dev@trefis.com with any questions.

== Changelog ==

= 0.1.8 =

Added support for "width" parameter to trefis_slideshow shortcode

= 0.1.7 =

Added new trefis_sankey shortcode

= 0.1.6 =

Added new trefis_slideshow shortcode

= 0.1.5 =

Switched to lowercase parameters to conform to shortcode API. Existing posts do not need to be updated as this change is backwards compatible with snippets made by previous versions of the plugins.

= 0.1.4 =

Cleaned up Ajax calls

= 0.1.3 =

Changed layout of tinyMCE popup window

= 0.1.2 =

Fixed bug in setting width of widget

= 0.1.1 =

CAUTION!!! Changed shortcode from [forecasts] to [trefis_forecast]. You will need to update any existing posts if you were using version 0.1 of this plugin.

= 0.1 =

Initial release

== Screenshots ==

1. Image of what the button looks like in the Rich Text Editor
2. After selecting a driver from the dropdown menus
3. After the forecast shortcode is inserted
4. A preview of the same post

== License ==

This plugin is released under the GPL, you can use it free of charge on your personal or commercial blog and customize as necessary.
