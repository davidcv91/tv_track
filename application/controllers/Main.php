<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Series_model');
    }

    public function index() {
        if($this->session->has_userdata('login')) redirect('following');
        redirect('login');
    }

    public function login() {
        $vars['page_title'] = 'Login';
        $this->load->view('login', $vars);
    }

    public function check_login() {
        $this->load->model('Login_model');
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $result = $this->Login_model->check_user_password($username, $password);
        if($result) {
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

        $today = array();

        foreach($result as $key => $serie)
        {
            $serie_tstamp = $serie['tstamp'];
            if(!empty($serie['next_episode_tstamp'])) $serie_tstamp = $serie['next_episode_tstamp'];
            $serie['status'] = $this->get_status($serie_tstamp, $serie['day_new_episode']);

            if($serie['status'] != 'ok') {
                $today[] = $serie['name'].' - '.$serie['season'].'x'.format_number($serie['episode_downloaded']+1);
            }

            if($serie['vo']) $serie['name'] = $serie['name'].' <span class="label label-info">VOSE</span>';

            $serie['day_new_episode'] = get_letter_num_day($serie['day_new_episode']);

            $serie['final_episode'] = $serie['season'].'x'.format_number($serie['episodes']);

            if (!empty($serie['tstamp'])) {
                $serie['last_download'] = $this->format_last_download_date($serie['tstamp']);
            }
            else $serie['last_download'] = '';

            if(!empty($serie['episode_downloaded'])) {
                $serie['last_downloaded'] = $serie['season'].'x'.format_number($serie['episode_downloaded']);
            }
            else $serie['last_downloaded'] = '-';

            $result[$key] = $serie;
        }

        $vars['series_following'] = $result;

        $vars['today'] = json_encode($today);

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

    private function get_status($tstamp, $day_episode)
    {
        $today = date('Y-m-d');

        $tstamp_day_download = strtotime(date('Y-m-d', strtotime($tstamp))); 
        //0 = monday
        $day_week = jddayofweek($day_episode-1, 1);

        $day_next_episode = date('Y-m-d', strtotime('next '.$day_week, $tstamp_day_download)); 

        $status = 'ok';
        if ($today == $day_next_episode) $status = 'available';
        else if ($day_next_episode < $today) $status = 'pending';

        return $status;
    }

    public function download_episode() {

        $id_serie = $this->input->post('id_serie');

        $res = FALSE;
        if($this->Series_model->exists_tracking($id_serie)) {
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

    public function postpone_episode() {

        $id_serie = $this->input->post('id_serie');

        $res = FALSE;
        if($this->Series_model->exists_tracking($id_serie)) {
            $res = $this->Series_model->postpone_episode($id_serie);
        }
        else $res = TRUE;
        
        echo json_encode(
            array('result' => $res)
        );
        exit;
    }
}
