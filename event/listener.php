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
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'load_language_on_setup',
			'core.memberlist_view_profile'			=> 'mr_on_profile',
			'core.viewtopic_modify_post_row'		=> 'mr_on_topic',
			'core.ucp_pm_view_messsage'				=> 'mr_on_pm',
		);
	}
	/* @var \phpbb\controller\helper */
	protected $helper;
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
	* @param \phpbb\controller\helper			$helper		Controller helper object
	* @param \phpbb\template					$template	Template object
	* @param \phpbb\db\driver\driver_interface	$db			Database
	* @param \phpbb\config\config				$config		Config
	* @param String								$phpbb_root_path	phpBB Root path
	*/
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, $phpbb_root_path)
	{
		$this->helper = $helper;
		$this->template = $template;
		$this->db = $db;
		$this->config = $config;
		$this->phpbb_root_path = $phpbb_root_path;
	}
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'posey/multiranks',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	public function mr_on_profile($event)
	{
		$member = $event['member']; 
		$user_rank_two = (int) $member['user_rank_two'];
		$user_rank_thr = (int) $member['user_rank_three'];
		
		$sql_two = 'SELECT *
					FROM ' . RANKS_TABLE . '
					WHERE rank_id = ' . $user_rank_two;
		$sql_thr = 'SELECT * 
					FROM ' . RANKS_TABLE . '
					WHERE rank_id = ' . $user_rank_thr;
		$rank_two_res	= $this->db->sql_query($sql_two);
		$rank_two		= $this->db->sql_fetchrow($rank_two_res);
		$rank_thr_res	= $this->db->sql_query($sql_thr);
		$rank_thr		= $this->db->sql_fetchrow($rank_thr_res);
		$this->db->sql_freeresult($rank_two_res);
		$this->db->sql_freeresult($rank_thr_res);

		$rank_two_src = (!empty($rank_two['rank_image'])) ? $this->phpbb_root_path . $this->config['ranks_path'] . '/' . $rank_two['rank_image'] : '';
		$rank_thr_src = (!empty($rank_thr['rank_image'])) ? $this->phpbb_root_path . $this->config['ranks_path'] . '/' . $rank_two['rank_image'] : '';
		$rank_two_img = (!empty($rank_two['rank_image'])) ? '<img src="' . $rank_two_src . '" alt="' . $rank_two['rank_title'] . '" title="' . $rank_two['rank_title'] . '" />' : '';
		$rank_thr_img = (!empty($rank_thr['rank_image'])) ? '<img src="' . $rank_thr_src . '" alt="' . $rank_thr['rank_title'] . '" title="' . $rank_thr['rank_title'] . '" />' : '';
		
		$this->template->assign_vars(array(
			'RANK_TWO_TITLE'	=> $rank_two['rank_title'],
			'RANK_TWO_IMG'		=> $rank_two_img,
			'RANK_TWO_IMG_SRC'	=> $rank_two_src,
			'RANK_THR_TITLE'	=> $rank_thr['rank_title'],
			'RANK_THR_IMG'		=> $rank_thr_img,
			'RANK_THR_IMG_SRC'	=> $rank_thr_src,
		));
	}
	
	public function mr_on_topic($event)
	{
		$user_rank = 'SELECT user_rank_two, user_rank_three FROM ' . USERS_TABLE . ' WHERE user_id = ' . $event['poster_id'];
		$user_rank_res = $this->db->sql_query($user_rank);
		while ($rank_row = $this->db->sql_fetchrow($user_rank_res))
		{
			$user_rank_two = $rank_row['user_rank_two'];
			$user_rank_thr = $rank_row['user_rank_three'];
		}
		
		$sql_two = 'SELECT *
					FROM ' . RANKS_TABLE . '
					WHERE rank_id = ' . $user_rank_two;
		$sql_thr = 'SELECT * 
					FROM ' . RANKS_TABLE . '
					WHERE rank_id = ' . $user_rank_thr;
		$rank_two_res	= $this->db->sql_query($sql_two);
		$rank_two		= $this->db->sql_fetchrow($rank_two_res);
		$rank_thr_res	= $this->db->sql_query($sql_thr);
		$rank_thr		= $this->db->sql_fetchrow($rank_thr_res);
		$this->db->sql_freeresult($rank_two_res);
		$this->db->sql_freeresult($rank_thr_res);
		$this->db->sql_freeresult($user_rank_res);
		
		$rank_two_src = (!empty($rank_two['rank_image'])) ? $this->phpbb_root_path . $this->config['ranks_path'] . '/' . $rank_two['rank_image'] : '';
		$rank_thr_src = (!empty($rank_thr['rank_image'])) ? $this->phpbb_root_path . $this->config['ranks_path'] . '/' . $rank_thr['rank_image'] : '';
		$rank_two_img = (!empty($rank_two['rank_image'])) ? '<img src="' . $rank_two_src . '" alt="' . $rank_two['rank_title'] . '" title="' . $rank_two['rank_title'] . '" />' : '';
		$rank_thr_img = (!empty($rank_thr['rank_image'])) ? '<img src="' . $rank_thr_src . '" alt="' . $rank_thr['rank_title'] . '" title="' . $rank_thr['rank_title'] . '" />' : '';
		
		$event['post_row'] = array_merge($event['post_row'], array(
			'RANK_TWO_TITLE'	=> $rank_two['rank_title'],
			'RANK_TWO_IMG'		=> $rank_two_img,
			'RANK_TWO_IMG_SRC'	=> $rank_two_src,
			'RANK_THR_TITLE'	=> $rank_thr['rank_title'],
			'RANK_THR_IMG'		=> $rank_thr_img,
			'RANK_THR_IMG_SRC'	=> $rank_thr_src,
		));
	}
		
	public function mr_on_pm($event)
	{
		$user_info = $event['user_info'];
		$user_rank_two = (int) $user_info['user_rank_two'];
		$user_rank_thr = (int) $user_info['user_rank_three'];
		
		$sql_two = 'SELECT *
					FROM ' . RANKS_TABLE . '
					WHERE rank_id = ' . $user_rank_two;
		$sql_thr = 'SELECT * 
					FROM ' . RANKS_TABLE . '
					WHERE rank_id = ' . $user_rank_thr;
		$rank_two_res	= $this->db->sql_query($sql_two);
		$rank_two		= $this->db->sql_fetchrow($rank_two_res);
		$rank_thr_res	= $this->db->sql_query($sql_thr);
		$rank_thr		= $this->db->sql_fetchrow($rank_thr_res);
		$this->db->sql_freeresult($rank_two_res);
		$this->db->sql_freeresult($rank_thr_res);
		
		$rank_two_src = (!empty($rank_two['rank_image'])) ? $this->phpbb_root_path . $this->config['ranks_path'] . '/' . $rank_two['rank_image'] : '';
		$rank_thr_src = (!empty($rank_thr['rank_image'])) ? $this->phpbb_root_path . $this->config['ranks_path'] . '/' . $rank_two['rank_image'] : '';
		$rank_two_img = (!empty($rank_two['rank_image'])) ? '<img src="' . $rank_two_src . '" alt="' . $rank_two['rank_title'] . '" title="' . $rank_two['rank_title'] . '" />' : '';
		$rank_thr_img = (!empty($rank_thr['rank_image'])) ? '<img src="' . $rank_thr_src . '" alt="' . $rank_thr['rank_title'] . '" title="' . $rank_thr['rank_title'] . '" />' : '';
		
		$this->template->assign_vars(array(
			'RANK_TWO_TITLE'	=> $rank_two['rank_title'],
			'RANK_TWO_IMG'		=> $rank_two_img,
			'RANK_TWO_IMG_SRC'	=> $rank_two_src,
			'RANK_THR_TITLE'	=> $rank_thr['rank_title'],
			'RANK_THR_IMG'		=> $rank_thr_img,
			'RANK_THR_IMG_SRC'	=> $rank_thr_src,
		));
	}
}