<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Places Controller
*
* @author	Robert Coster
*/
class Places extends CI_Controller 
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
			
		//Load the places model
		$this->load->model(array('admin/Place_model'));					
						
		$this->load->library(array('session','user_agent','form_validation','pagination'));		

		$this->load->helper(array('url','form'));	

	}

	/**
	* Private callback function used to check if a place already exists with name provided
	*
	* @access	private
	* @param	string
	* @return	boolean
	*/	
	function _place_exists($name)
	{				
		//Check if the user exists with the username and password provided
		if($this->Place_model->place_exists($name) === FALSE)
		{	
			//Category exists, return true
			return TRUE;
		}
		else
		{
			//Category does not exist, set a validation message
			$this->form_validation->set_message('_place_exists','Place with that name already exists');
	
			//Return false, validation failed
			return FALSE;
		}
	
	}
	
	/**
	* Private callback function used to check if a place is available
	*
	* @access	private
	* @param	string
	* @return	boolean
	*/	
	function _place_available($name)
	{	
		//Get the id of the place from post
		$id = $this->input->post('id');
		
		//Get the entered place name from post
		$name = $this->input->post('name');	
		
		//Get the user object
		$place = $this->Place_model->get_place($id);
		
		//If place exists
		if ($place)
		{
			//If place name is not the same as stored place name
			if ($place->name != $name)
			{
				//Name is not the same as the stored name, it is being changed
				if ($this->Place_model->place_exists($name) === FALSE)
				{
					//Name can be changed, new name is available return true
					return TRUE;
				}
				else
				{
					//Name cannot be changed, set validation message
					$this->form_validation->set_message('_place_available','The place name chosen is already in use');

					//Return false, validation failed
					return FALSE;						
				}
			}
			else
			{
				//Username is not being changed
				return TRUE;
			}
		}
		else
		{
			//Cannot find user with ID provided, set validation message
			$this->form_validation->set_message('_place_available','Cannot find place with the information provided');
		
			//Return false, validation failed
			return FALSE;
		}	
	
	}
	
	/**
	* Index function called by default
	*
	* @access	public
	* @param	string
	* @return	boolean
	*/	
	public function index()
	{
		//Check if the user id session value exists	
		if ($this->session->userdata('id'))
		{	
			//Setup the pagination			
			$config['base_url'] = '/index.php/admin/places/index/';
			$config['total_rows'] = $this->Place_model->get_total_places();
			$config['per_page'] = 10;
			$config['uri_segment'] = 4;
			$config['full_tag_open'] = '<ul>';
			$config['full_tag_close'] = '</ul>';
			$config['first_tag_open'] = '<li>';
			$config['first_link'] = '&laquo;';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = '&raquo;';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = '&gt;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] = '&lt;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li>';
			$config['cur_tag_close'] = '</li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
	
			//Initialize the pagination	
			$this->pagination->initialize($config);	

			//Set the places in the data variable to be passed to the view					
			$data['places'] = $this->Place_model->get_places_paging($config['per_page'],$this->uri->segment(4));		
		
			//Load the view
			$this->load->view('admin/places/index',$data);
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}
	}
	
	/**
	* Action function
	*
	* @access	public
	* @param	none
	* @return	none
	*/		
	public function action()
	{
		//Switch based on the user selection	
		switch($this->input->post('action'))
		{
			//If the user has chosen add		
			case 'add':
			{
				//Redirect to the add place page			
				redirect('/admin/places/add');
				break;
			}
			//If the user has chosen activate			
			case 'activate':
			{		
				//For each field in the post array								
				foreach($this->input->post() as $key => $value)
				{	
					//If the key of the post field contains the phrase place											
					if (strpos($key,'place') !== FALSE)
					{
						//Set the place to active					
						$this->Place_model->toggle_status_active($value);
					}
				}

				//If the user came here from another page						
				if ($this->agent->is_referral())
				{
					//Redirect to the calling page				
					redirect($this->agent->referrer());
				}
				else
				{
					//Redirect to the places page				
					redirect('/admin/places');
				}				
			
				break;
			}
			//If the user has chosen deactivate			
			case 'deactivate':
			{
				//For each field in the post array			
				foreach($this->input->post() as $key => $value)
				{					
					//If the key of the post field contains the phrase place								
					if (strpos($key,'place') !== FALSE)
					{
						//Set the category to inactive					
						$this->Place_model->toggle_status_inactive($value);
					}
				}

				//If the user came here from another page								
				if ($this->agent->is_referral())
				{
					//Redirect to the calling page				
					redirect($this->agent->referrer());
				}
				else
				{
					//Redirect to the places page				
					redirect('/admin/places');
				}	
							
				break;
			}
		}
	}
	
	/**
	* Add place
	*
	* @access	public
	* @param	none
	* @return	none
	*/	
	public function add()
	{
		//Check if the user id session value exists	
		if ($this->session->userdata('id'))
		{		
			//Set the validation rules for the place name,latitude,longitude,default and status
			$this->form_validation->set_rules('name', 'Name', 'required|max_length[100]|callback__place_exists');

			$this->form_validation->set_rules('latitude', 'Latitude', 'required');		

			$this->form_validation->set_rules('longitude', 'Longitude', 'required');		

			$this->form_validation->set_rules('default', 'Default', 'required');		
			
			$this->form_validation->set_rules('status', 'Status', 'required');			
		
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{
				//Create array representing place			
				$place = array(
					'name'=>$this->input->post('name'),
					'latitude'=>$this->input->post('latitude'),
					'longitude'=>$this->input->post('longitude'),
					'default'=>$this->input->post('default'),					
					'status'=>$this->input->post('status'),
				);

				//Create place and return new id				
				$id = $this->Place_model->create_place($place);
				
				//If the id value is greater than zero (has been set)				
				if ($id > 0)
				{
					//If the user has selected this is the default place
					if ($this->input->post('default') === '1')
					{
						//Set all default values to zero and set this one to 1
						$this->Place_model->toggle_default($id);
					}

					//Redirect to the thankyou page					
					redirect('/admin/places/thanks/1');
				}
			}
		
			//Load the view
			$this->load->view('admin/places/add');
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}				
	}	
	
	/**
	* Edit category
	*
	* @access	public
	* @param	none
	* @return	none
	*/		
	public function edit($id)
	{
		//Check if the user id session value exists	
		if ($this->session->userdata('id'))
		{
			//Assign place to the data array			
			$data['place'] = $this->Place_model->get_place($id);
	
			//Set the validation rules for the place name,latitude,longitude,default and status
			$this->form_validation->set_rules('name', 'Name', 'required|max_length[100]|callback__place_available');

			$this->form_validation->set_rules('latitude', 'Latitude', 'required');		

			$this->form_validation->set_rules('longitude', 'Longitude', 'required');		

			$this->form_validation->set_rules('default', 'Default', 'required');		
			
			$this->form_validation->set_rules('status', 'Status', 'required');		
	
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{
				//Set the place values in the data array			
				$data['place']->name = $this->input->post('name');
				$data['place']->latitude = $this->input->post('latitude');
				$data['place']->longitude = $this->input->post('longitude');
				$data['place']->default = $this->input->post('default');
				$data['place']->status = $this->input->post('status');
				
				//Update the place in the database				
				if ($this->Place_model->update_place($data['place']))
				{
					//If the user has selected this is the default place				
					if ($this->input->post('default') === '1')
					{
						//Set all default values to zero and set this one to 1					
						$this->Place_model->toggle_default($id);
					}
					
					//Redirect to the thankyou page										
					redirect('/admin/places/thanks/2');
				}
				
			}	
	
			//Load the view
			$this->load->view('admin/places/edit',$data);
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}				
	}
	
	/**
	* Toggle Status
	*
	* @access	public
	* @param	none
	* @return	none
	*/		
	public function status($id)
	{
		//Check if the user id session value exists	
		if ($this->session->userdata('id'))
		{	
			//Change the status of the place		
			$this->Place_model->toggle_status($id);
			
			//If the visitor has come here from another page			
			if ($this->agent->is_referral())
			{
				//Redirect to the referring page			
				redirect($this->agent->referrer());
			}
			else
			{
				//Redirect to places page			
				redirect('/admin/places');
			}
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}
	}	
	
	/**
	* Display thanks
	*
	* @access	public
	* @param	none
	* @return	none
	*/		
	public function thanks($id)
	{
		//Change thanks message based on id	
		switch($id)
		{
			case 1:
			{
				$data['message'] = 'Your place has been added to the database';
				break;
			}
			case 2:
			{
				$data['message'] = 'The selected place has been edited in the database';
				break;			
			}
			case 3:
			{
				$data['message'] = 'The place selected has been deleted from the database';
				break;
			}
		}
		
		$this->load->view('admin/places/thanks',$data);

	}	
	
	/**
	* Delete category
	*
	* @access	public
	* @param	none
	* @return	none
	*/	
	public function delete($id)
	{
		//Check if the user id session value exists	
		if ($this->session->userdata('id'))
		{
			//Assign place to data array		
			$data['place'] = $this->Place_model->get_place($id);	
			
			//Set the validation rules for the place id
			$this->form_validation->set_rules('id', 'ID', 'required');			
			
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{
				//Delete the place by id			
				if ($this->Place_model->delete_place($this->input->post('id')))
				{
					//Redirect to thanks page
					redirect('/admin/places/thanks/3');
				}
			}			
			
			//Load the view
			$this->load->view('admin/places/delete',$data);
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}
	}
			
}

/* End of file places.php */
/* Location: ./application/controllers/admin/places.php */