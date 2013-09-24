<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Place Model
*
* @author	Robert Coster
*/
class Place_model extends CI_Model 
{
	/**
	* Gets all live places
	*
	* @access	public
	* @param	none
	* @return	stdClass array
	*/
	function get_all_places()
	{
		//Get all live places in the places table
		$query = $this->db->get_where('places',array('status'=>1));
		
		//Return the result
		return $query->result();	
	}
	
	/**
	* Gets the default place
	*
	* @access	public
	* @param	none
	* @return	stdClass
	*/
	function get_default_place()
	{
		//Get the default place from the places table
		$query = $this->db->get_where('places',array('default'=>1,'status'=>1));
		
		//Return the single row
		return $query->row();	
	}	

	/**
	* Get a single place
	*
	* @access	public
	* @param	integer
	* @return	stdClass
	*/
	function get_place($id)
	{
		//Get a specific place from the places table
		$query = $this->db->get_where('places',array('id'=>$id,'status'=>1));
		
		//Return the single row
		return $query->row();	
	}	
}

/* End of file place_model.php */
/* Location: ./application/models/place_model.php */