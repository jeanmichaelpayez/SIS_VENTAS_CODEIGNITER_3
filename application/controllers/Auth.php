<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('UsuarioModel');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function login() {
        if ($this->input->method() === 'post') {
            $nombre = $this->input->post('nombre');
            $contrasena = $this->input->post('contrasena');

            $usuario = $this->UsuarioModel->validar_usuario($nombre, $contrasena);

            if ($usuario) {
                $this->session->set_userdata([
                    'idusuarios' => $usuario->idusuarios,
                    'nombre' => $usuario->nombre,
                    'rol' => $usuario->rolname
                ]);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Credenciales incorrectas.');
                redirect('auth/login');
            }
        }

        $this->load->view('login_view');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
    public function register() {
        if ($this->input->method() === 'post') {
            $this->load->model('UsuarioModel');

            $nombre = $this->input->post('nombre');
            $contrasena = $this->input->post('contrasena');

            // Validación básica
            if (empty($nombre) || empty($contrasena)) {
                $this->session->set_flashdata('error', 'Todos los campos son obligatorios.');
                redirect('auth/register');
            }

            // Verificar si el usuario ya existe
            if ($this->UsuarioModel->existe_usuario($nombre)) {
                $this->session->set_flashdata('error', 'El nombre de usuario ya está en uso.');
                redirect('auth/register');
            }

            // Crear el nuevo usuario
            $datos = [
                'nombre' => $nombre,
                'contrasena' => $contrasena,
                'roles_idtable1' => 2 // Rol normal
            ];
            $this->UsuarioModel->crear_usuario($datos);

            $this->session->set_flashdata('success', 'Usuario registrado exitosamente. Ahora puedes iniciar sesión.');
            redirect('auth/login');
        }

        $this->load->view('register_view');
    }

}
