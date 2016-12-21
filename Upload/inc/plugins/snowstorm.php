<?php
/*
 * MyBB: Snowstorm
 *
 * File: snowstorm.php
 * 
 * Authors: Sebastian Wunderlich & Vintagedaddyo & juventiner
 *
 * MyBB Version: 1.8
 *
 * Plugin Version: 1.4
 *
 * Based on http://www.schillmania.com/projects/snowstorm/
 * 
 */

// Disallow direct access to this file for security reasons

if(!defined("IN_MYBB"))
{
    die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
}

$plugins->add_hook("usercp_options_end", "snowstorm_usercp");
$plugins->add_hook("usercp_do_options_end", "snowstorm_usercp");
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

function snowstorm_install() {
    global $db;
    
    // Add field for user option
    $db->query("ALTER TABLE ".TABLE_PREFIX."users ADD showSnowstorm int NOT NULL default '1'");
}

function snowstorm_is_installed()
{
    global $db;
    
    if($db->field_exists("showSnowstorm", "users"))
    {
        return true;
    }
    else 
    {
        return false;
    }
}

function snowstorm_uninstall()
{
    global $db;
    
    if($db->field_exists("showSnowstorm", "users"))
        $db->query("ALTER TABLE ".TABLE_PREFIX."users DROP COLUMN showSnowstorm");
}

function snowstorm_usercp() {
    global $db, $mybb, $templates, $user, $lang;
    $lang->load('snowstorm');
    
    if($mybb->request_method == "post")
    {
        $update_array = array(
            "showSnowstorm" => intval($mybb->input['showSnowstorm'])
        );      
        $db->update_query("users", $update_array, "uid = '".$user['uid']."'");
    }
    
    $add_option = '</tr><tr>
<td valign="top" width="1"><input type="checkbox" class="checkbox" name="showSnowstorm" id="showSnowstorm" value="1" {$GLOBALS[\'$showSnowstormChecked\']} /></td>
<td><span class="smalltext"><label for="showSnowstorm">{$lang->snowstorm_show_question}</label></span></td>';

    $find = '{$lang->show_codebuttons}</label></span></td>';
    $templates->cache['usercp_options'] = str_replace($find, $find.$add_option, $templates->cache['usercp_options']);
    
    $GLOBALS['$showSnowstormChecked'] = '';
    if($user['showSnowstorm'])
        $GLOBALS['$showSnowstormChecked'] = "checked=\"checked\"";
}


function snowstorm($page)
{
    global $mybb;
    
    if($mybb->user['showSnowstorm']) {
        $page=str_replace('</head>','<script type="text/javascript" src="'.$mybb->settings['bburl'].'/jscripts/snowstorm.js"></script></head>',$page);
    }
    
    return $page;
}

?>