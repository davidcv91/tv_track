<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Serie {

	private $id;
	private $name;
	private $status;
	private $vo;
	private $season;
	private $season_episodes;
	private $day_num_available;
	private $letter_day_available;
	private $day_available;
	private $last_episode_downloaded;
	private $date_last_episode_downloaded;
	private $postponed;

	protected $CI;

	public function __construct($serie = null)
	{
		$this->CI =& get_instance();

		$this->CI->lang->load('calendar', 'es');

		if (!empty($serie)) $this->initialize($serie);
	}

	private function initialize($serie)
	{
		$this->setId($serie->id);
		$this->setName($serie->name);
		$this->setStatus($serie->status);
		$this->setVO($serie->vo);
		$this->setSeason($serie->season);
		$this->setSeasonEpisodes($serie->episodes);
		$this->setDayAvailable($serie->day_new_episode);
		$this->setLastEpisodeDownloaded($serie->episode_downloaded);
		$this->setDateLastEpisodeDownloaded($serie->tstamp);
		$this->setDateNextEpisode($serie->next_episode_tstamp);
	}

	/**
		SETTERS
	**/
	public function setId($id) 
	{
		$this->id = $id;
	}

	public function setName($name) 
	{
		$this->name = $name;
	}

	public function setStatus($status) 
	{
		$this->status = $status;
	}

	public function setVO($vo) 
	{
		$this->vo = ($vo == 1) ? TRUE : FALSE;
	}

	public function setSeason($season) 
	{
		$this->season = $season;
	}

	public function setSeasonEpisodes($season_episodes) 
	{
		$this->season_episodes = $season_episodes;
	}

	public function setDayAvailable($day_num_available) 
	{
		$this->day_num_available = $day_num_available;
		$this->letter_day_available = $this->getDayLetterByDayNum($day_num_available);
		$this->day_available = $this->getDayByDayNum($day_num_available);
	}

	public function setLastEpisodeDownloaded($last_episode_downloaded) 
	{
		if (!isset($last_episode_downloaded)) $this->last_episode_downloaded = 0;
		else $this->last_episode_downloaded = $last_episode_downloaded;
	}

	public function setDateLastEpisodeDownloaded($date_last_episode_downloaded) 
	{
		if (!isset($date_last_episode_downloaded)) $this->date_last_episode_downloaded = '';
		else $this->date_last_episode_downloaded = $date_last_episode_downloaded;
	}

	public function setDateNextEpisode($date_next_episode) 
	{
		if (!isset($date_next_episode)) {
			$this->date_next_episode = '';
			$this->postponed = FALSE;
		}
		else {
			$this->date_next_episode = $date_next_episode;
			$this->postponed = TRUE;
		}
	}

	/**
		GETTERS
	**/
	public function getId() 
	{
		return $this->id;
	}

	public function getName() 
	{
		return $this->name;
	}

	public function getStatus() 
	{
		return $this->status;
	}

	public function isVO() 
	{
		return $this->vo;
	}

	public function getSeason() 
	{
		return $this->season;
	}

	public function getSeasonEpisodes() 
	{
		return $this->season_episodes;
	}

	public function getDayAvailable() 
	{
		return $this->day_available;
	}

	public function getLetterDayAvailable() 
	{
		return $this->letter_day_available;
	}

	public function getNumDayAvailable() 
	{
		return $this->day_num_available;
	}

	public function getLastEpisodeDownloaded() 
	{
		return $this->last_episode_downloaded;
	}

	public function getDateLastEpisodeDownloaded() 
	{
		return $this->date_last_episode_downloaded;
	}

	public function getDateNextEpisode() 
	{
		return $this->date_next_episode;
	}

	public function isPostponed() 
	{
		return $this->postponed;
	}
//---
	public function getSeasonEpisodesFormatted() 
	{
		return sprintf("%02d", $this->getSeasonEpisodes());
	}

	public function getLastEpisodeDownloadedFormatted() 
	{
		return sprintf("%02d", $this->getLastEpisodeDownloaded());
	}

	public function getNextEpisode() 
	{
		if ($this->isSeasonFinale()) return $this->getLastEpisodeDownloaded();
		else return $this->getLastEpisodeDownloaded()+1;
	}

	public function getNextEpisodeFormatted() 
	{
		return sprintf("%02d", $this->getNextEpisode());
	}

	public function getDateLastEpisodeDownloadedFormatted() 
	{
		$date = $this->getDateLastEpisodeDownloaded();
		$date_tstamp = strtotime($date);

        $day_name_date = strtolower(date('D', $date_tstamp));
        $day_name = $this->CI->lang->line('cal_'.$day_name_date);
        
        $day = date('d', $date_tstamp);

        $month_name_date = strtolower(date('M', $date_tstamp));
        $month_name = $this->CI->lang->line('cal_'.$month_name_date);

        $hour = date('H:i', $date_tstamp);

        return $day_name.' '.$day.' '.$month_name.' '.$hour;
	}

	public function getDownloadStatus()
	{
		$tstamp = $this->getDateLastEpisodeDownloaded();
       	if ($this->isPostponed()) $tstamp = $this->getDateNextEpisode();

       	$today = date('Y-m-d');

        $tstamp_day_download = strtotime(date('Y-m-d', strtotime($tstamp))); 
        //0 = monday
        $day_week = jddayofweek($this->getNumDayAvailable()-1, 1);

        $day_next_episode = date('Y-m-d', strtotime('next '.$day_week, $tstamp_day_download)); 

        $status = 'ok';
        if ($this->isSeasonFinale()) $status = 'finished';
        else if ($today == $day_next_episode) $status = 'available';
        else if ($day_next_episode < $today) $status = 'pending';

        return $status;
	}

	public function isSeasonFinale()
	{
		return ($this->getSeasonEpisodes() == $this->getLastEpisodeDownloaded());
	}

	private function getDayLetterByDayNum($num)
	{
		$letter = '';
		switch ($num) {
			case 1: 
				$letter = $this->CI->lang->line('cal_mo_letter');
				break;
			case 2: 
				$letter = $this->CI->lang->line('cal_tu_letter');
				break;
			case 3: 
				$letter = $this->CI->lang->line('cal_we_letter');
				break;
			case 4: 
				$letter = $this->CI->lang->line('cal_th_letter');
				break;
			case 5: 
				$letter = $this->CI->lang->line('cal_fr_letter');
				break;
			case 6: 
				$letter = $this->CI->lang->line('cal_sa_letter');
				break;
			case 7: 
				$letter = $this->CI->lang->line('cal_su_letter');
				break;
			default: 
				$letter = '';
				break;
		}
		return $letter;
	}

	private function getDayByDayNum($num)
	{
		$day = '';
		switch ($num) {
			case 1: 
				$day = $this->CI->lang->line('cal_monday');
				break;
			case 2: 
				$day = $this->CI->lang->line('cal_tuesday');
				break;
			case 3: 
				$day = $this->CI->lang->line('cal_wednesday');
				break;
			case 4: 
				$day = $this->CI->lang->line('cal_thursday');
				break;
			case 5: 
				$day = $this->CI->lang->line('cal_friday');
				break;
			case 6: 
				$day = $this->CI->lang->line('cal_saturday');
				break;
			case 7: 
				$day = $this->CI->lang->line('cal_sunday');
				break;
			default: 
				$day = '';
				break;
		}
		return $day;
	}
}
