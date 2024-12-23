<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsuarioModel extends CI_Model {
    public function validar_usuario($nombre, $contrasena) {
        $this->db->select('u.*, r.rolname'); // Cambiar rolesname por rolename
        $this->db->from('usuarios u');
        $this->db->join('roles r', 'u.roles_idtable1 = r.idtable1');
        $this->db->where('u.nombre', $nombre);
        $this->db->where('u.contrasena', $contrasena);
        $query = $this->db->get();

        return $query->row();
    }
    public function existe_usuario($nombre) {
        $this->db->where('nombre', $nombre);
        $query = $this->db->get('usuarios');
        return $query->num_rows() > 0;
    }

    public function crear_usuario($datos) {
        $this->db->insert('usuarios', $datos);
    }

}
