<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Place Controller
*
* @author	Robert Coster
*/
class Place extends CI_Controller 
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
		
		//Load url helper		
		$this->load->helper(array('url'));
		
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
		//If the request method is post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{	
			//TODO - Does it have to be this or can it be...
			//$this->session->set_userdata('selected_place',$this->input->post('place'));
			$this->session->set_userdata(array('selected_place'=>$this->input->post('place')));
		}
		
		redirect('/');		
	}
}

/* End of file place.php */
/* Location: ./application/controllers/place.php */	