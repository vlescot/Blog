<?php 
namespace Service;

/**
 *		Upload and resize the images
 */
class ImageUploader
{
	private $extensions_valid = ['jpg', 'jpeg', 'png'];
	//Values are widths pixels. Keys are the destination folders used in the respective URL : /blog/article/$id/, /blog/, /admin/article/, /admin/article/$article_id/
	private $img_params = ['FullSize' => null ,'Jumbotron' => 540, 'Table' => 100, 'Input_File' => 270];
	private $images_folder = '';


	function __construct ()
	{
		$this->images_folder = $_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/Public/img/';
	}


	/**
	 * Check if this image is jpg, jpeg, png. 
	 * Then, upload it into FullSize path.
	 * @return $img_name if success, or Exception object on failure.
	 */
	function upload ()
	{
		$extension_upload = strtolower(substr(strrchr($_FILES['file']['name'],'.'),1));
		if (!in_array($extension_upload , $this->extensions_valid)) {
			/**
			 * Exception => Format de fichier non pris en compte
			 */
			die;
		}
		$img_name = md5(uniqid(rand(), true)); // Set a random name
		$img_fullname = $img_name . "." . $extension_upload;
		$destination_path = $this->images_folder . key($this->img_params) . "/" . $img_fullname;
		move_uploaded_file($_FILES['file']['tmp_name'], $destination_path);

		if (!$this->resize($img_fullname, $destination_path, $extension_upload)) {
			/**
			 * Exception => Nous avons rencontrés un problème lors du chargement
			 */
			die;
		}
		return $img_fullname;
	}


	/**
	 * Format the image with anothers dimensions
	 * @return true on success or an array with the names of the failed images 
	 */
	private function resize ($img_fullname, $path_source, $extension_upload)
	{
		$error = [];
		foreach ($this->img_params as $folder => $width) {
			if ($width !== null) {
				$path_destination = $this->images_folder . $folder . "/" . $img_fullname;
				// set dimensions of the image
				$imageSize 	= getimagesize($path_source);// [0]=>width (Original), [1]=>height (Original)
				$ratio 		= $imageSize[1]/$imageSize[0];
				$height 	= round ($width * $ratio);

				// creates a new image
				($extension_upload === 'png')? $imageRessource = imagecreatefrompng($path_source) : $imageRessource = imagecreatefromjpeg($path_source);
				$img_destination = imagecreatetruecolor($width, $height); // creates an empty miniature

				imagecopyresampled($img_destination, $imageRessource, 0, 0, 0, 0, $width, $height, $imageSize[0], $imageSize[1]);
				($extension_upload === 'png') ? $result = imagepng($img_destination, $path_destination) : $result = imagejpeg($img_destination, $path_destination);

				if ($result === false) $error[] = $img_fullname;
			}
		}

		if (!empty($error)) {
			// Exception
		}
		else return true;
	}


	/**
	 * Revome the images inside folders
	 * @return true on success or an array with the names of the failed images 
	 */
	function remove ($img_name){
		$error = [];
		foreach ($this->img_params as $folder => $v) {
			$result = unlink($this->images_folder . $folder . "/" . $img_name);
			if ($result === false) $error[] = $img_name;
		}
		if (!empty($error)) {
			// Exception
		}
		else return true;		
	}
}
