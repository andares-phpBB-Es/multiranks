<?php

/**
*
* @package Multi Ranks
* @copyright (c) 2015 posey
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace posey\multiranks\acp;

class multiranks_info
{
	function module()
	{
		return array(
			'filename'	=> '\posey\multiranks\acp\multiranks_module',
			'title'	=> 'ACP_MR',
			'version'	=> '1.0.0',
			'modes'	=> array(
				'manage'		=> array('title' => 'ACP_MR', 'auth' => 'ext_posey/multiranks && acl_a_board', 'cat' => array('ACP_MR')),
			),
		);
	}
}