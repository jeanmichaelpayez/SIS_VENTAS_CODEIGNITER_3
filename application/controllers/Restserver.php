<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Importar la librería REST_Controller
require APPPATH . 'libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Restserver extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Cargar la base de datos
        $this->load->model('Usuario_model'); // Modelo para gestionar usuarios, roles y tokens
    }

    /**
     * Endpoint: Obtener la lista de usuarios
     * Método: GET
     * URL: http://tu_dominio/restserver/usuarios
     * Autenticación: Token en el header "Authorization"
     */
    public function usuario_get($id = null) {
        // Obtener el token del encabezado Authorization
        $token = $this->input->get_request_header('Authorization');
        log_message('debug', 'Token recibido: ' . $token);
        // Verificar si el token es válido
        if ($this->Usuario_model->verificar_token($token)) {
            // Obtener la lista de usuarios con sus roles
            $usuarios = $this->Usuario_model->obtener_usuario($id);

            // Responder con la lista de usuarios
            $this->response([
                'status' => true,
                'data' => $usuarios
            ], REST_Controller::HTTP_OK);
        } else {
            // Token inválido o no proporcionado
            $this->response([
                'status' => false,
                'message' => 'Token inválido o no proporcionado'
            ], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Endpoint: Generar un token para un usuario admin
     * Método: POST
     * URL: http://tu_dominio/restserver/generar_token
     * Parámetros: idusuario (ID del usuario)
     */
    public function generar_token_post() {
        // Obtener el ID del usuario desde los datos POST
        $idusuario = $this->post('idusuario');

        // Verificar si el usuario existe y obtener sus datos
        $usuario = $this->Usuario_model->obtener_usuario($idusuario);

        // Verificar si el usuario tiene el rol de admin
        if ($usuario && $usuario['rolname'] === '1. administrador') {
            // Generar un token único
            $token = bin2hex(random_bytes(32));

            // Guardar el token en la base de datos
            $this->Usuario_model->guardar_token($idusuario, $token);

            // Responder con el token generado
            $this->response([
                'status' => true,
                'token' => $token
            ], REST_Controller::HTTP_OK);
        } else {
            // Usuario no autorizado para generar tokens
            $this->response([
                'status' => false,
                'message' => 'Usuario no autorizado para generar tokens'
            ], REST_Controller::HTTP_FORBIDDEN);
        }
    }

    /**
     * Endpoint: Endpoint de prueba (opcional)
     * Método: GET
     * URL: http://tu_dominio/restserver/index
     */
    public function index_get() {
        // Mensaje por defecto si se accede al endpoint principal
        $this->response([
            'status' => true,
            'message' => 'Bienvenido al API Restserver. Usa los endpoints /usuarios o /generar_token.'
        ], REST_Controller::HTTP_OK);
    }
}