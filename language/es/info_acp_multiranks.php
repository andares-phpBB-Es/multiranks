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
		'ACP_MR'				=> 'Rangos múltiples',
		'ACP_MR_SAVED'			=> 'Rangos múltiples del usuario se han guardado',
		'ACP_EDIT_RANKS'		=> 'Administrar rangos de usuario',
		'ACP_EDIT_USER_RANK'	=> 'Administrar rangos de %s', // %s will be username
		'ACP_SELECT_USER'		=> 'Seleccione un usuario',
		'ACP_CHANGE_RANKS'		=> 'Cambiar Rangos',

		'ACP_NO_SPEC_RANK'	=> 'No se ha seleccionado un Rango',
		'ACP_RANK_ONE'		=> '1er Rango Especial',
		'ACP_RANK_TWO'		=> '2do Rango Especial',
		'ACP_RANK_THREE'	=> '3er Rango Especial',
		'ACP_RANK_FOUR'		=> '4to Rango Especial',
		'ACP_RANK_FIVE'		=> '5to Rango Especial',
		'ACP_RANK_SIX'		=> '6to Rango Especial',
		'ACP_RANK_SEVEN'	=> '7mo Rango Especial',
		'ACP_RANK_EIGHT'	=> '8vo Rango Especial',
		'ACP_RANK_NINE'		=> '9no Rango Especial',
		'ACP_RANK_TEN'		=> '10mo Rango Especial',
));
