<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Home Controller
*
* @author	Robert Coster
*/
class Home extends CI_Controller 
{
	/**
	* Constructor called on instantiation
	*
	* @access	private
	* @param	none
	* @return	none
	*/
	function __construct()
	{
		//Call parent constructor
		parent::__construct();
		
		//Load the category model
		$this->load->model(array('Category_model','Place_model'));
		
		//Load form, url, array and checkbox helpers
		$this->load->helper(array('form','url','array','checkbox'));
		
		//Load session library
		$this->load->library('session');
	}
	
	/**
	* Index function
	*
	* @access	public
	* @param	none
	* @return	none
	*/	
	public function index()
	{
		//Set categories data
		$data['categories'] = $this->Category_model->get_categories();
		
		//Set places data
		$data['places'] = $this->Place_model->get_all_places();
		
		//Set selected categories data
		$data['selected_categories'] = $this->session->userdata('selected_categories'); 

		//Set selected place data
		$data['selected_place'] = $this->session->userdata('selected_place');
			
		//Load view
		$this->load->view('home/index',$data);
	}

	/**
	* Clear function
	*
	* @access	public
	* @param	none
	* @return	none
	*/
	public function clear()
	{
		//Clear the session
		$this->session->sess_destroy();
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */