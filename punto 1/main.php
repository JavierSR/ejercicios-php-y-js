<?php

class programmersController {
    public $firstName;
    public $lastName ;
    public $dni;
    public $email;
    public $languages;
    private $connection;

    function __construct() {
        if($this->validateData()) {
            $this->connectDatabase();
            $this->insertProgrammer();
        }
        else {
            $this->sendResponse(array(
                'result' => false,
                'message' => 'Debe enviar nombre, apellidos, cédula, correo y lenguajes'
            ));
        }
    }

    public function sendResponse($args) {
        echo json_encode(
            Array(
                'result'  => $args['result'],
                'data'    => isset($args['data']) ? $args['data'] : array(),
                'message' => isset($args['message']) ? $args['message'] : ''
            )
        );
        exit();
    }

    public function validateData() {
        if(!(isset($_POST['firstName']) && isset($_POST['firstName']) && isset($_POST['firstName']) && isset($_POST['firstName']) && isset($_POST['firstName']))) {
            return false;
        }

        $this->firstName = $_POST['firstName'];
        $this->lastName  = $_POST['lastName'];
        $this->dni       = $_POST['dni'];
        $this->email     = $_POST['email'];
        $this->languages = $_POST['languages'];

        return $this->firstName && $this->lastName && $this->dni && $this->email && $this->languages;
    }

    private function connectDatabase() {
        $this->connection = new mysqli('localhost', 'root', '', 'oscar_sandoval');

        if ($this->connection->connect_error) {
            $this->sendResponse(array(
                'result' => false,
                'message' => 'Error al conectarse a la base de datos ' . $this->connection->connect_error
            ));
        }
    }

    public function userIsRepeated() {
        //Soy consciente de que las consultas son inseguras ante una inyeccion sql al no ser prepared staments pero 
        //lo hago así para no alargar y llenar de funciones la prueba
        $sql = "SELECT * FROM programador WHERE correo = '{$this->email}' LIMIT 1";
        $result = $this->connection->query($sql);
        return (Bool) $result->num_rows;
    }


    public function insertProgrammer() {
        if($this->userIsRepeated()) {
            $this->sendResponse(array(
                'result' => false,
                'message' => 'El usuario ya ha sido creado con el correo ' . $this->email
            ));
        }


        $sql = "INSERT INTO programador (nombre, apellido, cedula, correo, lenguajes, fecha_creacion) VALUES (
                '{$this->firstName}',
                '{$this->lastName}',
                '{$this->dni}',
                '{$this->email}',
                '{$this->languages}',
                NOW()
            )";

        
        $result = $this->connection->query($sql);
        $this->sendResponse(array(
            'result'  => (Bool) $result,
            'message' => $result ? 'Registro guardado' : 'No se pudo guardar el formulario',
            'data'    => array(
                'programmersCount' => $this->connection->insert_id
            )
        ));
    }
}

$controller = new programmersController();

