<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biblioteca_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function insert_usuario($nombre, $correo) {
        $data = [
            'nombre' => $nombre,
            'correo' => $correo,
            'estado' => 1
        ];
        return $this->db->insert('usuarios', $data) ? $this->db->insert_id() : false;
    }

    public function get_usuarios() {
        return $this->db->get('usuarios')->result();
    }

    public function update_usuario_estado($id, $estado) {
        $this->db->where('id', $id);
        return $this->db->update('usuarios', ['estado' => $estado]);
    }

    public function insertar_libro($titulo, $autor) {
        $data = [
            'titulo' => $titulo,
            'autor' => $autor,
            'estado' => 1
        ];
        if ($this->db->insert('libros', $data)) {
            return $this->db->insert_id();
        }
        return false; 
    }    

    public function get_libros() {
        return $this->db->get('libros')->result();
    }

    public function update_libro_estado($id, $estado) {
        $this->db->where('id', $id);
        return $this->db->update('libros', ['estado' => $estado]);
    }
    
    public function insertar_prestamo($data) {
        $this->db->insert('prestamos', $data);
        return $this->db->insert_id(); 
    }
    
    public function get_prestamos() {
        $this->db->select('prestamos.*, usuarios.nombre AS nombre_usuario, libros.titulo AS titulo_libro');
        $this->db->from('prestamos');
        $this->db->join('usuarios', 'prestamos.usuario_id = usuarios.id');
        $this->db->join('libros', 'prestamos.libro_id = libros.id');
        $query = $this->db->get();
        return $query->result(); 
    }
    
    public function get_usuario_by_id($usuario_id) {
        return $this->db->get_where('usuarios', array('id' => $usuario_id))->row();
    }
    
    public function get_libro_by_id($libro_id) {
        return $this->db->get_where('libros', array('id' => $libro_id))->row();
    }
    
    public function finalizar_prestamo($prestamo_id) {
        $this->db->where('id', $prestamo_id);
        return $this->db->delete('prestamos'); 
    }
    
    public function cambiarEstadoUsuario($id, $estado) {
        $this->db->where('id', $id);
        return $this->db->update('usuarios', ['estado' => $estado]); 
    }
    
    public function validar_usuario($correo, $password) {
        $this->db->where('correo', $correo);
        $usuario = $this->db->get('usuarios')->row();
        
        if ($usuario && password_verify($password, $usuario->password)) {
            return $usuario; 
        }
        return false; 
    }
     public function obtenerTareas()
{
    $this->db->select('id, libro_titulo, '); 
    $query = $this->db->get('tu_tabla');
    return $query->result();
}
public function devolverPrestamo($idPrestamo) {
    log_message('debug', 'Intentando devolver el préstamo con ID: ' . $idPrestamo);

    $this->db->set('estado', 0); 
    $this->db->where('id', $idPrestamo);
    $resultado = $this->db->update('prestamos');

    if (!$resultado) {
        log_message('error', 'Error al devolver préstamo: ' . $this->db->last_query());
    }

    return $resultado; 
}
public function insertar($data) {
    $this->db->insert('contactos', $data);
    return $this->db->insert_id(); 
}


}
