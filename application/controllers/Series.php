<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Series extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if(!$this->session->has_userdata('login')) redirect('main/login');

        $this->load->model('Series_model');
    }


    public function index() {
        $vars['page_title'] = 'Mis Series';

        $result = $this->Series_model->get_series();

        foreach($result as $key => $serie)
        {
            $serie['letter_day_new_episode'] = get_letter_num_day($serie['day_new_episode']);

            if($serie['vo'] == 1) {
                $serie['vo_img'] = '<span class="glyphicon glyphicon-ok"></span>';
            }
            else $serie['vo_img'] = '<span class="glyphicon glyphicon-remove"></span>';


            $result[$key] = $serie;
        }
        $vars['series'] = $result;

        $this->load->view('series', $vars);
    }


    public function change_status_serie() {
        $id_serie = $this->input->post('id_serie');
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        $res = $this->Series_model->edit_field_serie($id_serie, $field, $value);
        redirect('series');
    }

    public function add_serie() {
        $data = $this->get_post_modal();

        $this->Series_model->add_serie($data);
        redirect('series');
    }

    public function edit_serie() {
        
        $data = $this->get_post_modal();

        $id_serie = $this->input->post('id_serie');

        $this->Series_model->edit_serie($id_serie, $data);
        redirect('series');
    }

    public function delete_serie() {
        
        $id_serie = $this->input->post('id_serie');

        $this->Series_model->delete_serie($id_serie);
        redirect('series');
    }
    
    private function get_post_modal() {
        $data = array(
            'name' => $this->input->post('name'),
            'vo' => ($this->input->post('vo')) ? 1 : 0,
            'season' => $this->input->post('season'),
            'episodes' => $this->input->post('episodes'),
            'day_new_episode' => $this->input->post('day_new_episode')
        );

        return $data;
    }
}
