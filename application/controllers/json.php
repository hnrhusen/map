<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Json Controller
*
* @author	Robert Coster
*/
class Json extends CI_Controller 
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
		//Calls parent constructor
		parent::__construct();
		
		//Load the point model
		$this->load->model(array('Point_model','Place_model'));	
		
		//Load form helper
		$this->load->helper(array('form'));
		
		//Load session library helper
		$this->load->library(array('session'));	
	}

	/**
	* Points as Json
	*
	* @access	public
	* @param	none
	* @return	none
	*/	
	public function points()
	{	
		//Create location array
		$location = array('swlat'=>$this->input->post('swlat'),'swlng'=>$this->input->post('swlng'),'nelat'=>$this->input->post('nelat'),'nelng' => $this->input->post('nelng'));
		
		//Placeholder for real categories list
		$categories = $this->session->userdata('selected_categories');
			
		//Get the results array		
		$results = array('location'=>$location,'points'=> $this->Point_model->get_points($location,$categories));
		
		//Output results json
		echo json_encode($results);
	}
	
	/**
	* Place function
	*
	* @access	private
	* @param	none
	* @return	none
	*/	
	public function place()
	{
		//If the session contains a selected place
		if ($this->session->userdata('selected_place'))
		{
			//Get the place
			$place = $this->Place_model->get_place($this->session->userdata('selected_place'));
		
			//Set the location array
			$location = array('latitude'=>$place->latitude,'longitude'=>$place->longitude);
		}
		else
		{
			//Get the default location
			$place = $this->Place_model->get_default_place();		
		
			//Set the location array
			$location = array('latitude'=>$place->latitude,'longitude'=>$place->longitude);
		}
		
		//Output result as json
		echo json_encode($location);
		
	}	
}

/* End of file json.php */
/* Location: ./application/controllers/json.php */