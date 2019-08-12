<?php
namespace App;
class Serial {
	public static $ALPHABET_NUMBER = '2513964078';
	// length 1 : 0               - 29              => 30
	// length 2 : 30              - 899             => 869
	// length 3 : 900             - 26,999          => 26,100
	// length 4 : 27,000          - 809,999         => 783,000
	// length 5 : 810,000         - 24,299,999      => 23,489,999
	// length 6 : 24,300,000      - 728,999,999     => 704,699,999
	// length 7 : 729,000,000     - 21,869,999,999  => 21,140,999,999
	// length 8 : 21,870,000,000  - 656,099,999,999 => 634,229,999,999
	// length 9 : 656,100,000,000 - 656,099,999,999 => 634,229,999,999
	public static $ALPHABET        = '69D3T4AWFQMHV5BKEPCZ2U8NGSX7YR';
	// length 5 : 16,79,616       - 60,466,176         => 58,786,560
	public static $ALPHABET_ALL    = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	private static function alphabet($_alphabet)
	{
		$alphabet = null;
		switch ($_alphabet)
		{
			case 'number':
				$alphabet = self::$ALPHABET_NUMBER;
				break;
			case 'all':
				$alphabet = self::$ALPHABET_ALL;
				break;
			case null:
			case '':
			case false:
			case 'default':
				$alphabet = self::$ALPHABET;
				break;
			default:
				$alphabet = $_alphabet;
				break;
		}
		return $alphabet;
	}
	/**
	 * encode input text
	 * @param  [type] $_num      [description]
	 * @param  [type] $_alphabet [description]
	 * @return [type]            [description]
	 */
	public static function encode($_num = null, $_alphabet = null)
	{
		$_alphabet = self::alphabet($_alphabet);
		if(!is_numeric($_num))
		{
			return false;
		}
		$lenght = mb_strlen($_alphabet);
		$str = '';
		while ($_num > 0)
		{
			$str  = substr($_alphabet, ($_num % $lenght), 1) . $str;
			$_num = floor($_num / $lenght);
		}
		return $str;
	}
	/**
	 * decode input text
	 * @param  [type] $_str      [description]
	 * @param  [type] $_alphabet [description]
	 * @return [type]            [description]
	 */
	public static function decode($_str = null, $_alphabet = null)
	{
		if(!self::is($_str, $_alphabet))
		{
			return false;
		}
		$_alphabet = self::alphabet($_alphabet);
		$lenght = mb_strlen($_alphabet);
		$num    = 0;
		$len    = mb_strlen($_str);
		$_str   = str_split($_str);
		for ($i = 0; $i < $len; $i++)
		{
			$num = $num * $lenght + strpos($_alphabet, $_str[$i]);
		}
		return $num;
	}
	/**
	 * Determines if short url.
	 *
	 * @param      <type>   $_string  The string
	 *
	 * @return     boolean  True if short url, False otherwise.
	 */
	public static function is($_string, $_alphabet = null)
	{
		if(!is_string($_string) && !is_numeric($_string))
		{
			return false;
		}
		$_alphabet = self::alphabet($_alphabet);
		if(preg_match("/^[". $_alphabet. "]+$/", $_string))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
