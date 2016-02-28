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
            //$this->Login_model->login_attempts($username, $password);
            redirect('login');
        }
    }

    public function following() {
        $vars['page_title'] = 'Siguiendo';

        $result = $this->Series_model->get_following();

        foreach($result as $key => $serie)
        {
            if($serie['vo']) $serie['name'] = $serie['name'].' [VOSE]';
            $serie['day_new_episode'] = get_letter_num_day($serie['day_new_episode']);
            $serie['final_episode'] = $serie['season'].'x'.format_number($serie['episodes']);

            if(!empty($serie['episode_downloaded']))
                $serie['last_downloaded'] = $serie['season'].'x'.format_number($serie['episode_downloaded']);
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

    public function series() {
        $vars['page_title'] = 'Siguiendo';

        $result = $this->Series_model->get_series();

        foreach($result as $key => $serie)
        {
            $serie['day_new_episode'] = get_letter_num_day($serie['day_new_episode']);

            $result[$key] = $serie;
        }
        $vars['series'] = $result;

        $this->load->view('series', $vars);
    }

    public function download_episode() {
        $id_serie = $this->input->post('id_serie');

        $res = $this->Series_model->increment_episode($id_serie);
        echo json_encode($res);
        exit;
    }

    public function edit_field_serie() {
        $id_serie = $this->input->post('id_serie');
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        if($field == 'day_new_episode' AND !is_numeric($value)) {
           $value = get_num_day($value);
        }

        $res = $this->Series_model->edit_field_serie($id_serie, $field, $value);
        echo json_encode($res);
        exit;
    }

    
}
