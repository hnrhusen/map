<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Place Category Model
*
* @author	Robert Coster
*/
class Point_category_model extends CI_Model 
{
	/**
	* Get the point categories for the provided point
	*
	* @access	public
	* @param	integer
	* @return	stdClass array
	*/
	function get_point_categories($id)
	{
		$query = $this->db->get_where('point_categories',array('point_id'=>$id));
		
		return $query->result();	
	}

	/**
	* Creates point category
	*
	* @access	public
	* @param	integer
	* @return	integer
	*/
	function create_point_category($point_category)
	{		
		$this->db->insert('point_categories',$point_category);
		
		return $this->db->insert_id();
	}

	/**
	* Delete the point category by point id
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/
	function delete_point_category_by_point_id($id)
	{
		$this->db->delete('point_categories',array('point_id'=>$id));
		
		return TRUE;
	}

	/**
	* Delete the point by category id
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/
	function delete_point_category_by_category_id($id)
	{
		$this->db->delete('point_categories',array('category_id'=>$id));
		
		return TRUE;
	}
}

/* End of file place_category_model.php */
/* Location: ./application/models/admin/place_category_model.php */