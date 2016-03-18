<?php

/**
*
* @package phpBB Extension - Advanced Profile System
* @copyright (c) 2015 posey - http://www.godfathertalks.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
// Some characters you may want to copy&paste:
// ’ » “ ” …
$lang = array_merge($lang, array(
		'ACP_MR'				=> 'Multi Ranks',
		'ACP_MR_SAVED'			=> 'User\'s Multi Ranks have been saved',
		'ACP_EDIT_RANKS'		=> 'Manage user\'s ranks',
		'ACP_EDIT_USER_RANK'	=> 'Manage %s\'s ranks', // %s will be username
		'ACP_SELECT_USER'		=> 'Select a user',
		'ACP_CHANGE_RANKS'		=> 'Change Ranks',

		'ACP_NO_SPEC_RANK'	=> 'No special rank assigned',
		'ACP_RANK_ONE'		=> 'Special Rank one',
		'ACP_RANK_TWO'		=> 'Special Rank two',
		'ACP_RANK_THREE'	=> 'Special Rank three',
		'ACP_RANK_FOUR'		=> 'Special Rank four',
		'ACP_RANK_FIVE'		=> 'Special Rank five',
		'ACP_RANK_SIX'		=> 'Special Rank six',
		'ACP_RANK_SEVEN'	=> 'Special Rank seven',
		'ACP_RANK_EIGHT'	=> 'Special Rank eight',
		'ACP_RANK_NINE'		=> 'Special Rank nine',
		'ACP_RANK_TEN'		=> 'Special Rank ten',
));
