<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Series_model');
    }

    public function index() 
    {
        if ($this->session->has_userdata('login')) redirect('following');
        redirect('login');
    }

    public function login() 
    {
        $vars['page_title'] = 'Login';
        $this->load->view('login', $vars);
    }

    public function check_login() 
    {
        $this->load->model('Login_model');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $result = $this->Login_model->check_user_password($username, $password);
        if ($result) {
            $this->session->set_userdata('login', TRUE);
            redirect('following');
        }
        else {
            $this->Login_model->login_attempts($username, $password);
            redirect('login');
        }
    }

    public function following() {

        $vars['page_title'] = 'Series Siguiendo';

        $result = $this->Series_model->get_following();

        $this->load->library('serie');

        foreach ($result as $serie) {

            $serie_data = array();
            $this->serie = new Serie($serie);

            $serie_data['id'] = $this->serie->getId();
            $serie_data['name'] = $this->serie->getName();
            $serie_data['season'] = $this->serie->getSeason();

            $serie_data['vo'] = $this->serie->isVO();

            $serie_data['day_available'] = $this->serie->getLetterDayAvailable();

            $serie_data['season_finale'] = $this->serie->getSeason().'x'.$this->serie->getSeasonEpisodesFormatted();

            $serie_data['is_season_finale'] = $this->serie->isSeasonFinale();

            $serie_data['episode_downloaded'] = $this->serie->getLastEpisodeDownloaded();

            $serie_data['date_last_download'] = $this->serie->getDateLastEpisodeDownloadedFormatted();

            $serie_data['next_download'] = $this->serie->getSeason().'x'.$this->serie->getNextEpisodeFormatted();

            $serie_data['download_status'] = $this->serie->getDownloadStatus();

            $vars['series_following'][] = $serie_data;
        }

        $this->load->view('main', $vars);
    }

    private function format_last_download_date($date)
    {
        $this->lang->load('calendar', 'es');
        $date_tstamp = strtotime($date);

        $day_name_date = strtolower(date('D', $date_tstamp));
        $day_name = lang('cal_'.$day_name_date);
        
        $day = date('d', $date_tstamp);

        $month_name_date = strtolower(date('M', $date_tstamp));
        $month_name = lang('cal_'.$month_name_date);

        $hour = date('H:i', $date_tstamp);

        return $day_name.' '.$day.' '.$month_name.' '.$hour;
    }

    public function download_episode() 
    {
        $id_serie = $this->input->post('id_serie');

        $res = FALSE;
        if ($this->Series_model->exists_tracking($id_serie)) {
            $res = $this->Series_model->increment_episode($id_serie);
        }
        else $res = $this->Series_model->start_tracking($id_serie);
        
        echo json_encode(
            array(
                'result' => $res, 
                'current_date' => $this->format_last_download_date(date('Y-m-d H:i'))
            )
        );
        exit;
    }

    public function postpone_episode() 
    {
        $id_serie = $this->input->post('id_serie');

        $res = FALSE;
        if ($this->Series_model->exists_tracking($id_serie)) {
            $res = $this->Series_model->postpone_episode($id_serie);
        }
        else $res = TRUE;
        
        echo json_encode(
            array('result' => $res)
        );
        exit;
    }
}
