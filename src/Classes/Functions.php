<?php
if (defined('securipe') or exit(1))
{
	/**
	 * Contains additional general purpose methods for PHP
	 * And altered/extended versions of current PHP methods
	 */
	class Site
	{
		/** Redirection **/
		
		/**
		 * Redirects the page to the root of the website
		 * @param logout, if set to true will also log out the user.
		 */
		public static function BackToHome()
		{
			Site::Redirect('/');
		}
		
		/**
		 * Redirects the page to the specified URL
		 * @param relative, specifies if the URL is relative to the current page.
		 */
		public static function Redirect($url, $relative=false)
		{
			if ($relative) { header('Location: '.$url); }
			else { header('Location: '.$url); }
			exit;
		}
		
		/**
		 * Retrieves a GET value after sanitizing it
		 * @param id, The name of the GET value to retrieve.
		 * @param keephtml, Disables the HTML part of the sanitization (not reccomended).
		 */
		public static function GetArgumentSafely($id, $keephtml = false)
		{
			$return = EMPTYSTRING;
			if (Value::SetAndNotEmpty($_GET, $id)) {
				$return = _string::Sanitize($_GET[$id], $keephtml);
			}
			return $return;
		}
		
		/**
		 * Retrieve a POST value after sanitizing it
		 * @param id, The name of the POST value to retrieve.
		 * @param keephtml, Disables the HTML part of the sanitization (not reccomended).
		 */
		public static function GetPostValueSafely($id, $keephtml = false)
		{
			$return = EMPTYSTRING;
			if (isset($_POST[$id]) && !empty($_POST[$id]))
			{
				$return = _string::Sanitize($_POST[$id], $keephtml);
			}
		}
		
		/**
		 * Returns true if the client is connecting via HTTPS, otherwise it returns false.
		 */
		public static function HasHttps()
		{
			$secure_connection = false;
			if (isset($_SERVER['HTTPS'])) {
				if ($_SERVER['HTTPS'] == "on") { $secure_connection = true; }
				else {
					$_SESSION['sup3rsEcurevariAble'] = -1;
					$_SESSION['3rr0r'] = 'You are not running secure, <a href="https://'.$_SERVER['HTTP_HOST'].'">click here for encrypted login</a>.';
				}
			}
			return $secure_connection;
		}
		
		/**
		 * Creates a Security token to secure a form against XSRF.
		 */
		public static function CreateSecurityToken()
		{
			$token = md5(utf8_encode(UUID::Create()));
			return $_SESSION['Sup3r5ecretSecur!peT0k3n'] = $token;
		}
		
		/**
		 * Checks a Security token against the token stored in the users session.
		 */
		public static function CheckSecurityToken($token)
		{
			return Value::SetAndEquals($token, $_SESSION, 'Sup3r5ecretSecur!peT0k3n');
		}
	}
	
	class _string
	{
		/**
		 * Sanitizes a string, by encoding potentially malicious characters. 
		 * @param string, The string value to sanitize.
		 * @param keephtml, Disables the HTML part of the sanitization (not reccomended).
		 */
		public static function Sanitize($string, $keephtml = false)
		{
			$string = addslashes($string);
			//if ($keephtml == false) { htmlspecialchars($string); } // Changed to htmlentities
			if ($keephtml == false) { htmlentities($string); }
			_string::EnforceProperLineEndings($string);
			return $string;
		}
		
		/**
		 * Unserializes a serialized object from a string.
		 * @param text, the string of the serialized object.
		 */
		public static function Unserialize($text)
		{
			return unserialize(gzuncompress(base64_decode($text)));
		}
		
		/**
		 * Serializes an object into a string.
		 * @param object, the object to serialize.
		 */
		public static function Serialize($object)
		{
			return base64_encode(gzcompress(serialize($object)));
		}
		
		/**
		 * Find a string inside another string (customized strstr to include multiple needles)
		 * @param haystack, string to look in
		 * @param needles, string or string[] to look for
		 */
		public static function StringInString($haystack, $needles)
		{
			$result = false;
			
			if (is_string($needles)) { $result = strstr($haystack, $needles); }
			elseif (is_array($needles))
			{
				$i = 0;
				while ($result == false && $i < sizeof($needles))
				{
					if (is_string($needles[$i]) && strstr($haystack, $needles[$i])) { $result = true; }
					$i++;
				}
			}
			
			return $result;
		}
		public static function strstr($a,$b) { return _string::StringInString($a,$b); }
		
		/**
		 * Removes a text from the beginning of another
		 * @param string, the string to look in.
		 * @param prefix, the prefix to remove.
		 */
		public static function RemovePrefix($string, $prefix)
		{
			if(strpos($string, $prefix) === 0) { $string = substr($string, strlen($prefix)).EMPTYSTRING; }
			return $string;
		}
		public static function strrempre($a,$b) { return _string::string_remove_prefix($a,$b); }
		
		/**
		 * Removes any Windows linebreaks (\r\n) and replaces them with proper UNIX linebreaks (\n).
		 * @param param, description.
		 */
		public static function EnforceProperLineEndings(& $string)
		{
			$improper_lineending = "\r\n";
			if (strstr($string, $improper_lineending)) { $string = str_replace($improper_lineending, NEWLINE, $string); }
			return $string;
		}
		
		/**
		 * Determines if a String starts with an upper case character
		 * @param string, The string to check.
		 */
		public static function StartsWithUpper($string)
		{
			$char = mb_substr($string, 0, 1, "UTF-8");
			return mb_strtolower($char, "UTF-8") != $char;
		}
		
		/**
		 * Determines if a String is one of the strings in a specified array
		 * @param array, The array to look in.
		 * @param string, The string to look for.
		 * @param out, If set will contain the key of the matched string.
		 */
		public static function IsOneOf($array, $string, &$out=null)
		{
			$result = false;
			if (is_array($array))
			{
				$result = in_array($string, $array);
				if ($out !== null) { $out = array_search($string, $array); }
			}
			return $result;
		}
		
		/**
		 * Checks if a string contains another string.
		 * @param haystack, string to look in.
		 * @param needles, string or string[] to look for
		 * @param match, (-1 = all needles must be in haystack) (0 = none) (# = # or more needles)
		 * @param out, If set will contain the key(s) of the matched string(s).
		 */
		public static function Contains($haystack, $needles, $match=-1, &$out=null)
		{
			$value = false;
			
			if (is_array($needles))
			{
				$matches = 0;
				if ($out !== null) { $out = array(); }
				for ($i = 0; $i < sizeof($needles); $i++)
				{
					$n = $needles[$i];
					if (strpos($haystack, $n) !== false)
					{
						$matches++;
						if ($out !== null) { $out[] = $i; }
					}
				}
				
				// IF match=-1(all), and all needles matched...
				if ($match == -1 && $matches == sizeof($needles)) $value = true;
				// OR match=0(none), and no matches...
				elseif ($match == 0 && $matches == 0) $value = true;
				// OR match=x(at least x), and more than x matches...
				elseif ($match > 0 && $matches >= $match) $value = true;
				// ...return true
				
				if (is_array($out) && sizeof($out) == 1) { $out = $out[0]; }
			} else {
				$value = ($out = strpos($haystack, $needles)) !== false;
			}
			
			return $value;
		}
		
		/**
		 * Checks if a string starts with a specified string.
		 * @param haystack, string to look in.
		 * @param needle, string to look for.
		 */
		public static function StartsWith($haystack, $needle)
		{
			return strpos($haystack, $needle) === 0;
		}
		
		/**
		 * Checks if a string ends with a specified string.
		 * @param haystack, string to look in.
		 * @param needle, string to look for.
		 */
		public static function EndsWith($haystack, $needle)
		{
			return strpos($haystack, $needle) === sizeof($haystack-1);
		}
		
		/**
		 * Checks if a string contains HTML tags
		 * @param string, the string to check.
		 */
		public static function HasTags($string)
		{
			return sizeof(preg_match_all('/(<([^>]+)>)/', $string)) > 0 ? true : false;
		}
		
		/**
		 * Strips all HTML tags from string
		 * @param string, the string to strip.
		 */
		public static function StripTags($string)
		{
			return preg_replace('/(<([^>]+)>)/', EMPTYSTRING, $string);
		}
		
		/**
		 * Shortens and ellipsizes a string
		 * @param string, the string to ellipsize.
		 * @param length, the length of the new string (incl. ellipsis).
		 */
		public static function Ellipsize($string, $length)
		{
			// TODO: consider making a constant ellipsize string ("...")
			$value = $string;
			if (is_string($string) && strlen($string) > $length)
			{
				$ellipsis = '...';
				$tmp = substr($string, 0, $length - sizeof($ellipsis));
				$value = substr($tmp, 0, strrpos($tmp, SINGLESPACE)).$ellipsis;
			}
			return $value;
		}
	}
	
	class HTML
	{
		/**
		 * Decodes encoded HTML characters in a text back to HTML evaluated characters.
		 * @param text, The text to decode.
		 */
		public static function Decode($text)
		{
			return str_replace(array('\n', '\t'), array(NEWLINE, INDENT), htmlspecialchars_decode($text));
		}
		
		/**
		 * Encodes HTML characters in a text.
		 * @param text, The text to encode.
		 */
		public static function Encode($text)
		{
			return htmlspecialchars(str_replace(array(NEWLINE, INDENT), array('\n', '\t'), $text));
		}
	}
	
	class File
	{
		/**
		 * Logs HTML output to a file (for debugging)
		 * @param output, HTML to write to file.
		 */
		public static function LogOutput($output)
		{
			Log::WriteToFile('output.txt', $output, true);
		}
		
		/**
		 * Logs an error message to the errorlog file
		 * @param message, The error message to append to the errorlog.
		 */
		public static function LogError($message) // Logs an error message to the log file
		{
			$_SESSION['MESSAGE'] = $message;
			Log::WriteToFile('errorlog.txt', $message);
		}
		
		/**
		 * Writes a string to a file
		 * @param file, The file to write.
		 * @param string, The string to write.
		 * @param overwrite, Whether the string should be appended to, or should overwrite the file.
		 */
		public static function WriteToFile($file, $string, $overwrite=false) // Writes a string to a file
		{
			if ($overwrite && file_exists($file)) { unlink($file); }
			$fp = fopen($file,'a');
			fwrite($fp,$string);
			fclose($fp);
		}
		
		/**
		 * Returns the given filesize in the closest byte denomination.
		 * @param $bytes, The filesize in bytes.
		 */
		public static function GetSize($bytes)
		{
			$value = '';
			if ($bytes < 1024) {
				$value = $bytes.' bytes';
			} else if ($bytes < 1048576) {
				$value = number_format(($bytes / 1024), 1, ',', '').' KB';
			} else {
				$value = number_format(($bytes / 1048576), 1, ',', '').' MB';
			}
			return $value;
		}
	}
	
	class Time
	{
		/**
		 * Returns a human readable time from a UNIX timestamp.
		 * @param timestamp, The timestamp to humanize.
		 * @param format, An optional format for the outputted string.
		 */
		public static function TimestampToHumanTime($timestamp, $format = false)
		{
			// TODO: ineffective, enhance using halfing technique. (N becomes N/2)
			
			$string = EMPTYSTRING;
			
			if ($timestamp != null)
			{
				$diff = STARTTIME - $timestamp;
				
				if (is_string($format) !== false) { $string .= date($format, $timestamp); }
				elseif ($diff > (ONEDAY + TODAYSTIME)) { $string .= date('\t\h\e dS \o\f F, Y \a\t H:i', $timestamp); }
				elseif ($diff > TODAYSTIME) { $string .= 'yesterday at '.date('H:i', $timestamp); }
				elseif ($diff > ONEHOUR) { $string .= 'today at '.date('H:i', $timestamp); }
				elseif ($diff > ONEMINUTE) {
					$plural = ''; if(intval($diff / ONEMINUTE) != 1) { $plural = 's';}
					$string .= intval($diff / ONEMINUTE).' minute'.$plural.' ago';
				}
				elseif ($diff > 0) {
					$plural = ''; if($diff != 1) { $plural = 's';}
					$string .= round($diff).' second'.$plural.' ago';
				}
				elseif ($diff == 0) { $string .= 'just now!'; }
				elseif ($diff > -ONEMINUTE) {
					$plural = ''; if($diff != -1) { $plural = 's';}
					$string .= 'in '.abs($diff).' second'.$plural;
				}
				elseif ($diff > -ONEHOUR) {
					$plural = ''; if(abs(intval($diff / ONEMINUTE)) != 1) { $plural = 's';}
					$string .= 'in '.abs(intval($diff / ONEMINUTE)).' minute'.$plural;
				}
				elseif ($diff > -ONEDAY) {
					$plural = ''; if(abs(intval($diff / ONEHOUR)) != 1) { $plural = 's';}
					$string .= 'in '.abs(intval($diff / ONEHOUR)).' hour'.$plural;
				}
				else {
					$plural = ''; if(abs(intval($diff / ONEDAY)) != 1) { $plural = 's';}
					$string .= 'in '.abs(intval($diff / ONEDAY)).' day'.$plural;
				}
			}
			
			return $string;
		}
	}
	
	class _bool
	{
		/**
		 * Display a boolean as "TRUE" or "FALSE", instead of "1" and "0".
		 * @param boolean, the boolean to display.
		 */
		public static function Display($boolean)
		{
			$value;
			if ($boolean == true || $boolean == 1 || $boolean == '1') { $value = 'true'; }
			elseif ($boolean == false || $boolean == 0 || $boolean == '0') { $value = 'false'; }
			else { $value = $boolean; }
			return $value;
		}
		
		/**
		 * "Flip" a boolean value to the opposite value
		 * @param boolean, the value to "flip".
		 */
		public static function Flip(&$boolean)
		{
			if (is_bool($boolean)) { $boolean = !$boolean; }
		}
	}
	
	class Value
	{
		/**
		 * description
		 * @param param, description.
		 */
		public static function SetAndNotNull($variable, $key=null)
		{
			if ($key != null && is_array($variable))
			{
				if (array_key_exists($key, $variable)) { $variable = $variable[$key]; }
				else { $variable = null; }
			}
			return (isset($variable) && $variable != null);
		}
		
		/**
		 * description
		 * @param param, description.
		 */
		public static function SetAndNotEmpty($variable, $key=null)
		{
			//var_dump($variable);
			if ($key != null && is_array($variable))
			{
				if (array_key_exists($key, $variable)) { $variable = $variable[$key]; }
				else { $variable = null; }
			}
			return (isset($variable) && !empty($variable));
		}
		
		/**
		 * description
		 * @param param, description.
		 */
		public static function SetAndEquals($value, $variable, $key=null, $checktype=false)
		{
			$result = false;
			if ($key != null && is_array($variable))
			{
				if (array_key_exists($key, $variable)) { $variable = $variable[$key]; }
				else { $variable = null; }
			}
			if ($checktype)	{ $result = (isset($variable) && $variable === $value); }
			else			{ $result = (isset($variable) && $variable == $value); }
			return $result;
		}
	}
	
	class _array
	{
		/**
		 * description
		 * @param param, description.
		 */
		public static function IsLongerThan($array, $size)
		{
			return is_array($array) && sizeof($array) > $size;
		}
		
		/**
		 * description
		 * @param param, description.
		 */
		public static function GetIdOf($array, $item)
		{
			return array_search($item, $array);
		}
		
		/**
		 * description
		 * @param param, description.
		 */
		public static function Remove(&$array, $index)
		{
			$result = false;
			if (is_array($array) && sizeof($array) > $index)
			{
				unset($array[$index]);
				$array = array_values($array);
				$result = true;
			}
			return $result;
		}
	}
	
	class URL
	{
		/**
		 * description
		 * @param param, description.
		 */
		public static function Append($url, $append)
		{
			$value = $url;
			
			if (is_array($append))
			{
				$array = $append;
				$append = EMPTYSTRING;
				foreach ($array as $item)
				{
					$append = URL::Append($append, $item);
				}
			}
			
			if (is_string($append))
			{
				if ($url != EMPTYSTRING && $append != EMPTYSTRING)
				{
					$slash = '/';
					$trailing = (substr($url, -1) == $slash);
					$preceding = (substr($append, 0, 1) == $slash);
					
					if ($trailing && $preceding) { $url = substr($url, 0, -1); $append = substr($append, 1); }
					elseif (!$trailing && !$preceding) { $value .= $slash; }
				}
				$value .= $append;
			}
			
			return $value;
		}
		
		/**
		 * description
		 * @param param, description.
		 */
		public static function LastFolder($url)
		{
			$pieces = explode(SINGLESLASH, $url);
			$last = sizeof($pieces) -1;
			$foldername = $pieces[$last];
			
			if ($foldername == EMPTYSTRING || _string::Contains($foldername, SINGLEDOT))
			{
				$foldername = $pieces[$last -1];
			}
			
			return $foldername;
		}
	}
	
	function vd($var)
	{
		var_dump($var);
	}
	
	function vdd($var)
	{
		var_dump($var);
		die(1);
	}
	
	abstract class TimeFormat
	{
		const HumanTime	= false;
		const Date			= 'D-M-Y';
		const DateTime	= 'd-m-y H:i';
		const Time			= 'H:i';
	}
	abstract class TF extends TimeFormat {}
}
?>
