<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Place Model
*
* @author	Robert Coster
*/
class Place_model extends CI_Model 
{
	/**
	* Checks if a place exists with the same name
	*
	* @access	public
	* @param	string
	* @return	boolean
	*/
	function place_exists($name)
	{
		//Query the places table and get the place with the selected name
		$query = $this->db->get_where('places',array('name'=>$name));
		
		//If the place was found then return true, otherwise false		
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
	* Gets a count of total number of places
	*
	* @access	public
	* @param	none
	* @return	integer
	*/
	function get_total_places()
	{
		//Return the places count	
		return $this->db->count_all('places');
	}

	/**
	* Gets a number of places offset by value used for paging
	*
	* @access	public
	* @param	integer,integer
	* @return	stdClass array
	*/
	function get_places_paging($num,$offset)
	{
		//Get a number of places, offset by the provided number	
		$query = $this->db->get('places',$num,$offset);
		
		//Return the result		
		return $query->result();	
	}
	
	/**
	* Get all places
	*
	* @access	public
	* @param	none
	* @return	stdClass array
	*/	
	function get_places()
	{
		//Get all places	
		$query = $this->db->get('places');
		
		//Return the result		
		return $query->result();	
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
		//Get the place with the provided id	
		$query = $this->db->get_where('places',array('id'=>$id));
		
		//Return the result							
		return $query->row();	
	}

	/**
	* Create a new place
	*
	* @access	public
	* @param	array
	* @return	integer
	*/
	function create_place($place)
	{		
		//Insert the place array into the places table		
		$this->db->insert('places',$place);
		
		//Return the id of the inserted item		
		return $this->db->insert_id();
	}
	
	/**
	* Updates place information
	*
	* @access	public
	* @param	array
	* @return	boolean
	*/		
	function update_place($place)
	{
		//Select place where matches id	
		$this->db->where('id',$place->id);
		
		//Carry out the update on the places table		
		$this->db->update('places',$place);
		
		//Return true		
		return TRUE;
	}
	
	/**
	* Toggles the status of place
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/		
	function toggle_status($id)
	{
		//Get the place with the provided id	
		$query = $this->db->get_where('places',array('id'=>$id));
		
		//If the place was found		
		if ($query->num_rows() > 0)
		{
			//Set the $place variable to the stored row		
			$place = $query->row();
			
			//If the saved status of the place is 1, set to 0
			//Otherwise set to 1			
			if ($place->status == 1)
			{
				$place->status = 0;
			}
			else
			{
				$place->status = 1;
			}
			
			//Call the function to update the place			
			$this->update_place($place);
		}
		
		//Return true
		return TRUE;
	}	
	
	/**
	* Toggles if a place is marked as the default
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/		
	function toggle_default($id)
	{
		//Select where the places aren't equal to id	
		$this->db->where('id !=',$id);
		
		//Update the places and set default to 0
		$this->db->update('places',array('default'=>0));
		
		//Return true
		return TRUE;
	}
	
	/**
	* Sets place status to 1
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/		
	function toggle_status_active($id)
	{
		//Get the place with the provided id	
		$query = $this->db->get_where('places',array('id'=>$id));
		
		//If the place was found			
		if ($query->num_rows() > 0)
		{
			//Set the $place variable to the stored row				
			$place = $query->row();
			
			//Set the place status to 1			
			$place->status = 1;
			
			//Update the place			
			$this->update_place($place);
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
		//Get the place with the provided id			
		$query = $this->db->get_where('places',array('id'=>$id));
		
		//If the place was found					
		if ($query->num_rows() > 0)
		{
			//Set the $place variable to the stored row						
			$place = $query->row();

			//Set the place status to 0						
			$place->status = 0;
			
			//Update the place						
			$this->update_place($place);
		}

		//Return true				
		return TRUE;
	}	
	
	/**
	* Deletes place with given id
	*
	* @access	public
	* @param	integer
	* @return	boolean
	*/		
	function delete_place($id)
	{
		//Delete the place from the places table with the provided id	
		$this->db->delete('places',array('id'=>$id));
		
		//Return true		
		return TRUE;
	}	
}

/* End of file place_model.php */
/* Location: ./application/models/admin/place_model.php */