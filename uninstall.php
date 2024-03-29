<?php
/*******************************************************************************
* Guest Dialog � 2012, Markus Kress - Kress.IT							       *
********************************************************************************
* hooks.php																	   *
********************************************************************************
* License http://creativecommons.org/licenses/by-sa/3.0/deed.de CC BY-SA 	   *
* Support for this software  http://kress.it and							   *
* http://custom.simplemachines.org/mods/index.php?mod=3397					   *
*******************************************************************************/

if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF'))
	require_once(dirname(__FILE__) . '/SSI.php');
elseif(!defined('SMF'))
	die('<b>Error:</b> Cannot install - please verify that you put this file in the same place as SMF\'s index.php and SSI.php files.');

if ((SMF == 'SSI') && !$user_info['is_admin'])
	die('Admin privileges required.');
	
$hooks = array(
	'integrate_pre_include' => '$sourcedir/Subs-KitGuestDialog.php',
	'integrate_load_theme' => 'kit_guestdialog_load_theme',
	'integrate_general_mod_settings' => 'kit_guestdialog_mod_settings'
);

foreach ($hooks as $hook => $function)
	remove_integration_function($hook, $function);
	
if (SMF == 'SSI')
	echo 'Database changes are complete! Please wait...';
?>