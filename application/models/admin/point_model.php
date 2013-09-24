<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Point Model
*
* @author	Robert Coster
*/
class Point_model extends CI_Model 
{
	/**
	* Gets a count of total number of points
	*
	* @access	public
	* @param	none
	* @return	integer
	*/
	function get_total_points()
	{
		//Return the points count		
		return $this->db->count_all('points');
	}

	/**
	* Gets a number of points offset by value used for paging
	*
	* @access	public
	* @param	integer,integer
	* @return	stdClass array
	*/
	function get_points_paging($num,$offset)
	{
		//Get a number of points, offset by the provided number		
		$query = $this->db->get('points',$num,$offset);
		
		//Return the result				
		return $query->result();	
	}
	
	/**
	* Get all points
	*
	* @access	public
	* @param	none
	* @return	stdClass array
	*/	
	function get_points()
	{
		//Get all points		
		$query = $this->db->get('points');
		
		//Return the result				
		return $query->result();	
	}

	/**
	* Get a single point
	*
	* @access	public
	* @param	integer
	* @return	stdClass
	*/	
	function get_point($id)
	{
		//Get the point with the provided id		
		$query = $this->db->get_where('points',array('id'=>$id));
		
		//Return the result									
		return $query->row();	
	}

	/**
	* Create a new point
	*
	* @access	public
	* @param	array
	* @return	integer
	*/
	function create_point($point)
	{	
		//Insert the point array into the points table				
		$this->db->insert('points',$point);
		
		//Return the id of the inserted item				
		return $this->db->insert_id();
	}
	
	/**
	* Updates point information
	*
	* @access	public
	* @param	array
	* @return	boolean
	*/			
	function update_point($point)
	{
		//Select point where matches id		
		$this->db->where('id',$point->id);
		
		//Carry out the update on the points table				
		$this->db->update('points',$point);
		
		//Return true				
		return TRUE;
	}
	
	/**
	* Toggles the status of point
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/		
	function toggle_status($id)
	{
		//Get the point with the provided id		
		$query = $this->db->get_where('points',array('id'=>$id));
		
		//If the point was found				
		if ($query->num_rows() > 0)
		{
			//Set the $point variable to the stored row				
			$point = $query->row();
			
			//If the saved status of the point is 1, set to 0
			//Otherwise set to 1						
			if ($point->status == 1)
			{
				$point->status = 0;
			}
			else
			{
				$point->status = 1;
			}
			
			//Call the function to update the point						
			$this->update_point($point);
		}
		
		//Return true
		return TRUE;
	}	
	
	/**
	* Sets point status to 1
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/		
	function toggle_status_active($id)
	{
		//Get the point with the provided id		
		$query = $this->db->get_where('points',array('id'=>$id));
		
		//If the point was found					
		if ($query->num_rows() > 0)
		{
			//Set the $point variable to the stored row							
			$point = $query->row();
			
			//Set the point status to 1						
			$point->status = 1;
			
			//Update the point						
			$this->update_point($point);
		}
		
		//Return true
		return TRUE;
	}
	
	/**
	* Sets place status to 0
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/			
	function toggle_status_inactive($id)
	{
		//Get the point with the provided id				
		$query = $this->db->get_where('points',array('id'=>$id));
		
		//If the point was found							
		if ($query->num_rows() > 0)
		{
			//Set the $point variable to the stored row								
			$point = $query->row();
			
			//Set the point status to 0									
			$point->status = 0;
			
			//Update the point									
			$this->update_point($point);
		}
		
		//Return true
		return TRUE;
	}		
	
	/**
	* Deletes point with given id
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/			
	function delete_point($id)
	{
		//Delete the point from the points table with the provided id		
		$this->db->delete('points',array('id'=>$id));
		
		//Return true
		return TRUE;
	}	
}

/* End of file point_model.php */
/* Location: ./application/models/admin/point_model.php */