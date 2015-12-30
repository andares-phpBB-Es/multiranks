<?php

/**
*
* @package Multi Ranks
* @copyright (c) 2015 posey
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace posey\multiranks\acp;

class multiranks_module
{
	public	$u_action;

	function main($id, $mode)
	{
		global $phpbb_container, $request, $user;
		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('posey.multiranks.admin.controller');
		// Requests
		$action = $request->variable('action', '');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

				$this->tpl_name = 'mr_body';
				$this->page_title = $user->lang('ACP_MR');
				$admin_controller->edit_user_ranks();
	}
}