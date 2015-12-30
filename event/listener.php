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

		// Grab the additional rank data
		$sql = 'SELECT *
				FROM ' . RANKS_TABLE . '
				WHERE ' . $this->db->sql_in_set('rank_id', array($rank2, $rank3));
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
		));
	}

	public function mr_on_topic($event)
	{
		$sql = 'SELECT r.*, u.user_rank_two, u.user_rank_three
				FROM ' . RANKS_TABLE . ' r
				LEFT JOIN ' . USERS_TABLE . ' u
					ON r.rank_id = u.user_rank_two
						OR r.rank_id = u.user_rank_three
				WHERE u.user_id = ' . (int) $event['poster_id'];
		$result = $this->db->sql_query($sql);

		// Set up user rank array
		$rank = array();
		$rank2 = $rank3 = '';

		while ($row = $this->db->sql_fetchrow($result))
		{
			// Define rank order
			$rank2 = (int) $row['user_rank_two'];
			$rank3 = (int) $row['user_rank_three'];

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
		));
	}

	public function mr_on_pm($event)
	{
		$rank2 = (int) $event['user_info']['user_rank_two'];
		$rank3 = (int) $event['user_info']['user_rank_three'];

		// Grab the additional rank data
		$sql = 'SELECT *
				FROM ' . RANKS_TABLE . '
				WHERE ' . $this->db->sql_in_set('rank_id', array($rank2, $rank3));
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
		));
	}
}