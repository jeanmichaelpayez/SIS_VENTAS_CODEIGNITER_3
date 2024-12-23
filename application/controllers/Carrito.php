<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carrito extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['Carrito_model', 'Producto_model']);
        $this->load->library('session');
        // Verificar si el usuario está logueado
        if (!$this->session->userdata('idusuarios')) {
            redirect('');
        }
    }

    public function index() {
        $usuario_id = $this->session->userdata('idusuarios');
        $nombre = $this->session->userdata('nombre');
        $rol = $this->session->userdata('rol');
        $data = [
            'nombre' => $nombre, // Pasar el nombre a la vista
            'rol' => $rol,
            'items_carrito' => $this->Carrito_model->obtener_carrito($usuario_id),
            'total' => $this->Carrito_model->calcular_total($usuario_id)
        ];
        $this->load->view('carrito', $data);
    }

    public function agregar($id_producto) {
        $usuario_id = $this->session->userdata('idusuarios');
        $this->Carrito_model->agregar_al_carrito($usuario_id, $id_producto);
        redirect('carrito');
    }

    public function eliminar($id_carrito) {
        $this->Carrito_model->eliminar_item_carrito($id_carrito);
        redirect('carrito');
    }

    public function pagar() {
        $usuario_id = $this->session->userdata('idusuarios');
        
        // Verificar si hay items en el carrito
        $items_carrito = $this->Carrito_model->obtener_carrito($usuario_id);
        if (empty($items_carrito)) {
            $this->session->set_flashdata('error', 'No hay productos en el carrito');
            redirect('carrito');
            return;
        }

        try {
            $id_pedido = $this->Carrito_model->procesar_pedido($usuario_id);
            if ($id_pedido) {
                $this->session->set_flashdata('success', 'Pedido procesado correctamente');
                redirect('pedidos/detalle/' . $id_pedido);
            } else {
                $this->session->set_flashdata('error', 'Error al procesar el pedido');
                redirect('carrito');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Error al procesar el pedido: ' . $e->getMessage());
            redirect('carrito');
        }
    }
}