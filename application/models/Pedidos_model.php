<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos_model extends CI_Model {
    public function obtener_pedidos_usuario($usuario_id) {
        return $this->db->get_where('pedidos', ['idusuarios' => $usuario_id])->result();
    }

    public function obtener_pedido($id_pedido, $usuario_id) {
        return $this->db->get_where('pedidos', [
            'id_pedido' => $id_pedido,
            'idusuarios' => $usuario_id
        ])->row();
    }

    public function obtener_detalles_pedido($id_pedido) {
        $this->db->select('d.*, p.nombre');
        $this->db->from('detalle_pedidos d');
        $this->db->join('productos p', 'd.id_producto = p.id_producto');
        $this->db->where('d.id_pedido', $id_pedido);
        return $this->db->get()->result();
    }
}
