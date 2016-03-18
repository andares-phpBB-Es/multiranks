<?php

/**
*
* @package Multi Ranks
* @copyright (c) 2015 posey
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace posey\multiranks\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/

class listener implements EventSubscriberInterface
{
	/* @var \phpbb\template\template */
	protected $template;
	/* @var \phpbb\db\driver\driver_interface */
	protected $db;
	/** @var \phpbb\config\config */
	protected $config;
	/** @var String phpBB Root path */
	protected $phpbb_root_path;

	/**
	* Constructor
	*
	* @param \phpbb\template					$template	Template object
	* @param \phpbb\db\driver\driver_interface	$db			Database
	* @param \phpbb\config\config				$config		Config
	* @param String								$phpbb_root_path	phpBB Root path
	*/
	public function __construct(\phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, $phpbb_root_path)
	{
		$this->template = $template;
		$this->db = $db;
		$this->config = $config;
		$this->phpbb_root_path = $phpbb_root_path;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.memberlist_view_profile'			=> 'mr_on_profile',
			'core.viewtopic_modify_post_row'		=> 'mr_on_topic',
			'core.ucp_pm_view_messsage'				=> 'mr_on_pm',
		);
	}

	public function mr_on_profile($event)
	{
		$rank2 = (int) $event['member']['user_rank_two'];
		$rank3 = (int) $event['member']['user_rank_three'];
		$rank4 = (int) $event['member']['user_rank_four'];
		$rank5 = (int) $event['member']['user_rank_five'];
		$rank6 = (int) $event['member']['user_rank_six'];
		$rank7 = (int) $event['member']['user_rank_seven'];
		$rank8 = (int) $event['member']['user_rank_eight'];
		$rank9 = (int) $event['member']['user_rank_nine'];
		$rank10 = (int) $event['member']['user_rank_ten'];

		// Grab the additional rank data
		$sql = 'SELECT *
				FROM ' . RANKS_TABLE . '
				WHERE ' . $this->db->sql_in_set('rank_id', array($rank2, $rank3, $rank3, $rank4, $rank5, $rank6, $rank7, $rank8, $rank9, $rank10));
		$result = $this->db->sql_query($sql);

		// Set up user rank array
		$rank = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			$rank[$row['rank_id']]['title'] = $row['rank_title'];
			$rank[$row['rank_id']]['src'] = (!empty($row['rank_image'])) ? $this->phpbb_root_path . $this->config['ranks_path'] . '/' . $row['rank_image'] : '';
			$rank[$row['rank_id']]['img'] = (!empty($row['rank_image'])) ? '<img src="' . $rank[$row['rank_id']]['src'] . '" alt="' . $row['rank_title'] . '" title="' . $row['rank_title'] . '" />' : '';
		}

		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'RANK_TWO_TITLE'	=> $rank2 ? $rank[$rank2]['title'] : '',
			'RANK_TWO_IMG'		=> $rank2 ? $rank[$rank2]['img'] : '',
			'RANK_THR_TITLE'	=> $rank3 ? $rank[$rank3]['title'] : '',
			'RANK_THR_IMG'		=> $rank3 ? $rank[$rank3]['img'] : '',
			'RANK_FOU_TITLE'	=> $rank4 ? $rank[$rank4]['title'] : '',
			'RANK_FOU_IMG'		=> $rank4 ? $rank[$rank4]['img'] : '',
			'RANK_FIV_TITLE'	=> $rank5 ? $rank[$rank5]['title'] : '',
			'RANK_FIV_IMG'		=> $rank5 ? $rank[$rank5]['img'] : '',
			'RANK_SIX_TITLE'	=> $rank6 ? $rank[$rank6]['title'] : '',
			'RANK_SIX_IMG'		=> $rank6 ? $rank[$rank6]['img'] : '',
			'RANK_SVN_TITLE'	=> $rank7 ? $rank[$rank7]['title'] : '',
			'RANK_SVN_IMG'		=> $rank7 ? $rank[$rank7]['img'] : '',
			'RANK_EGT_TITLE'	=> $rank8 ? $rank[$rank8]['title'] : '',
			'RANK_EGT_IMG'		=> $rank8 ? $rank[$rank8]['img'] : '',
			'RANK_NIN_TITLE'	=> $rank9 ? $rank[$rank9]['title'] : '',
			'RANK_NIN_IMG'		=> $rank9 ? $rank[$rank9]['img'] : '',
			'RANK_TEN_TITLE'	=> $rank10 ? $rank[$rank10]['title'] : '',
			'RANK_TEN_IMG'		=> $rank10 ? $rank[$rank10]['img'] : '',
		));
	}

	public function mr_on_topic($event)
	{
		$sql = 'SELECT r.*, u.user_rank_two, u.user_rank_three, u.user_rank_four, u.user_rank_five, u.user_rank_six, u.user_rank_seven, u.user_rank_eight, u.user_rank_nine, u.user_rank_ten
				FROM ' . RANKS_TABLE . ' r
				LEFT JOIN ' . USERS_TABLE . ' u
					ON r.rank_id = u.user_rank_two
						OR r.rank_id = u.user_rank_three
						OR r.rank_id = u.user_rank_four
						OR r.rank_id = u.user_rank_five
						OR r.rank_id = u.user_rank_six
						OR r.rank_id = u.user_rank_seven
						OR r.rank_id = u.user_rank_eight
						OR r.rank_id = u.user_rank_nine
						OR r.rank_id = u.user_rank_ten
				WHERE u.user_id = ' . (int) $event['poster_id'];
		$result = $this->db->sql_query($sql);

		// Set up user rank array
		$rank = array();
		$rank2 = $rank3 = $rank4 = $rank5 = $rank6 = $rank7 = $rank8 = $rank9 = $rank10 = '';

		while ($row = $this->db->sql_fetchrow($result))
		{
			// Define rank order
			$rank2 = (int) $row['user_rank_two'];
			$rank3 = (int) $row['user_rank_three'];
			$rank4 = (int) $row['user_rank_four'];
			$rank5 = (int) $row['user_rank_five'];
			$rank6 = (int) $row['user_rank_six'];
			$rank7 = (int) $row['user_rank_seven'];
			$rank8 = (int) $row['user_rank_eight'];
			$rank9 = (int) $row['user_rank_nine'];
			$rank10 = (int) $row['user_rank_ten'];

			$rank[$row['rank_id']]['title'] = $row['rank_title'];
			$rank[$row['rank_id']]['src'] = (!empty($row['rank_image'])) ? $this->phpbb_root_path . $this->config['ranks_path'] . '/' . $row['rank_image'] : '';
			$rank[$row['rank_id']]['img'] = (!empty($row['rank_image'])) ? '<img src="' . $rank[$row['rank_id']]['src'] . '" alt="' . $row['rank_title'] . '" title="' . $row['rank_title'] . '" />' : '';
		}

		$this->db->sql_freeresult($result);

		$event['post_row'] = array_merge($event['post_row'], array(
			'RANK_TWO_TITLE'	=> $rank2 ? $rank[$rank2]['title'] : '',
			'RANK_TWO_IMG'		=> $rank2 ? $rank[$rank2]['img'] : '',
			'RANK_THR_TITLE'	=> $rank3 ? $rank[$rank3]['title'] : '',
			'RANK_THR_IMG'		=> $rank3 ? $rank[$rank3]['img'] : '',
			'RANK_FOU_TITLE'	=> $rank4 ? $rank[$rank4]['title'] : '',
			'RANK_FOU_IMG'		=> $rank4 ? $rank[$rank4]['img'] : '',
			'RANK_FIV_TITLE'	=> $rank5 ? $rank[$rank5]['title'] : '',
			'RANK_FIV_IMG'		=> $rank5 ? $rank[$rank5]['img'] : '',
			'RANK_SIX_TITLE'	=> $rank6 ? $rank[$rank6]['title'] : '',
			'RANK_SIX_IMG'		=> $rank6 ? $rank[$rank6]['img'] : '',
			'RANK_SVN_TITLE'	=> $rank7 ? $rank[$rank7]['title'] : '',
			'RANK_SVN_IMG'		=> $rank7 ? $rank[$rank7]['img'] : '',
			'RANK_EGT_TITLE'	=> $rank8 ? $rank[$rank8]['title'] : '',
			'RANK_EGT_IMG'		=> $rank8 ? $rank[$rank8]['img'] : '',
			'RANK_NIN_TITLE'	=> $rank9 ? $rank[$rank9]['title'] : '',
			'RANK_NIN_IMG'		=> $rank9 ? $rank[$rank9]['img'] : '',
			'RANK_TEN_TITLE'	=> $rank10 ? $rank[$rank10]['title'] : '',
			'RANK_TEN_IMG'		=> $rank10 ? $rank[$rank10]['img'] : '',
		));
	}

	public function mr_on_pm($event)
	{
		$rank2 = (int) $event['user_info']['user_rank_two'];
		$rank3 = (int) $event['user_info']['user_rank_three'];
		$rank4 = (int) $event['user_info']['user_rank_four'];
		$rank5 = (int) $event['user_info']['user_rank_five'];
		$rank6 = (int) $event['user_info']['user_rank_six'];
		$rank7 = (int) $event['user_info']['user_rank_seven'];
		$rank8 = (int) $event['user_info']['user_rank_eight'];
		$rank9 = (int) $event['user_info']['user_rank_nine'];
		$rank10 = (int) $event['user_info']['user_rank_ten'];

		// Grab the additional rank data
		$sql = 'SELECT *
				FROM ' . RANKS_TABLE . '
				WHERE ' . $this->db->sql_in_set('rank_id', array($rank2, $rank3, $rank4, $rank5, $rank6, $rank7, $rank8, $rank9, $rank10));
		$result = $this->db->sql_query($sql);

		// Set up user rank array
		$rank = array();

		while ($row = $this->db->sql_fetchrow($result))
		{
			$rank[$row['rank_id']]['title'] = $row['rank_title'];
			$rank[$row['rank_id']]['src'] = (!empty($row['rank_image'])) ? $this->phpbb_root_path . $this->config['ranks_path'] . '/' . $row['rank_image'] : '';
			$rank[$row['rank_id']]['img'] = (!empty($row['rank_image'])) ? '<img src="' . $rank[$row['rank_id']]['src'] . '" alt="' . $row['rank_title'] . '" title="' . $row['rank_title'] . '" />' : '';
		}

		$this->db->sql_freeresult($result);

		$this->template->assign_vars(array(
			'RANK_TWO_TITLE'	=> $rank2 ? $rank[$rank2]['title'] : '',
			'RANK_TWO_IMG'		=> $rank2 ? $rank[$rank2]['img'] : '',
			'RANK_THR_TITLE'	=> $rank3 ? $rank[$rank3]['title'] : '',
			'RANK_THR_IMG'		=> $rank3 ? $rank[$rank3]['img'] : '',
			'RANK_FOU_TITLE'	=> $rank4 ? $rank[$rank4]['title'] : '',
			'RANK_FOU_IMG'		=> $rank4 ? $rank[$rank4]['img'] : '',
			'RANK_FIV_TITLE'	=> $rank5 ? $rank[$rank5]['title'] : '',
			'RANK_FIV_IMG'		=> $rank5 ? $rank[$rank5]['img'] : '',
			'RANK_SIX_TITLE'	=> $rank6 ? $rank[$rank6]['title'] : '',
			'RANK_SIX_IMG'		=> $rank6 ? $rank[$rank6]['img'] : '',
			'RANK_SVN_TITLE'	=> $rank7 ? $rank[$rank7]['title'] : '',
			'RANK_SVN_IMG'		=> $rank7 ? $rank[$rank7]['img'] : '',
			'RANK_EGT_TITLE'	=> $rank8 ? $rank[$rank8]['title'] : '',
			'RANK_EGT_IMG'		=> $rank8 ? $rank[$rank8]['img'] : '',
			'RANK_NIN_TITLE'	=> $rank9 ? $rank[$rank9]['title'] : '',
			'RANK_NIN_IMG'		=> $rank9 ? $rank[$rank9]['img'] : '',
			'RANK_TEN_TITLE'	=> $rank10 ? $rank[$rank10]['title'] : '',
			'RANK_TEN_IMG'		=> $rank10 ? $rank[$rank10]['img'] : '',
		));
	}
}
