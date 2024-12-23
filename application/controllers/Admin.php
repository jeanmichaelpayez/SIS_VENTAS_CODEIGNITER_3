<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Producto_model');
        $this->load->library('session');

        // Verificar si el usuario es administrador
        if ($this->session->userdata('rol') !== '1. administrador') {
            redirect('');
        }
    }

    public function productos() {
        $productos = $this->Producto_model->obtener_productos();
        $nombre = $this->session->userdata('nombre');
        $data = [
        'nombre' => $nombre,
        'rol' => $this->session->userdata('rol'),
        'productos' => $productos
        ];
        $this->load->view('dashboard_view', $data);
    }

    public function agregar_producto() {
        $nombre = $this->session->userdata('nombre');
        $data = [
        'nombre' => $nombre,
        'rol' => $this->session->userdata('rol')
        ];
if ($this->input->post()) {
        $datos = [
            'nombre' => $this->input->post('nombre'),
            'descripcion' => $this->input->post('descripcion'),
            'categoria' => $this->input->post('categoria'),
            'precio' => $this->input->post('precio'),
            'stock' => $this->input->post('stock')
        ];

        // Crear directorio si no existe
        $upload_path = './uploads/productos/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        // Configuración de carga de imagen
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE; // Nombre encriptado para evitar duplicados

        $this->load->library('upload', $config);

        if (!empty($_FILES['imagen']['name'])) {
            if ($this->upload->do_upload('imagen')) {
                $upload_data = $this->upload->data();
                $datos['imagen'] = $upload_data['file_name'];
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                redirect('admin/productos');
                return;
            }
        }

        $this->Producto_model->agregar_producto($datos);
        $this->session->set_flashdata('success', 'Producto agregado correctamente');
        redirect('admin/productos');
    }

    $this->load->view('productos_formulario',$data);
    }

    public function editar_producto($id_producto) {
        $nombre = $this->session->userdata('nombre');
        $data = [
        'nombre' => $nombre,
        'rol' => $this->session->userdata('rol')
        ];
        if ($this->input->post()) {
            $datos = [
                'nombre' => $this->input->post('nombre'),
                'descripcion' => $this->input->post('descripcion'),
                'categoria' => $this->input->post('categoria'),
                'precio' => $this->input->post('precio'),
                'stock' => $this->input->post('stock')
            ];

            $this->Producto_model->actualizar_producto($id_producto, $datos);
            redirect('admin/productos');
        }

        $data['producto'] = $this->Producto_model->obtener_producto($id_producto);
        $this->load->view('productos_formulario', $data);
    }

    public function eliminar_producto($id_producto) {
        $this->Producto_model->eliminar_producto($id_producto);
        redirect('admin/productos');
    }
}