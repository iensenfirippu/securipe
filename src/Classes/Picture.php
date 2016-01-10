<?php
if ((defined('securipe') && extension_loaded('gd')) or exit(1))
{
	define('FULLIMAGEWIDTH', 800);
	define('FULLIMAGEHEIGHT', 800);
	define('FULLIMAGEQUALITY', 80);
	define('THUMBNAILWIDTH', 100);
	define('THUMBNAILHEIGHT', 100);
	define('THUMBNAILQUALITY', 90);
	
	class Picture
	{
		protected $_id = 0;
		protected $_filename = EMPTYSTRING;
		protected $_image = null;
		
		public function GetId() { return $this->_id; }
		public function GetFilename() { return $this->_filename; }
		public function GetFile() { return $this->_filename.'.jpeg'; }
		public function GetThumbnail() { return $this->_filename.'.jpg'; }
		private function GetPathFile() { return 'Images/'.$this->_filename.'.jpeg'; }
		private function GetPathThumbnail() { return 'Images/'.$this->_filename.'.jpg'; }
		public function GetImage() { return $this->_image; }
		
		public function SetFilename($value) { $this->_filename = $value; }
		public function SetImage($value) { if (is_a($value, 'Picture') || $value == null) { $this->_image = $value; } }
		
		public function __construct($filename=null)
		{
			if (Value::SetAndNotNull($filename)) {
				$this->_filename = $filename;
			} else {
				do { $this->_filename = UUID::Create(); }
				while (file_exists($this->GetPathFile()));
			}
		}
		
		public static function Load($id)
		{
			$result = false;
			if ($stmt = Database::GetLink()->prepare('SELECT `picture_name` FROM `Picture` WHERE `picture_id` = ?;')) {
				$stmt->bindParam(1, $id, PDO::PARAM_INT);
				$stmt->execute();
				$stmt->bindColumn(1, $filename);
				$stmt->fetch();
				$stmt->closeCursor();
				
				if ($filename != null) {
					$picture = new Picture($filename);
					$picture->_id = $id;
					
					$result = $picture;
				}
			}
			return $result;
		}
		
		/**
		 * Retrieve a FILES value as an image
		 * @param id, The name of the FILES value to retrieve.
		 */
		public static function LoadFileFromField($id)
		{
			$result = false;
			if (Picture::ValidateFile($id)) {
				$image = null;
				$mimetype = Picture::GetMimeType($_FILES[$id]['tmp_name']);
				
				if ($mimetype == 'image/jpeg') {
					$image = imagecreatefromjpeg($_FILES[$id]['tmp_name']);
				} elseif ($mimetype == 'image/png') {
					$image = imagecreatefrompng($_FILES[$id]['tmp_name']);
				} elseif ($mimetype == 'image/gif') {
					$image = imagecreatefromgif($_FILES[$id]['tmp_name']);
				}
				
				if (Value::SetAndNotNull($image)) {
					$picture = new Picture();
					$picture->_image = $image;
					$result = $picture;
				}
			}
			return $result;
		}
		
		public function Save()
		{
			$result = false;
			
			// Save image file and thumbnail
			if ($this->_image != null) {
				if ($this->WriteImage($this->GetPathFile(), FULLIMAGEWIDTH, FULLIMAGEHEIGHT, FULLIMAGEQUALITY) &&
					$this->WriteImage($this->GetPathThumbnail(), THUMBNAILWIDTH, THUMBNAILHEIGHT, THUMBNAILQUALITY)) {
					
					// ...then save the name and id in the database
					if ($stmt = Database::GetLink()->prepare('INSERT INTO `Picture` (`picture_name`) VALUES (?);')) {
						$stmt->bindParam(1, $this->_filename, PDO::PARAM_STR, 255);
						if ($stmt->execute()) {
							$this->_id = Database::GetLink()->lastInsertId();
							$result = true;
						}
						$stmt->closeCursor();
					}
				}
			}
			return $result;
		}
		
		public function Delete()
		{
			$result = false;
			
			// Delete the image in the database
			if ($stmt = Database::GetLink()->prepare('DELETE FROM `Picture` WHERE `picture_id`=?;')) {
				$stmt->bindParam(1, $this->_id, PDO::PARAM_INT);
				if ($stmt->execute()) {
					// ...then delete the image files
					if ($this->DeleteImageFiles()) {
						$result = true;
					}
				}
				$stmt->closeCursor();
			}
			return $result;
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
		
		public function GenerateThumbnail()
		{
			if ($this->_image != null) {
				$this->WriteImage($this->GetLocalThumb(), THUMBNAILWIDTH, THUMBNAILHEIGHT, THUMBNAILQUALITY);
			}
		}
		
		private function WriteImage($filename, $width, $height, $quality)
		{
			$result = false;
			if ($this->_image != null) {
				$dims = Picture::GetDimensions($this->_image, $width, $height);
				$tmp_img = imagecreatetruecolor($dims['newwidth'], $dims['newheight']);
				$white = imagecolorallocate($tmp_img,  255, 255, 255);
				imagefilledrectangle($tmp_img, 0, 0, $dims['width'], $dims['height'], $white);
				imagecopyresampled($tmp_img, $this->_image, 0, 0, 0, 0, $dims['newwidth'], $dims['newheight'], $dims['width'], $dims['height']);
				imagejpeg($tmp_img, $filename, $quality);
				
				$result = file_exists($filename);
			}
			return $result;
		}
		
		private function DeleteImageFiles()
		{
			$result = false;
			$file1 = $this->GetPathFile();
			$file2 = $this->GetPathThumbnail();
			if ((!file_exists($file1) || unlink($file1))  &&
				(!file_exists($file2) || unlink($file2)) ) {
				$result = true;
			}
			return $result;
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