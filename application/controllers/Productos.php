<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Producto_model');
        $this->load->library('session');
    }

    public function index() {
        $data['productos'] = $this->Producto_model->obtener_productos();
        $this->load->view('dashboard_view', $data);
    }

    public function detalle($id_producto) {
        $data['producto'] = $this->Producto_model->obtener_producto($id_producto);
        $this->load->view('productos/detalle_producto', $data);
    }
}