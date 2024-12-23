<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrito_model extends CI_Model {
    public function obtener_carrito($usuario_id) {
        $this->db->select('c.*, p.nombre, p.precio');
        $this->db->from('carrito c');
        $this->db->join('productos p', 'c.id_producto = p.id_producto');
        $this->db->where('c.idusuarios', $usuario_id);
        return $this->db->get()->result();
    }

    public function calcular_total($usuario_id) {
        $this->db->select('SUM(p.precio * c.cantidad) as total');
        $this->db->from('carrito c');
        $this->db->join('productos p', 'c.id_producto = p.id_producto');
        $this->db->where('c.idusuarios', $usuario_id);
        return $this->db->get()->row()->total;
    }

    public function agregar_al_carrito($usuario_id, $id_producto) {
        // Verificar si el producto ya está en el carrito
        $existe = $this->db->get_where('carrito', [
            'idusuarios' => $usuario_id, 
            'id_producto' => $id_producto
        ])->row();

        if ($existe) {
            // Incrementar cantidad
            $this->db->set('cantidad', 'cantidad + 1', FALSE);
            $this->db->where(['idusuarios' => $usuario_id, 'id_producto' => $id_producto]);
            $this->db->update('carrito');
        } else {
            // Agregar nuevo item
            $this->db->insert('carrito', [
                'idusuarios' => $usuario_id,
                'id_producto' => $id_producto,
                'cantidad' => 1
            ]);
        }
    }

    public function eliminar_item_carrito($id_carrito) {
        $this->db->delete('carrito', ['id_carrito' => $id_carrito]);
    }

    public function procesar_pedido($usuario_id) {
        // Iniciar transacción
        $this->db->trans_start();

        // Obtener items del carrito
        $carrito = $this->obtener_carrito($usuario_id);

        // Crear pedido
        $total_pedido = $this->calcular_total($usuario_id);
        $pedido = [
            'idusuarios' => $usuario_id,
            'total' => $total_pedido
        ];
        $this->db->insert('pedidos', $pedido);
        $id_pedido = $this->db->insert_id();

        // Guardar detalles del pedido
        foreach ($carrito as $item) {
            $detalle = [
                'id_pedido' => $id_pedido,
                'id_producto' => $item->id_producto,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio
            ];
            $this->db->insert('detalle_pedidos', $detalle);

            // Actualizar stock
            $this->db->set('stock', 'stock - ' . $item->cantidad, FALSE);
            $this->db->where('id_producto', $item->id_producto);
            $this->db->update('productos');
        }

        // Limpiar carrito
        $this->db->delete('carrito', ['idusuarios' => $usuario_id]);

        // Finalizar transacción
        $this->db->trans_complete();

        return $id_pedido;
    }
}