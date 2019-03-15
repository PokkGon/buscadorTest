<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modelo RESTful
|--------------------------------------------------------------------------
|
| Esta es la plantilla de Ncai SpA para un modelo RESTful en Codeigniter.
| Esta plantilla contiene los métodos por defecto para realizar consultas a
| la base de datos. Utiliza la convención CRUD para hacerlo: create, read,
| update y delete.
|
|
*/

class Search extends CI_Model {

    ##########################
    # CONSTRUCTOR DEL MODELO #
    ##########################

    public function __construct() {
        parent::__construct();

    }
    
    // Crea una entrada en la base de datos
    public function create($table = 'descuentos', array $data) {
        $query = $this->db->insert($table, $data);
        return $query;
    }

    // Obtiene una o varias entradas desde la base de datos
    public function read($table = 'descuentos', array $data = NULL, array $join = NULL, $select = NULL, $array = false, $order = NULL, $limit = NULL, $search = NULL, $group = NULL) {
        $query;
        if($select){
            $this->db->select($select);
        }
		if($limit){
			$this->db->limit($limit);
		}
		if($group){
			$this->db->group_by($group);
		}
		if($search){
			$this->db->where("descuentos.titulo LIKE ('%".$search."%')", NULL, FALSE);
		}
        if ($join){
           foreach ($join as $jointable => $joinid) {
                $this->db->join($jointable, $jointable.'.id = '.$table.'.'.$joinid); 
            } 
        }
        if($data){
            foreach($data as $key => $where){
                $this->db->where($key,$where);
            }
        }
        if($order){
            $this->db->order_by($order, 'DESC');
        }
        $query = $this->db->get($table);
        if(!$query){
            return false; 
        } elseif ($query->num_rows() == 0) {
            if ($array) {
                return array();
            } else {
                return false;
            }
        } elseif ($query->num_rows() == 1 ) {
            if ($array) {
                return $query->result();
            } else {
                return $query->row();
            }
        } else {
            return $query->result();
        }
    }
	
}