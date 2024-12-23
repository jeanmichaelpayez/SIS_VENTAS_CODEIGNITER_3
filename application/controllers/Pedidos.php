<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Pedidos_model');
        $this->load->library('session');
        
        // Verificar si el usuario está logueado
        if (!$this->session->userdata('idusuarios')) {
            redirect('');
        }
    }

    public function index() {
        $data['nombre'] = $this->session->userdata('nombre');
        $data['rol'] = $this->session->userdata('rol');
        $usuario_id = $this->session->userdata('idusuarios');
        $data['pedidos'] = $this->Pedidos_model->obtener_pedidos_usuario($usuario_id);
        $this->load->view('lista_pedidos', $data);
    }

    public function detalle($id_pedido) {
        $data['nombre'] = $this->session->userdata('nombre');
        $data['rol'] = $this->session->userdata('rol');
        $usuario_id = $this->session->userdata('idusuarios');
        $data['pedido'] = $this->Pedidos_model->obtener_pedido($id_pedido, $usuario_id);
        $data['detalles'] = $this->Pedidos_model->obtener_detalles_pedido($id_pedido);
        $this->load->view('detalle_pedido', $data);
    }
}
