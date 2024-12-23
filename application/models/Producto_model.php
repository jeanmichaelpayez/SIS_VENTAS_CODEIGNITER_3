<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Producto_model extends CI_Model {
    public function obtener_productos() {
        return $this->db->get('productos')->result();
    }

    public function obtener_producto($id_producto) {
        return $this->db->get_where('productos', ['id_producto' => $id_producto])->row();
    }

    public function agregar_producto($datos) {
        return $this->db->insert('productos', $datos);
    }

    public function actualizar_producto($id_producto, $datos) {
        $this->db->where('id_producto', $id_producto);
        return $this->db->update('productos', $datos);
    }

    public function eliminar_producto($id_producto) {
        return $this->db->delete('productos', ['id_producto' => $id_producto]);
    }
}