<?php
if ((defined('securipe') && extension_loaded('gd')) or exit(1))
{
	define('FULLIMAGEWIDTH', 800);
	define('FULLIMAGEHEIGHT', 800);
	define('THUMBNAILWIDTH', 100);
	define('THUMBNAILHEIGHT', 100);
	
	class Image
	{
		protected $_name = EMPTYSTRING;
		protected $_image = null;
		
		public function GetName() { return $this->_name; }
		public function GetFileName() { return $this->_name.'.png'; }
		public function GetLocalFile() { return 'Images/'.$this->GetFileName(); }
		public function GetFileLink() { return '/'.$this->GetFileName(); }
		public function GetLocalThumb() { return 'Images/_'.$this->GetFileName(); }
		public function GetThumbLink() { return '/_'.$this->GetFileName(); }
		public function GetImage() { return $this->_image; }
		
		public function SetName($value) { $this->_name = $value; }
		public function SetImage($value) { $this->_image = $value; }
		
		public function __construct($name=null)
		{
			if (Value::SetAndNotNull($name)) {
				$this->_name = $name;
			} else {
				do { $this->_name = UUID::Create(); }
				while (file_exists($this->GetLocalFile()));
			}
		}
		
		private static function GetMimeType($image)
		{
			/*$mimetype = false;
			$fileinfo = pathinfo($this->_image);
			if (_string::IsOneOf(array('ignore', 'file', 'ext'), strtolower($fileinfo['extension']))) { }
			if (strtolower($fileinfo['extension']) == 'svg') { $mimetype = 'image/svg'; }
			else { $mimetype = getimagesize($this->_image)["mime"]; }
			return $mimetype;*/
			return getimagesize($image)["mime"];
		}
		
		private static function ValidateFile($id)
		{
			$result = true;
			
			if (isset($_FILES[$id]) && !empty($_FILES[$id])) {
				// Check file size (<10MiB)
				if ($_FILES[$id]["size"] > 10485760) {
					$result = false;
				}
				
				// Allow certain file formats
				$imageFileType = pathinfo($_FILES[$id]["name"], PATHINFO_EXTENSION);
				if ($imageFileType != "jpg" && $imageFileType != "png" &&
					$imageFileType != "jpeg" && $imageFileType != "gif" ) {
					$result = false;
				}
			} else {
				$result = false;
			}
			
			return $result;
		}
		
		public function Load($id)
		{
			if (Image::ValidateFile($id))
			{
				$image = null;
				$mimetype = Image::GetMimeType($_FILES[$id]['tmp_name']);
				
				if ($mimetype == 'image/jpeg') {
					$image = imagecreatefromjpeg($_FILES[$id]['tmp_name']);
				} elseif ($mimetype == 'image/png') {
					$image = imagecreatefrompng($_FILES[$id]['tmp_name']);
				} elseif ($mimetype == 'image/gif') {
					$image = imagecreatefromgif($_FILES[$id]['tmp_name']);
				}
				
				if (Value::SetAndNotNull($image)) {
					$this->_image = $image;
				}
			}
		}
		
		public function Save()
		{
			if ($this->_image != null) {
				$this->WriteImage($this->GetLocalFile(), FULLIMAGEWIDTH, FULLIMAGEHEIGHT);
			}
		}
		
		public function GenerateThumbnail()
		{
			if ($this->_image != null) {
				$this->WriteImage($this->GetLocalThumb(), THUMBNAILWIDTH, THUMBNAILHEIGHT);
			}
		}
		
		private function WriteImage($filename, $width, $height)
		{
			if ($this->_image != null) {
				$dims = Image::GetDimensions($this->_image, $width, $height);
				$tmp_img = imagecreatetruecolor($dims['newwidth'], $dims['newheight']);
				$white = imagecolorallocate($tmp_img,  255, 255, 255);
				imagefilledrectangle($tmp_img, 0, 0, $dims['width'], $dims['height'], $white);
				imagecopyresampled($tmp_img, $this->_image, 0, 0, 0, 0, $dims['newwidth'], $dims['newheight'], $dims['width'], $dims['height']);
				imagejpeg($tmp_img, $filename, 90);
			}
		}
		
		private static function GetDimensions($image, $preferredwidth, $preferredheight)
		{
			$value = array();
			$value['width'] = imagesx($image);
			$value['height'] = imagesy($image);
			
			if ($value['width'] > $value['height']) {
				$value['newwidth'] = $preferredwidth;
				$value['newheight'] = intval(floor($value['height'] * ($preferredwidth / $value['width'])));
			} else {
				$value['newwidth'] = intval(floor($value['width'] * ($preferredheight / $value['height'])));
				$value['newheight'] = $preferredheight;
			}
			
			if ($value['width'] < $value['newwidth'] && $value['height'] < $value['newheight']) {
				$value['newwidth'] = $value['width']; $value['newheight'] = $value['height'];
			}
			
			return $value;
		}
	}
}
?>