<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Point Model
*
* @author	Robert Coster
*/
class Point_model extends CI_Model 
{
	/**
	* Get points in location and in selected categories
	*
	* @access	public
	* @param	array,array
	* @return	array
	*/
	function get_points($location,$categories)
	{	
		//Select distinct points (i.e if in multiple categories, only select the point once
		$this->db->distinct();
		
		//Select everything in points		
		$this->db->select('points.*');
		
		//From the points table
		$this->db->from('points');
		
		//Join with the point categories table on points.id and point_categories.point_id
		$this->db->join('point_categories','points.id = point_categories.point_id');	
		
		//If the categories have been selected then filter by the selected categories in the
		//array, otherwise don't filter and display all 	
		if (is_array($categories))
		{
			$this->db->where_in('point_categories.category_id',$categories);	
		}
			
		//Filter the points to those between a starting (sw) latitude and ending (ne) latitude
		$this->db->where('points.latitude BETWEEN '.$location['swlat'].' AND '.$location['nelat']);

		//Filter the points to those between a starting (sw) longitude and ending (ne) longitude		
		$this->db->where('points.longitude BETWEEN '.$location['swlng'].' AND '.$location['nelng']);
		
		//Execute the query
		$query = $this->db->get();
	
		//Return the results of the query
		return $query->result_array();		
	}

	/**
	* Gets all live points
	*
	* @access	public
	* @param	none
	* @return	stdClass array
	*/
	function get_all_points()
	{
		//Get all live points in the points table
		$query = $this->db->get_where('points',array('status'=>1));
		
		//Return the result
		return $query->result();	
	}

	/**
	* Get single point
	*
	* @access	public
	* @param	integer
	* @return	stdClass
	*/
	function get_point($id)
	{
		//Get a specific point from the points table
		$query = $this->db->get_where('points',array('id'=>$id,'status'=>1));
		
		//Return the single row
		return $query->row();	
	}	
}

/* End of file point_model.php */
/* Location: ./application/models/point_model.php */