<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Points Controller
*
* @author	Robert Coster
*/
class Points extends CI_Controller 
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
			
		//Load the points model
		$this->load->model(array('admin/Point_model','admin/Category_model','admin/Point_category_model'));								
		//Load the session,user agent,form validation and pagination libraries
		$this->load->library(array('session','user_agent','form_validation','pagination'));		

		//Load the url, form and category helper
		$this->load->helper(array('url','form','category'));	
	}

	/**
	* Index function called by default
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
			//Setup the pagination					
			$config['base_url'] = '/index.php/admin/points/index/';
			$config['total_rows'] = $this->Point_model->get_total_points();
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
		
			//Set the points in the data variable to be passed to the view		
			$data['points'] = $this->Point_model->get_points_paging($config['per_page'],$this->uri->segment(4));
		
			//Load the view
			$this->load->view('admin/points/index',$data);
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
				//Redirect to the add point page						
				redirect('/admin/points/add');
				break;
			}
			//If the user has chosen activate						
			case 'activate':
			{		
				//For each field in the post array													
				foreach($this->input->post() as $key => $value)
				{	
					//If the key of the post field contains the phrase point											
					if (strpos($key,'point') !== FALSE)
					{
						//Set the point to active										
						$this->Point_model->toggle_status_active($value);
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
					//Redirect to the points page								
					redirect('/admin/points');
				}				
			
				break;
			}
			//If the user has chosen deactivate						
			case 'deactivate':
			{
				//For each field in the post array						
				foreach($this->input->post() as $key => $value)
				{	
					//If the key of the post field contains the phrase point											
					if (strpos($key,'point') !== FALSE)
					{
						//Set the point to inactive										
						$this->Point_model->toggle_status_inactive($value);
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
					//Redirect to the points page								
					redirect('/admin/points');
				}	
							
				break;
			}
		}
	}
	
	/**
	* Add function
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
			$data['categories'] = $this->Category_model->get_categories();
				
			//Set the validation rules for the point name,description,latitude,longitude and status
			$this->form_validation->set_rules('name', 'Name', 'required|max_length[100]');

			$this->form_validation->set_rules('description', 'Description', 'required|max_length[1000]');

			$this->form_validation->set_rules('latitude', 'Latitude', 'required');		

			$this->form_validation->set_rules('longitude', 'Longitude', 'required');		
			
			$this->form_validation->set_rules('status', 'Status', 'required');			
		
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{
				//Create array representing point						
				$point = array(
					'name'=>$this->input->post('name'),
					'description'=>$this->input->post('description'),
					'latitude'=>$this->input->post('latitude'),
					'longitude'=>$this->input->post('longitude'),
					'status'=>$this->input->post('status'),
				);
				
				//Create point and return new id								
				$id = $this->Point_model->create_point($point);
			
				//If the id value is greater than zero (has been set)								
				if ($id > 0)
				{
					//For each category in categories select
					foreach($this->input->post('categories') as $category)
					{
						//Create point category array
						$point_category = array(
							'point_id'=>$id,
							'category_id'=>$category
						);
						
						//Create new point category						
						$this->Point_category_model->create_point_category($point_category);
					}
					
					//Redirect to the thankyou page
					redirect('/admin/points/thanks/1');				
				}
			
			}
		
			//Load the view
			$this->load->view('admin/points/add',$data);
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}				
	}	
	
	/**
	* Edit function
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
			//Get point
			$data['point'] = $this->Point_model->get_point($id);

			//Get categories
			$data['categories'] = $this->Category_model->get_categories();
			
			//Get selected categories
			$data['selected'] = $this->Point_category_model->get_point_categories($id);

			//Set the validation rules for the point name,description,latitude,longitude and status
			$this->form_validation->set_rules('name', 'Name', 'required|max_length[100]');

			$this->form_validation->set_rules('description', 'Description', 'required|max_length[1000]');

			$this->form_validation->set_rules('latitude', 'Latitude', 'required');		

			$this->form_validation->set_rules('longitude', 'Longitude', 'required');		
			
			$this->form_validation->set_rules('status', 'Status', 'required');		
	
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{
				//Set the data variables with new posted data
				$data['point']->name = $this->input->post('name');
				$data['point']->description = $this->input->post('description');
				$data['point']->latitude = $this->input->post('latitude');
				$data['point']->longitude = $this->input->post('longitude');
				$data['point']->status = $this->input->post('status');
				
				//If the point was updated successfully
				if ($this->Point_model->update_point($data['point']))
				{
					//If all point categories were deleted successfully
					if ($this->Point_category_model->delete_point_category_by_point_id($data['point']->id))
					{
						//Iterate categories in categories form post array
						foreach($this->input->post('categories') as $category)
						{
							//Create point_category array
							$point_category = array(
								'point_id'=>$id,
								'category_id'=>$category
							);
							
							//Create point category						
							$this->Point_category_model->create_point_category($point_category);
						}				
					
						//Redirect to thankyou page
						redirect('/admin/points/thanks/2');
					}
				}
			}	
	
			//Load view
			$this->load->view('admin/points/edit',$data);
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}				
	}
	
	/**
	* Status function
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
			//Change the status of the point		
			$this->Point_model->toggle_status($id);
			
			//If the visitor has come here from another page						
			if ($this->agent->is_referral())
			{
				//Redirect to the referring page						
				redirect($this->agent->referrer());
			}
			else
			{
				//Redirect to points page						
				redirect('/admin/points');
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
				$data['message'] = 'Your point has been added to the database';
				break;
			}
			case 2:
			{
				$data['message'] = 'The selected point has been edited in the database';
				break;			
			}
			case 3:
			{
				$data['message'] = 'The point selected has been deleted from the database';
				break;
			}
		}
		
		$this->load->view('admin/points/thanks',$data);

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
			//Assign point to data array				
			$data['point'] = $this->Point_model->get_point($id);	
			
			//Set the validation rules for the place id
			$this->form_validation->set_rules('id', 'ID', 'required');			
			
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{
				//Delete all point_categories for this point
				$this->Point_category_model->delete_point_category_by_point_id($this->input->post('id'));			
				
				//If the point was deleted
				if ($this->Point_model->delete_point($this->input->post('id')))
				{
					//Redirect to thankyou page
					redirect('/admin/points/thanks/3');
				}
			}			
			
			//Load view
			$this->load->view('admin/points/delete',$data);
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}
	}
			
		
}

/* End of file points.php */
/* Location: ./application/controllers/admin/points.php */