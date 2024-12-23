<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mensaje_model extends CI_Model {
    public function obtener_mensajes($emisor_id, $receptor_id) {
        $this->db->where("(emisor_id = $emisor_id AND receptor_id = $receptor_id) OR (emisor_id = $receptor_id AND receptor_id = $emisor_id)");
        $this->db->order_by('fecha_envio', 'ASC');
        return $this->db->get('mensajes')->result();
    }

    public function obtener_conversaciones($usuario_id) {
        // Consulta principal
        $this->db->select('u.idusuarios, u.nombre, MAX(m.mensaje) as ultimo_mensaje, MAX(m.fecha_envio) as ultimo_fecha_envio');
        $this->db->from('usuarios u');
        $this->db->join('mensajes m', '(m.emisor_id = u.idusuarios OR m.receptor_id = u.idusuarios)', 'left');
        $this->db->where("EXISTS (
            SELECT 1 FROM mensajes 
            WHERE (emisor_id = $usuario_id AND receptor_id = u.idusuarios)
            OR (emisor_id = u.idusuarios AND receptor_id = $usuario_id)
        )");
        $this->db->where('u.idusuarios !=', $usuario_id);
        $this->db->group_by('u.idusuarios');
        $this->db->order_by('ultimo_fecha_envio', 'DESC');
        
        $usuarios = $this->db->get()->result();
        
        // Obtener mensajes no leídos para cada conversación
        foreach($usuarios as $usuario) {
            $usuario->mensajes_no_leidos = $this->contar_mensajes_no_leidos($usuario_id, $usuario->idusuarios);
        }
        
        return $usuarios;
    }

    public function guardar_mensaje($datos) {
        $this->db->insert('mensajes', $datos);
        return $this->db->insert_id();
    }
    public function contar_mensajes_no_leidos($usuario_id, $emisor_id) {
    return $this->db->where([
        'receptor_id' => $usuario_id,
        'emisor_id' => $emisor_id,
        'leido' => 0
    ])->count_all_results('mensajes');
}
}