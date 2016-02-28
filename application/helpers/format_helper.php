<?php defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_letter_num_day'))
{
	function get_letter_num_day($num)
	{
		switch($num){
			case 1: return 'L';
			case 2: return 'M';
			case 3: return 'X';
			case 4: return 'J';
			case 5: return 'V';
			case 6: return 'S';
			case 7: return 'D';
			default: return '';
		}
	}
}

if ( ! function_exists('get_num_day'))
{
	function get_num_day($letter)
	{
		switch($letter) {
			case 'L': return 1;
			case 'M': return 2;
			case 'X': return 3;
			case 'J': return 4;
			case 'V': return 5;
			case 'S': return 6;
			case 'D': return 7;
			default: return 0;
		}
	}
}

if ( ! function_exists('format_number'))
{
	//return int with 2 digits
	function format_number($num) {
        return sprintf("%02d", $num);
    }
}