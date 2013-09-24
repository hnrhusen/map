<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Users Controller
*
* @author	Robert Coster
*/
class Users extends CI_Controller 
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
		
		//Load the user model
		$this->load->model('admin/User_model');
		
		//Load the libraries required
		$this->load->library(array('form_validation','user_agent','session','encrypt'));	

		//Load the helpers required
		$this->load->helper(array('form', 'url'));

	} 
	
	/**
	* Private function creates a salted password from that entered by the user in the create function
	*
	* @access	private
	* @param	none
	* @return	none
	*/	
	function _salt_password($username,$password)
	{		
		//Get the encryption key from the config file	
		$key = $this->config->item('encryption_key');
		
		//Get the first 4 characters of the username and reverse to create a user specific value
		$usv = strrev(substr($username,1,4));
		
		//Return the sha1 hashed values as a password
		return $this->encrypt->sha1($key.$password.$usv);		
	} 

	/**
	* Private callback function used in validation to check if the user exists with the username and password
	*
	* @access	private
	* @param	none
	* @return	none
	*/	
	function _login_user($key)
	{
		//Get the entered username from post
		$username = $this->input->post('username');
		
		//Get the entered password from post			
		$password = $this->input->post('password');
		
		//Salt the entered password and return the salted password	
		$salted = $this->_salt_password($username,$password);
		
		//Attempt to login the user using the username and salted password						
		$user = $this->User_model->login_user($username,$salted);
		
		//Check if the user was found
		if ($user)
		{
			//If the user was found then set the session id variable to the user id
			$this->session->set_userdata('id',$user->id);
			
			//Return true from the callback function
			return TRUE;
		}
		else
		{
			//The user was not found so set a message to this effect
			$this->form_validation->set_message('_login_user','The account was not found');
			
			//Return false, validation failed
			return FALSE;
		}		
	}
	
	/**
	* Private callback function used to check if a user already exists with username provided
	*
	* @access	private
	* @param	none
	* @return	none
	*/		
	function _user_exists($username)
	{				
		//Check if the user exists with the username and password provided
		if($this->User_model->user_exists($username) === FALSE)
		{	
			//User exists, return true
			return TRUE;
		}
		else
		{
			//User does not exist, set a validation message
			$this->form_validation->set_message('_user_exists','The account with username entered already exists');
	
			//Return false, validation failed
			return FALSE;
		}
	
	}
	
	/**
	* Private callback function used to check if a username is available
	*
	* @access	private
	* @param	none
	* @return	none
	*/		
	function _username_available($username)
	{	
		//Get the id of the user from post
		$id = $this->input->post('id');
		
		//Get the entered username from post
		$username = $this->input->post('username');	
		
		//Get the user object
		$user = $this->User_model->get_user($id);
		
		if ($user)
		{
			//If username is not equal to stored username
			if ($user->username != $username)
			{
				//Username is not the same as the stored username, it is being changed
				if ($this->User_model->user_exists($username) === FALSE)
				{
					//Username can be changed, new username is available return true
					return TRUE;
				}
				else
				{
					//Username cannot be changed, set validation message
					$this->form_validation->set_message('_username_available','The username chosen is already in use');

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
			$this->form_validation->set_message('_username_available','Cannot find user with the information provided');
		
			//Return false, validation failed
			return FALSE;
		}	
	
	}
	
	/**
	* Login function
	*
	* @access	public
	* @param	none
	* @return	none
	*/	
	public function login()
	{	
		//Set the validation rules for the username and password, with the username set to use the _login_user callback
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[12]|trim|callback__login_user');
		
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[12]|trim');			
		
		//If the validation has been executed and the method used to access the page is post
		if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->form_validation->run() == TRUE)
		{			
			//At this point the validation including the user_login callback has passed so redirect to the account main action		
			redirect('/admin');
		}
		
		//Render the login view
		$this->load->view('admin/users/login');		
	}
	
	/**
	* Logout function
	*
	* @access	public
	* @param	none
	* @return	none
	*/
	public function logout()
	{	
		//Destroy the user session removing data from db
		$this->session->sess_destroy();
		
		//Redirect the user to the login page
		redirect('/admin/users/login');
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
		//Check if the user id session value exists	
		if ($this->session->userdata('id'))
		{		
			//Switch based on the user selection				
			switch($this->input->post('action'))
			{
				//If the user has chosen add							
				case 'add':
				{
					redirect('/admin/users/add');
					break;
				}
				//If the user has chosen activate							
				case 'activate':
				{		
					//For each field in the post array																	
					foreach($this->input->post() as $key => $value)
					{	
						//If the key of the post field contains the phrase user									
						if (strpos($key,'user') !== FALSE)
						{
							//Set the point to active										
							$this->User_model->toggle_status_active($value);
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
						//Redirect to the users page													
						redirect('/admin/users');
					}				
				
					break;
				}
				//If the user has chosen deactivate								
				case 'deactivate':
				{
					//For each field in the post array																	
					foreach($this->input->post() as $key => $value)
					{		
						//If the key of the post field contains the phrase user										
						if (strpos($key,'user') !== FALSE)
						{
							//Set the point to inactive																
							$this->User_model->toggle_status_inactive($value);
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
						//Redirect to the users page													
						redirect('/admin/users');
					}	
								
					break;
				}
			}
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}
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
			//Set users into data array
			$data['users'] = $this->User_model->get_users();
		
			//Load view
			$this->load->view('admin/users/index',$data);
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
			//Change the status of the user					
			$this->User_model->toggle_status($id);
			
			//If the visitor has come here from another page									
			if ($this->agent->is_referral())
			{
				//Redirect to the referring page									
				redirect($this->agent->referrer());
			}
			else
			{
				//Redirect to users page									
				redirect('/admin/users');
			}
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
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
			//Set the validation rules for the username and password
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[12]|trim|callback__user_exists');
			
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[12]|trim');	
		
			//If the validation has been executed and the method used to access the page is post
			if ($this->form_validation->run() == TRUE)
			{			
				//Get the entered username from post	
				$username = $this->input->post('username');
				
				//Get the entered password from post		
				$password = $this->input->post('password');
					
				//Get the selected status from post
				$status = $this->input->post('status');	
					
				//Salt the entered password and return the salted password					
				$salted = $this->_salt_password($username,$password);
				
				//Create the user with the username and salted password and return the user id
				$id = $this->User_model->create_user($username,$salted,$status);
				
				if ($id > 0)
				{								
					//Redirect to a thankyou page
					redirect('/admin/users/thanks/1');
				}
			}

			//Render the create account view		
			$this->load->view('/admin/users/add');
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
		if ($this->session->userdata('id'))
		{	
			//Set the users data array by retrieving from database	
			$data['user'] = $this->User_model->get_user($id);
						
			//Set the validation rules for the username and password
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[12]|trim|callback__username_available');				
						
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{					
				//Get the entered username from post	
				$username = $this->input->post('username');
					
				//Get the selected status from post
				$status = $this->input->post('status');	
				
				//Get the user
				$user = $this->User_model->get_user($id);	
				
				//Update the user object retrived with the new username and status
				$user->username = $username;
				
				$user->status = $status;	
				
				//Execute the database update for the user
				if ($this->User_model->update_user($user))
				{
					//Redirect to the thankyou page
					redirect('/admin/users/thanks/2');						
				}
			}		
		
			//Render the create account view		
			$this->load->view('/admin/users/edit',$data);
		
		}	
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');	
		}	
	}
	
	/**
	* Delete function
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
			$data['user'] = $this->User_model->get_user($id);	
			
			//Set the validation rules for the place id
			$this->form_validation->set_rules('id', 'ID', 'required');			
			
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{
				//Delete the user
				if ($this->User_model->delete_user($this->input->post('id')))		
				{			
					//Redirect to thankyou page
					redirect('/admin/users/thanks/4');
				}
			}			
			
			//Load view
			$this->load->view('admin/users/delete',$data);
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/admin/users/login');
		}
	}	
	
	/**
	* Password function
	*
	* @access	public
	* @param	none
	* @return	none
	*/	
	public function password($id)
	{
		//Check if the user id session value exists
		if ($this->session->userdata('id'))
		{					
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|max_length[12]|trim');	
		
			//If the validation has been executed
			if ($this->form_validation->run() == TRUE)
			{	
				//Get the user object
				$user = $this->User_model->get_user($id);
							
				//Get the entered password from post		
				$password = $this->input->post('password');
			
				//Salt the entered password and return the salted password					
				$salted = $this->_salt_password($user->username,$password);			
					
				//Execute the database update to change the password				
				if ($this->User_model->change_password($id,$salted))
				{
					//Redirect to the thank you page
					redirect('/admin/users/thanks/3');				
				}
			}	
			
			//Render the create account view		
			$this->load->view('/admin/users/password');				
		}
		else
		{
			//The user id session value does not exist so redirect to the login page
			redirect('/account/login');		
		}		
	
	}
	
	/**
	* Thanks function
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
				$data['message'] = 'The user has been added to the database';
				break;
			}
			case 2:
			{
				$data['message'] = 'The selected user has been edited in the database';
				break;			
			}
			case 3:
			{			
				$data['message'] = 'The selected user password has been changed in the database';
				break;			
			}
			case 4:
			{
				$data['message'] = 'The user selected has been deleted from the database';
				break;
			}
		}
		
		$this->load->view('admin/users/thanks',$data);

	}	
}

/* End of file user.php */
/* Location: ./application/controllers/admin/user.php */