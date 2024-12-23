<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Middleware {
    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
    }

    public function check_login() {
        if (!$this->ci->session->userdata('idusuarios')) {
            redirect('auth/login');
        }
    }

    public function check_role($role) {
        $this->check_login();
        if ($this->ci->session->userdata('rol') !== $role) {
            show_error('No tienes permiso para acceder a esta página.', 403, 'Acceso Denegado');
        }
    }
}
