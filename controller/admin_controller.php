<?php

/**
*
* @package phpBB Extension - Multi Ranks
* @copyright (c) 2015 posey - http://www.godfathertalks.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace posey\multiranks\controller;

/**
* Admin controller
*/

class admin_controller
{
	/** @var \phpbb\db\driver\driver_interface */
	protected $db;
	/** @var \phpbb\request\request */
	protected $request;
	/** @var \phpbb\template\template */
	protected $template;
	/** @var \phpbb\user */
	protected $user;
	/** @var string phpBB root path */
	protected $root_path;
	/** @var string phpEx */
	protected $php_ext;
	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interface		$db					Database object
	* @param \phpbb\request\request					$request			Request object
	* @param \phpbb\template\template				$template			Template object
	* @param \phpbb\user							$user				User object
	* @param string							 	$root_path			phpBB root path
	* @param string							 	$php_ext			phpEx
	* @return \posey\multiranks\controller\admin_controller
	* @access public
	*/
	public function __construct(
			\phpbb\db\driver\driver_interface $db,
			\phpbb\request\request $request,
			\phpbb\template\template $template,
			\phpbb\user $user,
			$root_path,
			$php_ext)
	{
		$this->db = $db;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	public function edit_user_ranks()
	{
		$this->template->assign_vars(array(
			'U_ACTION'			=> $this->u_action,
			'S_FIND_USER'		=> true,
			'U_FIND_USERNAME'	=> append_sid("{$this->root_path}memberlist.{$this->php_ext}", 'mode=searchuser&amp;form=select_user&amp;field=username&amp;select_single=true'),
		));

		if($this->request->is_set_post('submit-user'))
		{
			$username = $this->request->variable('username', '', true);

			$sql = 'SELECT *
				FROM ' . USERS_TABLE . "
				WHERE username_clean = '" . $this->db->sql_escape(utf8_clean_string($username)) . "'";
			$result = $this->db->sql_query($sql);
			$user = $this->db->sql_fetchrow($result);

			$this->db->sql_freeresult($result);

			if (!$user['user_id'])
			{
				trigger_error($this->user->lang['NO_USER'] . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$sql = 'SELECT *
					FROM ' . RANKS_TABLE . '
					WHERE rank_special = 1
					ORDER BY rank_title';
			$result = $this->db->sql_query($sql);

			$s_rank_one_options = '<option value="0"' . ((!$user['user_rank']) ? ' selected="selected"' : '') . '>' . $this->user->lang['ACP_NO_SPEC_RANK'] . '</option>';
			$s_rank_two_options = '<option value="0"' . ((!$user['user_rank_two']) ? ' selected="selected"' : '') . '>' . $this->user->lang['ACP_NO_SPEC_RANK'] . '</option>';
			$s_rank_three_options = '<option value="0"' . ((!$user['user_rank_three']) ? ' selected="selected"' : '') . '>' . $this->user->lang['ACP_NO_SPEC_RANK'] . '</option>';
			$s_rank_four_options = '<option value="0"' . ((!$user['user_rank_four']) ? ' selected="selected"' : '') . '>' . $this->user->lang['ACP_NO_SPEC_RANK'] . '</option>';
			$s_rank_five_options = '<option value="0"' . ((!$user['user_rank_five']) ? ' selected="selected"' : '') . '>' . $this->user->lang['ACP_NO_SPEC_RANK'] . '</option>';
			$s_rank_six_options = '<option value="0"' . ((!$user['user_rank_six']) ? ' selected="selected"' : '') . '>' . $this->user->lang['ACP_NO_SPEC_RANK'] . '</option>';
			$s_rank_seven_options = '<option value="0"' . ((!$user['user_rank_seven']) ? ' selected="selected"' : '') . '>' . $this->user->lang['ACP_NO_SPEC_RANK'] . '</option>';
			$s_rank_eight_options = '<option value="0"' . ((!$user['user_rank_eight']) ? ' selected="selected"' : '') . '>' . $this->user->lang['ACP_NO_SPEC_RANK'] . '</option>';
			$s_rank_nine_options = '<option value="0"' . ((!$user['user_rank_nine']) ? ' selected="selected"' : '') . '>' . $this->user->lang['ACP_NO_SPEC_RANK'] . '</option>';
			$s_rank_ten_options = '<option value="0"' . ((!$user['user_rank_ten']) ? ' selected="selected"' : '') . '>' . $this->user->lang['ACP_NO_SPEC_RANK'] . '</option>';

			while ($row = $this->db->sql_fetchrow($result))
			{
				$selected1 = ($user['user_rank'] && $row['rank_id'] == $user['user_rank']) ? ' selected="selected"' : '';
				$s_rank_one_options .= '<option value="' . $row['rank_id'] . '"' . $selected1 . '>' . $row['rank_title'] . '</option>';

				$selected2 = ($user['user_rank_two'] && $row['rank_id'] == $user['user_rank_two']) ? ' selected="selected"' : '';
				$s_rank_two_options .= '<option value="' . $row['rank_id'] . '"' . $selected2 . '>' . $row['rank_title'] . '</option>';

				$selected3 = ($user['user_rank_three'] && $row['rank_id'] == $user['user_rank_three']) ? ' selected="selected"' : '';
				$s_rank_three_options .= '<option value="' . $row['rank_id'] . '"' . $selected3 . '>' . $row['rank_title'] . '</option>';

				$selected4 = ($user['user_rank_four'] && $row['rank_id'] == $user['user_rank_four']) ? ' selected="selected"' : '';
				$s_rank_four_options .= '<option value="' . $row['rank_id'] . '"' . $selected4 . '>' . $row['rank_title'] . '</option>';

				$selected5 = ($user['user_rank_five'] && $row['rank_id'] == $user['user_rank_five']) ? ' selected="selected"' : '';
				$s_rank_five_options .= '<option value="' . $row['rank_id'] . '"' . $selected5 . '>' . $row['rank_title'] . '</option>';

				$selected6 = ($user['user_rank_six'] && $row['rank_id'] == $user['user_rank_six']) ? ' selected="selected"' : '';
				$s_rank_six_options .= '<option value="' . $row['rank_id'] . '"' . $selected6 . '>' . $row['rank_title'] . '</option>';

				$selected7 = ($user['user_rank_seven'] && $row['rank_id'] == $user['user_rank_seven']) ? ' selected="selected"' : '';
				$s_rank_seven_options .= '<option value="' . $row['rank_id'] . '"' . $selected7 . '>' . $row['rank_title'] . '</option>';

				$selected8 = ($user['user_rank_eight'] && $row['rank_id'] == $user['user_rank_eight']) ? ' selected="selected"' : '';
				$s_rank_eight_options .= '<option value="' . $row['rank_id'] . '"' . $selected8 . '>' . $row['rank_title'] . '</option>';

				$selected9 = ($user['user_rank_nine'] && $row['rank_id'] == $user['user_rank_nine']) ? ' selected="selected"' : '';
				$s_rank_nine_options .= '<option value="' . $row['rank_id'] . '"' . $selected9 . '>' . $row['rank_title'] . '</option>';

				$selected10 = ($user['user_rank_ten'] && $row['rank_id'] == $user['user_rank_ten']) ? ' selected="selected"' : '';
				$s_rank_ten_options .= '<option value="' . $row['rank_id'] . '"' . $selected10 . '>' . $row['rank_title'] . '</option>';
			}
			$this->db->sql_freeresult($result);

			$this->template->assign_vars(array(
				'ACP_MR_USER'			=> sprintf($this->user->lang['ACP_EDIT_USER_RANK'], $user['username']),

				'S_EDIT_RANKS'			=> true,
				'S_FIND_USER'			=> false,
				'S_RANK_ONE_OPTIONS'	=> $s_rank_one_options,
				'S_RANK_TWO_OPTIONS'	=> $s_rank_two_options,
				'S_RANK_THREE_OPTIONS'	=> $s_rank_three_options,
				'S_RANK_FOUR_OPTIONS'	=> $s_rank_four_options,
				'S_RANK_FIVE_OPTIONS'	=> $s_rank_five_options,
				'S_RANK_SIX_OPTIONS'	=> $s_rank_six_options,
				'S_RANK_SEVEN_OPTIONS'	=> $s_rank_seven_options,
				'S_RANK_EIGHT_OPTIONS'	=> $s_rank_eight_options,
				'S_RANK_NINE_OPTIONS'	=> $s_rank_nine_options,
				'S_RANK_TEN_OPTIONS'	=> $s_rank_ten_options,

				'HIDDEN_RANK_USER_ID'	=> (int) $user['user_id'],
			));
		}

		add_form_key('submit-rank-key');
		if($this->request->is_set_post('submit-rank'))
		{
			if (check_form_key('submit-rank-key'))
			{
				$rank_one = (int) $this->request->variable('user_rank_one', 0);
				$rank_two = (int) $this->request->variable('user_rank_two', 0);
				$rank_thr = (int) $this->request->variable('user_rank_three', 0);
				$rank_fou = (int) $this->request->variable('user_rank_four', 0);
				$rank_fiv = (int) $this->request->variable('user_rank_five', 0);
				$rank_six = (int) $this->request->variable('user_rank_six', 0);
				$rank_svn = (int) $this->request->variable('user_rank_seven', 0);
				$rank_egt = (int) $this->request->variable('user_rank_eight', 0);
				$rank_nin = (int) $this->request->variable('user_rank_nine', 0);
				$rank_ten = (int) $this->request->variable('user_rank_ten', 0);
				$upd_user_id = (int) $this->request->variable('hidden_user_id', 0);

				$upd_sql = 'UPDATE ' . USERS_TABLE . '
							SET user_rank = ' . $rank_one . ',
								user_rank_two = ' . $rank_two . ',
								user_rank_three = ' . $rank_thr . ',
								user_rank_four = ' . $rank_fou . ',
								user_rank_five = ' . $rank_fiv . ',
								user_rank_six = ' . $rank_six . ',
								user_rank_seven = ' . $rank_svn . ',
								user_rank_eight = ' . $rank_egt . ',
								user_rank_nine = ' . $rank_nin . ',
								user_rank_ten = ' . $rank_ten . '
							WHERE user_id = ' . $upd_user_id;
				$this->db->sql_query($upd_sql);

				trigger_error($this->user->lang('ACP_MR_SAVED') . adm_back_link($this->u_action));
			}
		}
	}

	/**
	 * Set page url
	 *
	 * @param string $u_action Custom form action
	 * @return null
	 * @access public
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
