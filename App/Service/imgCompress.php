<form action="" method="POST" enctype="multipart/form-data">
	<input type="file">
	<input type="submit">
</form>

<?php
if ($est_present) 
{
// Pour chacun image non présente dans le dossier /Convert et présente dans SQL, l'image est convertis.
	$source ='C:/MAMP/Website/Eugenie/Photos/Copies/'. $img;
	$logo = imagecreatefrompng("C:/MAMP/Website/Eugenie/Photos/Copies/logo/logo.png");
	$destinationconvert ="C:/MAMP/Website/Eugenie/Photos/Copies/convert/". $img ;
	
	$fichier = "C:/MAMP/Website/Eugenie/params.ini";
	$ini_tableau = parse_ini_file($fichier);
// Pour largueur et hauteur, nous considérons que les photos sont prises en portrait
	$largueur = $ini_tableau["width"];
	$hauteur = $ini_tableau["height"];
	$quality = $ini_tableau["quality"];
	$transparence = $ini_tableau["transparence"];
		
		$imageSize = getimagesize($source);// [0]=>width, [1]=>height

		if ($imageSize[0] > $imageSize[1]) {
			$width = $hauteur;
			$height = $largueur;
		}
		else{$width = $largueur;
			$height = $hauteur;
		}
			$imageRessource = imagecreatefromjpeg($source);

			$imageFinal = imagecreatetruecolor($width, $height);

			imagecopyresampled($imageFinal, $imageRessource, 0, 0, 0, 0, $width, $height, $imageSize[0], $imageSize[1]);

			imagecopymerge($imageFinal, $logo, 0, 0, 0, 0, $width, $height, $transparence);

			imagejpeg($imageFinal, $destinationconvert , $quality);
		$img++;
}
else
{
	echo 'Cette photo "<strong>'. $img .'</strong>" ne trouve pas d\'enregistrement correspondant dans la base de données. Elle n\'as donc pas été convertis car ne pourra pas être affiché.</br>' ;
}