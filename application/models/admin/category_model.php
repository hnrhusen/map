<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Category Model
*
* @author	Robert Coster
*/
class Category_model extends CI_Model 
{
	/**
	* Checks if a category exists with the same name
	*
	* @access	public
	* @param	string
	* @return	boolean
	*/
	function category_exists($name)
	{
		//Query the categories table and get the category with the selected name
		$query = $this->db->get_where('categories',array('name'=>$name));
		
		//If the category was found then return true, otherwise false
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
	* Gets a count of total number of categories
	*
	* @access	public
	* @param	none
	* @return	integer
	*/
	function get_total_categories()
	{
		//Return the categories count
		return $this->db->count_all('categories');
	}

	/**
	* Gets a number of categories offset by value used for paging
	*
	* @access	public
	* @param	integer,integer
	* @return	stdClass array
	*/
	function get_categories_paging($num,$offset)
	{
		//Get a number of categories, offset by the provided number
		$query = $this->db->get('categories',$num,$offset);
		
		//Return the result
		return $query->result();	
	}

	/**
	* Get all categories
	*
	* @access	public
	* @param	none
	* @return	stdClass array
	*/
	function get_categories()
	{
		//Get all categories
		$query = $this->db->get('categories');
		
		//Return the result
		return $query->result();	
	}

	/**
	* Get a single category
	*
	* @access	public
	* @param	integer
	* @return	stdClass
	*/
	function get_category($id)
	{
		//Get the category with the provided id
		$query = $this->db->get_where('categories',array('id'=>$id));
		
		//Return the result					
		return $query->row();
	}

	/**
	* Create a new category
	*
	* @access	public
	* @param	array
	* @return	integer
	*/
	function create_category($category)
	{	
		//Insert the category array into the categories table	
		$this->db->insert('categories',$category);
		
		//Return the id of the inserted item
		return $this->db->insert_id();
	}
	
	/**
	* Updates category information
	*
	* @access	public
	* @param	array
	* @return	boolean
	*/	
	function update_category($category)
	{
		//Select category where matches id
		$this->db->where('id',$category->id);
		
		//Carry out the update on the categories table
		$this->db->update('categories',$category);
		
		//Return true
		return TRUE;
	}
	
	/**
	* Toggles the status of category
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/	
	function toggle_status($id)
	{
		//Get the category with the provided id
		$query = $this->db->get_where('categories',array('id'=>$id));
		
		//If the category was found
		if ($query->num_rows() > 0)
		{
			//Set the $category variable to the stored row
			$category = $query->row();
			
			//If the saved status of the category is 1, set to 0
			//Otherwise set to 1
			if ($category->status == 1)
			{
				$category->status = 0;
			}
			else
			{
				$category->status = 1;
			}
			
			//Call the function to update the category
			$this->update_category($category);
		}
		
		//REturn true
		return TRUE;
	}
	
	/**
	* Sets category status to 1
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/	
	function toggle_status_active($id)
	{
		//Get the category with the provided id
		$query = $this->db->get_where('categories',array('id'=>$id));
		
		//If the category was found	
		if ($query->num_rows() > 0)
		{
			//Set the $category variable to the stored row		
			$category = $query->row();
			
			//Set the category status to 1
			$category->status = 1;
			
			//Update the category
			$this->update_category($category);
		}
		
		//Return true
		return TRUE;
	}
	
	/**
	* Sets category status to 0
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/	
	function toggle_status_inactive($id)
	{
		//Get the category with the provided id		
		$query = $this->db->get_where('categories',array('id'=>$id));
		
		//If the category was found			
		if ($query->num_rows() > 0)
		{
			//Set the $category variable to the stored row				
			$category = $query->row();
			
			//Set the category status to 0			
			$category->status = 0;
			
			//Update the category			
			$this->update_category($category);
		}

		//Return true		
		return TRUE;
	}		
	
	/**
	* Deletes category with given id
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/	
	function delete_category($id)
	{
		//Delete the category from the categories table with the provided id
		$this->db->delete('categories',array('id'=>$id));
		
		//Return true
		return TRUE;
	}	
	
}

/* End of file category_model.php */
/* Location: ./application/models/admin/category_model.php */