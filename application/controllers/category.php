<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Category Controller
*
* @author	Robert Coster
*/
class Category extends CI_Controller 
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
		//Call the parent constructor
		parent::__construct();
				
		//Load url helper
		$this->load->helper(array('url'));
		
		//Load session library
		$this->load->library('session');		
	}
	
	/**
	* Index function
	*
	* @access	private
	* @param	none
	* @return	none
	*/	
	public function index()
	{	
		//If the request method is post
		if ($this->input->server('REQUEST_METHOD') === 'POST')
		{
			//If the post is an array				
			if (is_array($this->input->post()))
			{	
				//TODO - This needs checked, does it need an array or can it be...
				//$this->session->set_userdata('selected_categories',$this->input->post());
				$this->session->set_userdata(array('selected_categories'=>$this->input->post()));
			}
			else
			{
				$this->session->unset_userdata('selected_categories');
			}		
				
			redirect('/');
		}
	}
}

/* End of file category.php */
/* Location: ./application/controllers/category.php */	