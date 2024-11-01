<?php
$wpconfig = realpath("../../../wp-config.php");
if (!file_exists($wpconfig))  {
  echo "Could not found wp-config.php. Error in path :\n\n".$wpconfig ;
  die;
 }
require_once($wpconfig);
require_once(ABSPATH.'/wp-admin/admin.php');
  require_once(dirname(__FILE__) .'/config.php');
  global $wpdb;
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Insert Trefis Forecast Chart</title>
<!-- 	<meta http-equiv="Content-Type" content="<?php// bloginfo('html_type'); ?>; charset=<?php //echo get_option('blog_charset'); ?>" /> -->
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
        <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/trefis-forecast/tinymce.js"></script>
        <script language="javascript" type="text/javascript">
    function getTrefisContext() {
    return '<?php echo tf_forecast_context_uri() ?>';
  }
        </script>
	<base target="_self" />
<style>
.tf_message_box {
border:1px solid;
background-color:#FFF2DB;
padding:5px;
}
</style>
</head>
 		<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">
<div class="tf_message_box">
<img id="loading" style="float:right" src="<?php echo get_option('siteurl') ?>/wp-content/plugins/trefis-forecast/spinner.gif"/>
<span id="tf_message">Downloading Company List From Trefis...</span>
</div>
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
			<td><label for="company">Company</label></td>
			<td><select id="company" ></select></td>
          </tr>
         <tr>
			<td><label for="division">Division</label></td>
			<td><select id="division" ></select></td>
          </tr>
			<td><label for="driver">Driver</label> </td>
			<td><select id="driver" ></select></td>
          </tr>
         <tr>
			<td><label for="width">Width</label></td>
			<td><input type="text" id="width" value="350"></text></td>
          </tr>
          <tr>
          <td></td>
          <td><input type="submit" id="insert" name="insert" value="<?php _e("Insert"); ?>" /> | <a id="cancel" href="#"> Cancel </a></td>
          </tr>
        </table>
</form>
</body>
</html>