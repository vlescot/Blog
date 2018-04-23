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
    private static $img_params = [
        'Fullsize' 	=> null ,
        'Jumbotron' => 270,
        'Table' 	=> 100,
    ];
    private static $extensions_valid = ['jpg', 'jpeg', 'png'];
    private $_images_folder = '';
    private $_max_size = 3;

    
    public function __construct()
    {
        $this->_images_folder = ROOT . 'Public/img/';
    }

    /**
     * Called in error case
     * @param  string $message The message for notification
     */
    private function error($message)
    {
        new Notification($message);
        header('Location :' . $_SERVER['REQUEST_URI']);
    }
    

    /**
     * Check if this image is jpg, jpeg, png.
     * Then, upload it into FullSize path.
     * @return $img_name if success, or Exception object on failure.
     */
    public function upload()
    {
        $extension_upload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));

        // Set a random name for the file
        $img_name = md5(uniqid(rand(), true));
        $img_fullname = $img_name . "." . $extension_upload;
        $destination_path = $this->_images_folder . key(self::$img_params) . "/" . $img_fullname;
        move_uploaded_file($_FILES['file']['tmp_name'], $destination_path);

        // Checks the size of the file
        if ($_FILES['file']['size'] / 1048576 > $this->_max_size) {
            $this->error('Le fichier ne doit pas dépasser un poid de ' . $this->_max_size . ' Mo');
        }
        // Check the extension of the file
        elseif (!in_array($extension_upload, self::$extensions_valid)) {
            $this->error('Le fichier doit avoir l\'extension jpg, jpeg, ou png');
        }
        // Check if resizing returns error
        elseif ($this->resize($img_fullname, $destination_path, $extension_upload) === false) {
            $this->error('Nous avons rencontré un problème lors du redimensionnement de l\'image. Veuillez réessayer ou prendre contact avec nous');
        }
        // No error
        else {
            return $img_fullname;
        }
    }


    /**
     * Format the image to optimize the loading page
     * @return true on success or an array with the names of the failed images
     */
    private function resize($img_fullname, $path_source, $extension_upload)
    {
        foreach (self::$img_params as $folder => $width) {
            if ($width !== null) {
                $path_destination = $this->_images_folder . $folder . "/" . $img_fullname;
                // set dimensions of the image
                $imageSize 	= getimagesize($path_source);// [0]=>width (Original), [1]=>height (Original)
                $ratio 		= $imageSize[1]/$imageSize[0];
                $height 	= round($width * $ratio);

                // creates a new image
                ($extension_upload === 'png')? $imageRessource = imagecreatefrompng($path_source) : $imageRessource = imagecreatefromjpeg($path_source);
                $img_destination = imagecreatetruecolor($width, $height); // creates an empty miniature

                imagecopyresampled($img_destination, $imageRessource, 0, 0, 0, 0, $width, $height, $imageSize[0], $imageSize[1]);

                ($extension_upload === 'png') ? $result = imagepng($img_destination, $path_destination) : $result = imagejpeg($img_destination, $path_destination);
                if ($result === false) {
                    return false;
                }
            }
        }
    }


    /**
     * Revome the images inside folders when updating the image of a post
     * @return true on success or an array with the names of the failed images
     */
    public function remove($img_name)
    {
        $errors = [];
        foreach (self::$img_params as $folder => $v) {
            $result = unlink($this->_images_folder . $folder . "/" . $img_name);
            if ($result === false) {
                array_push($errors, $img_name);
            }
        }
        if (!empty($errors)) {
            foreach ($error as $img_name) {
                $this->error('L\'image ' . $img_name . ' n\'as pas pu être supprimé du serveur');
            }
        } else {
            return true;
        }
    }
}
