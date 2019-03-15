<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buscador extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
        parent::__construct();
        /* Cargar Modelo */
        $this->load->model('Search');
    }
	 
	public function index()
	{
		$this->load->view('buscador');
	}
	
	public function search()
	{
		$keyword = $this->input->post('keyword');
		$json_data = $this->Search->read('descuentos', NULL, NULL, NULL, true, NULL, 50, $keyword);
		foreach($json_data as $busqueda){
			$data['id_descuento'] = $busqueda->id;
			$data['keyword'] = $keyword;
			$this->Search->create('busquedas', $data);			
		};
		echo json_encode($json_data);
	}
	
	public function stats()
	{
		$data['busquedas'] = $this->Search->read('busquedas', NULL, ['descuentos' => 'id_descuento'], 'descuentos.titulo, descuentos.id, count(busquedas.id_descuento) as count_desc', true, 'count_desc', 20, NULL, 'descuentos.titulo, descuentos.id');
		foreach($data['busquedas'] as $key=>$busqueda){
			$id = $busqueda->id;
			$resultados = $this->Search->read('busquedas', ['id_descuento' => $id], NULL, 'busquedas.keyword, count(busquedas.keyword) as count_word', true, 'count_word', 5, NULL, 'busquedas.keyword');
			$resultados_string = '';
			foreach($resultados as $result){
				$resultados_string = $resultados_string.' '.$result->keyword.',';
			}
			$data['busquedas'][$key]->busquedas = rtrim($resultados_string,",");
		}
		$this->load->view('stats', $data);
	}
}
