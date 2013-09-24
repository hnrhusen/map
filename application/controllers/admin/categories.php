<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Categories Controller
*
* @author	Robert Coster
*/
class Categories extends CI_Controller 
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
		
		//Load the category and point category models
		$this->load->model(array('admin/Category_model','admin/Point_category_model'));		
		
		//Load the session,user agent,form validation and pagination libraries 
		$this->load->library(array('session','user_agent','form_validation','pagination'));		

		//Load the url and form helpers
		$this->load->helper(array('url','form'));	
	}

	/**
	* Private callback function used to check if a category already exists with name provided
	*
	* @access	private
	* @param	string
	* @return	boolean
	*/	
	function _category_exists($name)
	{				
		//Check if the user exists with the username and password provided
		if($this->Category_model->category_exists($name) === FALSE)
		{	
			//Category exists, return true
			return TRUE;
		}
		else
		{
			//Category does not exist, set a validation message
			$this->form_validation->set_message('_category_exists','Category with that name already exists');
	
			//Return false, validation failed
			return FALSE;
		}
	
	}
	
	/**
	* Private callback function used to check if a category is available
	*
	* @access	private
	* @param	string
	* @return	boolean
	*/	
	function _category_available($name)
	{	
		//Get the id of the user from post
		$id = $this->input->post('id');
		
		//Get the entered username from post
		$name = $this->input->post('name');	
		
		//Get the user object
		$category = $this->Category_model->get_category($id);
		
		//if the category was found
		if ($category)
		{
			//If the stored category does not match the new name
			if ($category->name != $name)
			{
				//Name is not the same as the stored name, it is being changed
				if ($this->Category_model->category_exists($name) === FALSE)
				{
					//Name can be changed, new name is available return true
					return TRUE;
				}
				else
				{
					//Name cannot be changed, set validation message
					$this->form_validation->set_message('_category_available','The category name chosen is already in use');

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
			$this->form_validation->set_message('_category_available','Cannot find category with the information provided');
		
			//Return false, validation failed
			return FALSE;
		}	
	
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
			$config['base_url'] = '/index.php/admin/categories/index/';
			$config['total_rows'] = $this->Category_model->get_total_categories();
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
		
			//Set the categories in the data variable to be passed to the view
			$data['categories'] = $this->Category_model->get_categories_paging($config['per_page'],$this->uri->segment(4));
			//Load the view
			$this->load->view('admin/categories/index',$data);
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
				//Redirect to the add category page
				redirect('/admin/categories/add');
				break;
			}
			//If the user has chosen activate
			case 'activate':
			{	
				//For each field in the post array			
				foreach($this->input->post() as $key => $value)
				{	
					//If the key of the post field contains the phrase category				
					if (strpos($key,'category') !== FALSE)
					{
						//Set the category to active
						$this->Category_model->toggle_status_active($value);
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
					//Redirect to the categories page
					redirect('/admin/categories');
				}				
			
				break;
			}
			//If the user has chosen deactivate
			case 'deactivate':
			{
				//For each field in the post array
				foreach($this->input->post() as $key => $value)
				{	
					//If the key of the post field contains the phrase category				
					if (strpos($key,'category') !== FALSE)
					{
						//Set the category to inactive
						$this->Category_model->toggle_status_inactive($value);
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
					//Redirect to the categories page
					redirect('/admin/categories');
				}	
							
				break;
			}
		}
	}

	/**
	* Add category
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
			//Set the validation rules for the category name and status
			$this->form_validation->set_rules('name', 'Name', 'required|max_length[100]|callback__category_exists');
			
			$this->form_validation->set_rules('status', 'Status', 'required');			
		
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{
				//Create array representing category
				$category = array(
					'name'=>$this->input->post('name'),
					'status'=>$this->input->post('status'),
				);
				
				//Create category and return new id
				$id = $this->Category_model->create_category($category);
				
				//If the id value is greater than zero (has been set)
				if ($id > 0)
				{
					//Redirect to the thankyou page
					redirect('/admin/categories/thanks/1');
				}
			}
		
			//Load the view
			$this->load->view('admin/categories/add');
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
			//Assign categories to the data array
			$data['category'] = $this->Category_model->get_category($id);
	
			//Set the validation rules for the category name and status
			$this->form_validation->set_rules('name', 'Name', 'required|max_length[100]|callback__category_available');
			
			$this->form_validation->set_rules('status', 'Status', 'required');		
	
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{
				//Set the category values in the data array
				$data['category']->name = $this->input->post('name');
				$data['category']->status = $this->input->post('status');
				
				//Update the category in the database
				if ($this->Category_model->update_category($data['category']))
				{
					//Redirect to the thank you page
					redirect('/admin/categories/thanks/2');
				}
			}	
	
			//Load the view
			$this->load->view('admin/categories/edit',$data);
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}				
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
			//Assign category to data array
			$data['category'] = $this->Category_model->get_category($id);	
			
			//Set the validation rules for the category name and status
			$this->form_validation->set_rules('id', 'ID', 'required');			
			
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{
				//Delete the point_categories for this category id
				$this->Point_category_model->delete_point_category_by_category_id($this->input->post('id'));			
			
				//Delete the category
				if ($this->Category_model->delete_category($this->input->post('id')))
				{
					//Redirect to thankyou page
					redirect('/admin/categories/thanks/3');
				}
			}			
			
			//Load the view
			$this->load->view('admin/categories/delete',$data);
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
			//Change the status of the category
			$this->Category_model->toggle_status($id);
			
			//If the visitor has come here from another page
			if ($this->agent->is_referral())
			{
				//Redirect to the referring page
				redirect($this->agent->referrer());
			}
			else
			{
				//Redirect to categories page
				redirect('/admin/categories');
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
				$data['message'] = 'Your category has been added to the database';
				break;
			}
			case 2:
			{
				$data['message'] = 'The selected category has been edited in the database';
				break;			
			}
			case 3:
			{
				$data['message'] = 'The category selected has been deleted from the database';
				break;
			}
		}
		
		$this->load->view('admin/categories/thanks',$data);

	}
	
}

/* End of file categories.php */
/* Location: ./application/controllers/admin/categories.php */