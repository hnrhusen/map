<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Dashboard Controller
*
* @author	Robert Coster
*/
class Dashboard extends CI_Controller 
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
				
		//Load the session library		
		$this->load->library(array('session'));		

		//Load the url helper
		$this->load->helper(array('url'));

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
		//Check if the user id session value exists	
		if ($this->session->userdata('id'))
		{		
			//Load the view
			$this->load->view('admin/dashboard/index');
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}	
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/admin/dashboard.php */