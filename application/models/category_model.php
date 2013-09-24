<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Category Model
*
* @author	Robert Coster
*/
class Category_model extends CI_Model 
{
	/**
	* Gets a list of live categories
	*
	* @access	public
	* @param	none
	* @return	stdClass array
	*/
	function get_categories()
	{
		//Get all live categories
		$query = $this->db->get_where('categories',array('status'=>1));
		
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
		//Get the selected category
		$query = $this->db->get_where('categories',array('id'=>$id,'status'=>1));
							
		//Return the single result
		return $query->row();
	}	
}

/* End of file category_model.php */
/* Location: ./application/models/category_model.php */