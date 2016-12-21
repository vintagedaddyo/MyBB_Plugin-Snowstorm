<?php
/*
 * MyBB: Snowstorm
 *
 * File: snowstorm.php
 * 
 * Authors: Sebastian Wunderlich & Vintagedaddyo
 *
 * MyBB Version: 1.8
 *
 * Plugin Version: 1.3
 *
 * Based on http://www.schillmania.com/projects/snowstorm/
 * 
 */

// Disallow direct access to this file for security reasons

if(!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

$plugins->add_hook('pre_output_page','snowstorm');

function snowstorm_info()
{
   global $lang;

    $lang->load("snowstorm");
    
    $lang->snowstorm_Desc = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="float:right;">' .
        '<input type="hidden" name="cmd" value="_s-xclick">' . 
        '<input type="hidden" name="hosted_button_id" value="AZE6ZNZPBPVUL">' .
        '<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">' .
        '<img alt="" border="0" src="https://www.paypalobjects.com/pl_PL/i/scr/pixel.gif" width="1" height="1">' .
        '</form>' . $lang->snowstorm_Desc;

    return Array(
        'name' => $lang->snowstorm_Name,
        'description' => $lang->snowstorm_Desc,
        'website' => $lang->snowstorm_Web,
        'author' => $lang->snowstorm_Auth,
        'authorsite' => $lang->snowstorm_AuthSite,
        'version' => $lang->snowstorm_Ver,
        'compatibility' => $lang->snowstorm_Compat
    );
}

function snowstorm($page)
{
	global $mybb;
	$page=str_replace('</head>','<script type="text/javascript" src="'.$mybb->settings['bburl'].'/jscripts/snowstorm.js"></script></head>',$page);
	return $page;
}

?>