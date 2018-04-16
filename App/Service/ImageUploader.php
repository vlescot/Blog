<?php 
namespace Service;

/**
 *		Upload and resize the images
 *		Put the images into the named directory (see $_img_params)
 *		Remove images into the named directory (see $_img_params)
 */
class ImageUploader
{
	/**
	 * Values are widths pixels.
	 * Keys are the destination folders into /Public/img/$_img_params[$key]
	 */
	private $_img_params = [
		'FullSize' 	=> null ,
		'Jumbotron' => 540, 
		'Table' 	=> 100, 
		'Input_File' => 270
	];
	private $_extensions_valid = ['jpg', 'jpeg', 'png'];
	private $_images_folder = '';

	
	function __construct ()
	{
		$this->_images_folder = $_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/Public/img/';
	}

	// Called in error case
	private function error ($message)
	{
		new Notification ($message);
		header('Location :' . $_SERVER['REQUEST_URI']);
		exit;
	}
	

	/**
	 * Check if this image is jpg, jpeg, png. 
	 * Then, upload it into FullSize path.
	 * @return $img_name if success, or Exception object on failure.
	 */
	function upload ()
	{
		$extension_upload = strtolower(substr(strrchr($_FILES['file']['name'],'.'),1));
		if (!in_array($extension_upload , $this->_extensions_valid)) {
			$this->error('Le fichier doit avoir l\'extension jpg, jpeg, ou png');
		}
		$img_name = md5(uniqid(rand(), true)); // Set a random name
		$img_fullname = $img_name . "." . $extension_upload;
		$destination_path = $this->_images_folder . key($this->_img_params) . "/" . $img_fullname;
		move_uploaded_file($_FILES['file']['tmp_name'], $destination_path);

		if ($this->resize($img_fullname, $destination_path, $extension_upload) === false) {
			$this->error('Nous avons rencontré un problème lors du redimensionnement de l\'image. Veuillez réessayer ou prendre contact avec nous');
		}
		return $img_fullname;
	}


	/**
	 * Format the image to optimize the loading page
	 * @return true on success or an array with the names of the failed images 
	 */
	private function resize ($img_fullname, $path_source, $extension_upload)
	{
		foreach ($this->_img_params as $folder => $width) {
			if ($width !== null) {
				$path_destination = $this->_images_folder . $folder . "/" . $img_fullname;
				// set dimensions of the image
				$imageSize 	= getimagesize($path_source);// [0]=>width (Original), [1]=>height (Original)
				$ratio 		= $imageSize[1]/$imageSize[0];
				$height 	= round ($width * $ratio);

				// creates a new image
				($extension_upload === 'png')? $imageRessource = imagecreatefrompng($path_source) : $imageRessource = imagecreatefromjpeg($path_source);
				$img_destination = imagecreatetruecolor($width, $height); // creates an empty miniature

				imagecopyresampled($img_destination, $imageRessource, 0, 0, 0, 0, $width, $height, $imageSize[0], $imageSize[1]);

				($extension_upload === 'png') ? $result = imagepng($img_destination, $path_destination) : $result = imagejpeg($img_destination, $path_destination);
				if ($result === false) return false;
			}
		}
	}


	/**
	 * Revome the images inside folders when updating the image of a post
	 * @return true on success or an array with the names of the failed images 
	 */
	function remove ($img_name){
		foreach ($this->_img_params as $folder => $v) {
			$result = unlink($this->_images_folder . $folder . "/" . $img_name);
			if ($result === false) $this->error('L\'image ' . $img_name . ' n\'as pas pu être supprimé du serveur');
		}
		return true;
	}
}
