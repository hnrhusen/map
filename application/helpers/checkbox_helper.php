<?php

function checkbox_selected($value,$array)
{
	$checked = FALSE;

	if (is_array($array))
	{
		foreach($array as $item)
		{
			if ($item === $value)
			{
				$checked = TRUE;
				break;
			}
		}
	}
	
	return $checked;	
}