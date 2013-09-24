<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* User Model
*
* @author	Robert Coster
*/
class User_model extends CI_Model 
{

	/**
	* Constructor, loads date helper
	*
	* @access	private
	* @param	none
	* @return	none
	*/
	function __construct()
	{
		//Call the parent constructor
		parent::__construct();
		
		//Load the date helper
		$this->load->helper('date');
	}
	
	/**
	* Checks if a user exists with the same username
	*
	* @access	public
	* @param	string
	* @return	boolean
	*/	
	function user_exists($username)
	{
		//Query the users table and get the user with the selected username	
		$query = $this->db->get_where('users',array('username'=>$username));
		
		//If the user was found then return true, otherwise false		
		if (count($query->result()) > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	* Get a single user
	*
	* @access	public
	* @param	integer
	* @return	stdClass
	*/	
	function get_user($id)
	{
		//Get the user with the provided id	
		$query = $this->db->get_where('users',array('id'=>$id));
			
		//Return the result									
		return $query->row();
	}

	/**
	* Get all users
	*
	* @access	public
	* @param	none
	* @return	stdClass array
	*/	
	function get_users()
	{
		//Get all users		
		$query = $this->db->get('users');
		
		//Return the result				
		return $query->result();
	}
	
	/**
	* Get the login user object
	*
	* @access	public
	* @param	string,string
	* @return	stdClass
	*/		
	function login_user($username,$password)
	{		
		//Get the user with the username and password matching the provided values and where status is 1	
		$query = $this->db->get_where('users',array('username'=>$username,'password'=>$password,'status'=>'1'));
				
		//Return the user
		return $query->row();
	}
	
	/**
	* Create user
	*
	* @access	public
	* @param	string,string,integer
	* @return	integer
	*/		
	function create_user($username,$password,$status)
	{
		//Create a data array with user details
		$data = array('username'=>$username,'password'=>$password,'status'=>$status);
		
		//Insert the user into the database
		$this->db->insert('users',$data);
		
		//Return the id of the inserted user
		return $this->db->insert_id();
	}
	
	/**
	* Toggles the status of user
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/	
	function toggle_status($id)
	{
		//Get the user with the provided id	
		$query = $this->db->get_where('users',array('id'=>$id));
		
		//If the user was found		
		if ($query->num_rows() > 0)
		{
			//Set the $user variable to the stored row		
			$user = $query->row();
			
			//If the saved status of the user is 1, set to 0
			//Otherwise set to 1			
			if ($user->status == 1)
			{
				$user->status = 0;
			}
			else
			{
				$user->status = 1;
			}

			//Call the function to update the user			
			$this->update_user($user);
		}
		
		//Return true
		return TRUE;
	}	
	
	/**
	* Sets user status to 1
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/			
	function toggle_status_active($id)
	{
		//Get the user with the provided id	
		$query = $this->db->get_where('users',array('id'=>$id));
		
		//If the user was found			
		if ($query->num_rows() > 0)
		{
			//Set the $user variable to the stored row				
			$user = $query->row();
			
			//Set the user status to 1			
			$user->status = 1;
			
			//Update the user			
			$this->update_user($user);
		}
		
		//Return true
		return TRUE;
	}
	
	/**
	* Sets user status to 0
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/			
	function toggle_status_inactive($id)
	{
		//Get the user with the provided id		
		$query = $this->db->get_where('users',array('id'=>$id));
		
		//If the user was found					
		if ($query->num_rows() > 0)
		{
			//Set the $user variable to the stored row						
			$user = $query->row();
			
			//Set the user status to 0					
			$user->status = 0;
			
			//Update the user						
			$this->update_user($user);
		}
		
		//Return true
		return TRUE;
	}			
	
	/**
	* Changes user password
	*
	* @access	public
	* @param	integer,string
	* @return	boolean
	*/			
	function change_password($id,$password)
	{
		//Create an data array
		$data = array('password'=>$password);
		
		//Select the user matching the id
		$this->db->where('id',$id);
		
		//Update the users table with the data
		$this->db->update('users',$data);
		
		//Return true
		return TRUE;
	}
	
	/**
	* Updates user information
	*
	* @access	public
	* @param	array
	* @return	boolean
	*/			
	function update_user($user)
	{
		//Select from users where matching id
		$this->db->where('id',$user->id);
		
		//Update users matching id
		$this->db->update('users',$user);
		
		//Return true
		return TRUE;
	}

	/**
	* Deletes user with given id
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/
	function delete_user($id)
	{
		//Delete the user matching the id
		$this->db->delete('users',array('id'=>$id));
		
		//Return true
		return TRUE;
	}

}

/* End of file user_model.php */
/* Location: ./application/models/admin/user_model.php */
