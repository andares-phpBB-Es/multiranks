<?php

/**
*
* @package phpBB Extension - Multi Ranks
* @copyright (c) 2015 posey - http://www.godfathertalks.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace posey\multiranks\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_MR')),
			array('module.add', array(
				'acp', 'ACP_MR',	array(
					'module_basename'	=> '\posey\multiranks\acp\multiranks_module',
					'modes'				=> array('manage'),
				),
			)),
		);
	}
	
	public function update_schema()
	{
		return array(
			'add_columns'        => array(
				$this->table_prefix . 'users'        => array(
					'user_rank_two'		=> array('UINT', 0, 'after' => 'user_rank'),
					'user_rank_three'	=> array('UINT', 0, 'after' => 'user_rank'),
				),
			),
		);
	}
	public function revert_schema()
	{
		return array(
			'drop_columns'        => array(
				$this->table_prefix . 'users'        => array(
					'user_rank_two',
					'user_rank_three',
				),
			),
		);
	}
}
