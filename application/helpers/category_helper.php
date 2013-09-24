<?php

function category_selected($selected,$category)
{
	$found = FALSE;

	foreach($selected as $item)
	{
		if ($item->category_id == $category->id)
		{
			$found = TRUE;
			break;
		}
	}
			
	return $found;
}