<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('Middleware');
        $this->load->model('Producto_model');
        $this->middleware->check_login();
    }

    public function index() {
        $data = [
            'nombre' => $this->session->userdata('nombre'),
            'rol' => $this->session->userdata('rol'),
            'productos' => $this->Producto_model->obtener_productos()
        ];
        $this->load->view('dashboard_view', $data);
    }
    public function api() {
        $data = [
            'idusuarios'=> $this->session->userdata('idusuarios'),
            'nombre' => $this->session->userdata('nombre'),
            'rol' => $this->session->userdata('rol')
        ];
        $this->load->view('api_view', $data);
    }
    public function dni() {
        $data = [
            'nombre' => $this->session->userdata('nombre'),
            'rol' => $this->session->userdata('rol')
        ];
        $this->load->view('dni', $data);
    }

}
