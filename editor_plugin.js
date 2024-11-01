// Docu : http://wiki.moxiecode.com/index.php/TinyMCE:Create_plugin/3.x#Creating_your_own_plugins
// The purpose of this code is to register the plugin with the TinyMCE editor.
(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('tf_forecast');
	 
	tinymce.create('tinymce.plugins.tf_forecast', {
		
		init : function(ed, url) {
		// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');

			ed.addCommand('tf_forecast', function() {
				ed.windowManager.open({
					file : url + '/window.php',
					width : 410,
					height : 180,
					inline : 1
				}, {
					plugin_url : url // Plugin absolute URL
				});
			});

			// Register example button
			ed.addButton('tf_forecast', {
				title : 'Trefis Forecast Widget',
				cmd : 'tf_forecast',
				image : url + '/tf_widget_button.png'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('tf_forecast', n.nodeName == 'IMG');
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
					longname  : 'tf_forecast',
					author 	  : 'Trefis Team',
					authorurl : 'http://www.trefis.com',
					infourl   : 'http://www.trefis.com',
					version   : "0.1 beta"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('tf_forecast', tinymce.plugins.tf_forecast);
})();
