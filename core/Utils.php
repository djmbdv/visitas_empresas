<?php

class Utils{
	
	public static function to_url($ss){
		return str_replace(" ", "+", $ss);
	}
}