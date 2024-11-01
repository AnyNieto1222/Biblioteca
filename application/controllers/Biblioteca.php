<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Biblioteca extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Biblioteca_model');
        $this->load->helper('url'); 
        $this->load->library('session');
    }

     public function index() {
        $data['usuarios'] = $this->Biblioteca_model->get_usuarios();
        $data['libros'] = $this->Biblioteca_model->get_libros();
        $data['prestamos'] = $this->Biblioteca_model->get_prestamos();
        $this->load->view('tareas_view', $data);
     }

 /*Tood lo referente con el usuario aq*/
 public function crear_usuario() {
    $nombre = $this->input->post('nombre');
    $correo = $this->input->post('correo');
    if (empty($nombre) || empty($correo)) {
        echo json_encode(['status' => 'error', 'message' => 'Campos vacíos']);
        return;
    }
    $usuario_id = $this->Biblioteca_model->insert_usuario($nombre, $correo);
    echo json_encode(['status' => 'success', 'data' => ['id' => $usuario_id, 'nombre' => $nombre, 'correo' => $correo]]);
}
      
    public function getUsuario() {
        $id = $this->input->get('id');
        $usuario = $this->Biblioteca_model->getUsuarioById($id);
        echo json_encode($usuario);
    }
  
    public function guardarUsuario() {
        $nombre = $this->input->post('nombre');
        $correo = $this->input->post('correo');
        if (empty($nombre) || empty($correo)) {
            echo json_encode(['status' => 'error', 'message' => 'Campos vacíos']);
            return;
        }        
        $this->Biblioteca_model->insert_usuario($nombre, $correo);
        echo json_encode(['success' => true]);
    }

    public function registrar_usuario() {
        $nombre = $this->input->post('nombre');
        $correo = $this->input->post('correo');
        $password = $this->input->post('password');
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $data = array(
            'nombre' => $nombre,
            'correo' => $correo,
            'password' => $hashed_password
        );
        if ($this->Biblioteca_model->insert_usuario($data)) {
            $this->session->set_flashdata('success', 'Usuario registrado con éxito.');
            redirect('Biblioteca/login_view'); 
        } else {
            $this->session->set_flashdata('error', 'Error al registrar el usuario.');
            redirect('Biblioteca/login_view'); 
        }
    }

    public function inactivar_usuario() {
    $id = $this->input->post('id');
    $resultado = $this->Biblioteca_model->cambiarEstadoUsuario($id, 0); 
    echo json_encode(['status' => $resultado ? 'success' : 'error', 'id' => $id]); 
}

public function activar_usuario() {
    $id = $this->input->post('id');
    $resultado = $this->Biblioteca_model->cambiarEstadoUsuario($id, 1); 
    echo json_encode(['status' => $resultado ? 'success' : 'error', 'id' => $id]); 
}

    public function login_view() {   
        $this->load->view('login_view');
}

/*Aqui inicia lo de los  liibros*/
    public function crear_libro() {
        $titulo = $this->input->post('titulo');
        $autor = $this->input->post('autor');

        if (empty($titulo) || empty($autor)) {
            echo json_encode(['status' => 'error', 'message' => 'Campos vacíos']);
            return;
        }
        $this->Biblioteca_model->insertar_libro($titulo, $autor);
        echo json_encode(['status' => 'success']);
    }

/*Inicio de los prestamos */
    public function crear_prestamo() {
        $usuario_id = $this->input->post('usuario');
        $libro_id = $this->input->post('libro');
        if (empty($usuario_id) || empty($libro_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Campos vacíos']);
            return;
        }
        $data = [
            'usuario_id' => $usuario_id,
            'libro_id' => $libro_id,
            'fecha_prestamo' => date('Y-m-d H:i:s'), 
            'estado' => 1 
        ];
        $this->Biblioteca_model->insertar_prestamo($data);
        echo json_encode(['status' => 'success']);
    }
    
   public function cambiarEstado() {
    $id = $this->input->post('id');
    $estado = $this->input->post('estado') == '1' ? 0 : 1; 
    $this->Biblioteca_model->cambiarEstadoUsuario($id, $estado);
    echo json_encode(['estado' => $estado]); 
}

    public function finalizar_prestamo() {
        $prestamo_id = $this->input->post('id');
        $resultado = $this->Biblioteca_model->finalizar_prestamo($prestamo_id);
        if ($resultado) {
            echo json_encode(['status' => 'success', 'message' => 'Préstamo finalizado correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al finalizar el préstamo.']);
        }
    }
    public function devolver_prestamo() {
        $idPrestamo = $this->input->post('id');
        
        log_message('debug', 'ID del préstamo recibido: ' . $idPrestamo);
    
        if ($this->Biblioteca_model->devolverPrestamo($idPrestamo)) {
            echo json_encode(['status' => 'success', 'message' => 'Préstamo devuelto correctamente.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No se pudo devolver el préstamo']);
        }
    }
    

    
/**Validaciones para la entrada y salida login y logout */
public function validate_login() {
    $correo = $this->input->post('correo');
    $password = $this->input->post('password');
    $usuario = $this->Biblioteca_model->validar_usuario($correo, $password);
    
    if ($usuario) {
        $this->session->set_userdata('usuario_id', $usuario->id);
        $this->session->set_flashdata('success', 'Inicio de sesión exitoso.');
        redirect('Biblioteca/tareas_view');
    } else {
        $this->session->set_flashdata('error', 'Correo o contraseña incorrectos.');
        redirect('Biblioteca/login_view');
    }
}


    public function login() {
    $nombre = $this->input->post('nombre');
    $correo = $this->input->post('correo');
    $password = $this->input->post('password');
    if ($this->Biblioteca_model->validar_usuario($nombre, $correo, $password)) {
        $this->session->set_userdata('usuario', $nombre);
        redirect('Biblioteca/tareas_view'); 
    } else {
        $this->session->set_flashdata('error', 'Nombre, correo o contraseña incorrectos');
        redirect('Biblioteca/login_view');
        echo $this->db->last_query();
exit;
    }
}

public function tareas_view() {
    $usuarios = $this->Biblioteca_model->get_usuarios(); 
    $prestamos = $this->Biblioteca_model->get_prestamos();
    $libros = $this->Biblioteca_model->get_libros();
    $this->load->view('tareas_view', [
        'libros' => $this->Biblioteca_model->get_libros(),  
        'usuarios' => $this->Biblioteca_model->get_usuarios(),  
        'prestamos' => $prestamos
    ]);

}
}