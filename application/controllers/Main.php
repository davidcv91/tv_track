<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->config->load('tvtrack');
        $this->load->model('Series_model');
    }

    public function index()
    {
        $vars['page_title'] = '';

        $this->load->helper('date');
        $day_name = $this->config->item('day_name');

        $result = $this->Series_model->get_following();

        foreach($result as $key => $serie)
        {
            if($serie['vo']) $serie['name'] = $serie['name'].' [VOSE]';
            $serie['day_new_episode'] = $day_name[$serie['day_new_episode']];
            $serie['final_episode'] = $serie['season'].'x'.$this->format_number($serie['episodes']);

            if(!empty($serie['episode_downloaded']))
                $serie['last_downloaded'] = $serie['season'].'x'.$this->format_number($serie['episode_downloaded']);
            else $serie['last_downloaded'] = '-';

            //$today = date();
            $today = strtotime(date('Y-m-d H:i:s'));
            $date_last_download = strtotime($serie['tstamp']);

            $diff = (int) ceil(($today - $date_last_download)/(3600*24)); //to_days

            $status = 'ok';
            if($diff >= 6 AND $diff < 7) $status = 'warning';
            else if($diff >= 7) $status = 'pending';

            $serie['status'] = $status;

            $result[$key] = $serie;
        }
        $vars['series_following'] = $result;

        $this->load->view('main', $vars);

    }

    public function download_episode()
    {
        $id_serie = $this->input->post('id_serie');

        $res = $this->Series_model->increment_episode($id_serie);
        echo json_encode($res);
        exit;
    }

    private function format_number($num_episode)
    {
        return sprintf("%02d", $num_episode);
    }
}
