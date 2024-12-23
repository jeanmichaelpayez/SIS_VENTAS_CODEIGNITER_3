<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reniec_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Reniec_model');
        $this->load->library('Middleware');
        $this->middleware->check_login();
    }

    public function index() {
        $data = [
            'nombre' => $this->session->userdata('nombre'),
            'rol' => $this->session->userdata('rol')
        ];
        $this->load->view('dashboard_view', $data);
    }

    public function consultar() {
        // Obtener el DNI del formulario
        $dni = $this->input->post('dni');

        if ($dni) {
            // Llamar al modelo para obtener los datos de la persona
            $persona = $this->Reniec_model->get_persona_by_dni($dni);

            if ($persona) {
                if (isset($persona['message']) && $persona['message'] == 'Token no invalido') {
                    $data['error'] = 'Error: Token no válido. Por favor, verifica el token o genera uno nuevo.';
                } else {
                    $data['persona'] = $persona;
                }
            } else {
                $data['error'] = 'Error al obtener datos de la API';
            }
        } else {
            $data['error'] = 'Por favor, ingresa un DNI válido.';
        }

        $data['nombre'] = $this->session->userdata('nombre'); // Puedes obtener el nombre del usuario desde la sesión o base de datos
        $data['rol'] = $this->session->userdata('rol'); // Puedes obtener el rol del usuario desde la sesión o base de datos

        $this->load->view('dashboard_view', $data);
    }
}