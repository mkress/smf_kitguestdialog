<?php
/*******************************************************************************
* Guest Dialog © 2012, Markus Kress - Kress.IT							       *
********************************************************************************
* Subs-KitGuestDialog.php													   *
********************************************************************************
* License http://creativecommons.org/licenses/by-sa/3.0/deed.de CC BY-SA 	   *
* Support for this software  http://kress.it and							   *
* http://custom.simplemachines.org/mods/index.php?mod=3397					   *
*******************************************************************************/

if (!defined('SMF'))
	die('Hacking attempt...');
	
function kit_guestdialog_load_theme()
{
	global $context, $modSettings;
	
	// load template
	if( 
		!empty( $modSettings['kit_guestdialog_text'] )
		&&
		(
			($context['user']['is_guest'] && empty($_SESSION['hide_kit_guestdialog']) )
			||
			( $context['current_subaction'] == 'kit_guestdialog_preview' )
		)
	)
	{
	
		// set defaults if necessary
		if ( empty($modSettings['kit_guestdialog_width']) || $modSettings['kit_guestdialog_width'] < 200)
		{
			$modSettings['kit_guestdialog_width'] = 200;
		}
		
		if ( empty($modSettings['kit_guestdialog_height']) || $modSettings['kit_guestdialog_height'] < 100)
		{
			$modSettings['kit_guestdialog_height'] = 100;
		}
		
		if ( empty($modSettings['kit_guestdialog_style']) )
		{
			$modSettings['kit_guestdialog_style'] = 'ui-lightness';
		}
		
		$message = parse_bbc($modSettings['kit_guestdialog_text']);
		
		//remove new lines
		$message = str_replace(array("\n"), '', $message);
		
		// set dialog script and style headers
		$context['html_headers'] .= '
			<script type="text/javascript">
			var kitGuestDialog = 0;
			function kit_guestDialogJqueryUi()
			{
				if (typeof jQuery.ui == \'undefined\') {
					var script = document.createElement(\'script\');
					script.type = "text/javascript";
					script.src = "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js";
					script.onload = kit_guestDialog; // Run kit_guestDialog() once jQuery has loaded
					script.onreadystatechange = function () { // Same thing but for IE
						if (this.readyState == \'complete\' || this.readyState == \'loaded\') kit_guestDialog();
					}
					document.getElementsByTagName(\'head\')[0].appendChild(script);
				}
				else
				{
					kit_guestDialog();
				}
			}
			
			function kit_guestDialog()
			{
				if (kitGuestDialog == 0)
				{
					var mydialog = jQuery(\'<div></div>\')
					.html(\''.$message.'\')
					.dialog({
					  autoOpen: true,
					  title: \''.$modSettings['kit_guestdialog_title'].'\',
					  width: '.$modSettings['kit_guestdialog_width'].',
					  height: '.$modSettings['kit_guestdialog_height'].',
					  modal: true
					 });
					 kitGuestDialog++;
				}
			}
			
			 if(typeof jQuery === "undefined") {
				var script_tag = document.createElement(\'script\');
				script_tag.setAttribute("type","text/javascript");
				script_tag.setAttribute("src",
				  "http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js")
				script_tag.onload = kit_guestDialogJqueryUi; // Run kit_guestDialogJqueryUi() once jQuery has loaded
				script_tag.onreadystatechange = function () { // Same thing but for IE
				  if (this.readyState == \'complete\' || this.readyState == \'loaded\') kit_guestDialogJqueryUi();
				}
				document.getElementsByTagName("head")[0].appendChild(script_tag);
			} else {
				kit_guestDialogJqueryUi();
			}
			
			</script>
			<link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/'.$modSettings['kit_guestdialog_style'].'/jquery-ui.css" />
			';
			
		if ( $context['user']['is_guest'] )
		{
			$_SESSION['hide_kit_guestdialog'] = true;
		}
	}
	
}

// mod settings
function kit_guestdialog_mod_settings(&$config_vars)
{
	global $context, $modSettings, $txt;

	loadLanguage('KitGuestDialog');
	
	$config_vars[] = '';
	$config_vars[] = $txt['kitguestdialog_mod'];
	
	//title
	$config_vars[] = array(
		'text', 
		'kit_guestdialog_title',
		'60',
		$txt['kitguestdialog_title']
	);
	
	//message
	$config_vars[] = array(
		'large_text', 
		'kit_guestdialog_text',
		'10',
		$txt['kitguestdialog_text']
	);
	// width
	$config_vars[] = array(
		'int', 
		'kit_guestdialog_width',
		'3',
		$txt['kitguestdialog_width']
	);
	// height
	$config_vars[] = array(
		'int', 
		'kit_guestdialog_height',
		'3',
		$txt['kitguestdialog_height']
	);
	// style
	$config_vars[] = array(
		'select', 
		'kit_guestdialog_style', 
		array(
			'black-tie' => 'black-tie',
			'blitzer' => 'blitzer',
			'cupertino' => 'cupertino', 
			'dark-hive' => 'dark-hive',
			'dot-luv' => 'dot-luv',
			'eggplant' => 'eggplant',
			'excite-bike' => 'excite-bike',
			'flick' => 'flick',
			'hot-sneaks' => 'hot-sneaks',
			'humanity' => 'humanity',
			'le-frog' => 'le-frog',
			'mint-choc' => 'mint-choc',
			'overcast' => 'overcast',
			'pepper-grinder' => 'pepper-grinder',
			'redmond' => 'redmond',
			'smoothness' => 'smoothness',
			'south-street' => 'south-street',
			'start' => 'start',
			'sunny' => 'sunny',
			'swanky-purse' => 'swanky-purse',
			'trontastic' => 'trontastic',
			'ui-darkness' => 'ui-darkness',
			'ui-lightness' => 'ui-lightness', 
			'vader' => 'vader'
		),
		$txt['kitguestdialog_style']
	);
}
?>