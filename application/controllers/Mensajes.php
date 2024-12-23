<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensajes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Mensaje_model');
        $this->load->library('session');
        $this->load->model('Usuario_model');
        if (!$this->session->userdata('idusuarios')) {
            redirect('');
        }
    }

    public function index() {
        $usuario_id = $this->session->userdata('idusuarios');
        
        // Obtener usuarios con los que ya hay conversación
        $data['usuarios'] = $this->Mensaje_model->obtener_conversaciones($usuario_id);
        
        // Obtener todos los usuarios para el modal de nueva conversación
        $data['todos_usuarios'] = $this->Usuario_model->obtener_usuarios();
        $data['usuario_actual'] = [
            'idusuarios' => $this->session->userdata('idusuarios'),
            'nombre' => $this->session->userdata('nombre'),
            'rol' => $this->session->userdata('rol')
        ];
        $this->load->view('index2', $data);
    }

    public function chat($receptor_id) {
        $emisor_id = $this->session->userdata('idusuarios');
        $data['mensajes'] = $this->Mensaje_model->obtener_mensajes($emisor_id, $receptor_id);
        $data['receptor'] = $this->Usuario_model->obtener_usuario($receptor_id);
        $data['usuario_actual'] = [
            'idusuarios' => $this->session->userdata('idusuarios'),
            'nombre' => $this->session->userdata('nombre'),
            'rol' => $this->session->userdata('rol')
        ];
        $this->load->view('chat', $data);

    }

    public function enviar() {
        $emisor_id = $this->session->userdata('idusuarios');
        $datos = [
            'emisor_id' => $emisor_id,
            'receptor_id' => $this->input->post('receptor_id'),
            'mensaje' => $this->input->post('mensaje')
        ];

        $id_mensaje = $this->Mensaje_model->guardar_mensaje($datos);
        echo json_encode(['success' => true, 'id_mensaje' => $id_mensaje]);
    }
}