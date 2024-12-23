<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_model extends CI_Model {

    // Obtener usuarios con sus roles
    public function obtener_usuarios() {
        $this->db->select('usuarios.idusuarios, usuarios.nombre, roles.rolname');
        $this->db->from('usuarios');
        $this->db->join('roles', 'usuarios.roles_idtable1 = roles.idtable1');
        return $this->db->get()->result_array();
    }

    // Obtener un usuario por ID
    public function obtener_usuario($idusuario) {
        $this->db->select('usuarios.idusuarios, usuarios.nombre, roles.rolname');
        $this->db->from('usuarios');
        $this->db->join('roles', 'usuarios.roles_idtable1 = roles.idtable1');
        $this->db->where('usuarios.idusuarios', $idusuario);
        return $this->db->get()->row_array();
    }

    // Guardar token
    public function guardar_token($idusuario, $token) {
        $data = [
            'idusuario' => $idusuario,
            'token' => $token
        ];
        return $this->db->insert('tokens', $data);
    }

    // Verificar token
    public function verificar_token($token) {
        $this->db->select('idtoken');
        $this->db->from('tokens');
        $this->db->where('token', $token);
        return $this->db->get()->num_rows() > 0;
    }
}