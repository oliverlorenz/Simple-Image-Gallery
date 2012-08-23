<?php

/*
 * Generiert Thumbnails
 */
class ThumbnailGenerator
{
	protected $sourcePath;
	protected $destinationPath;
	protected $maxHeight;
	protected $maxWidth;
	
	public function __construct($sourcePath, $maxWidth, $maxHeight)
	{
		
			$this->sourcePath = "data/" . $sourcePath;
			
			// Thumbnailpfad zusammenbauen
			$filename = strrchr($this->sourcePath, "/");
			$path = substr($this->sourcePath, 0, strlen($this->sourcePath) - strlen($filename));
			$thumbnailDirectory = $path . "/thumbnails/";
			
			if(!is_dir($thumbnailDirectory))
			{
				mkdir($thumbnailDirectory);
			}
			
			$this->destinationPath = $thumbnailDirectory . $filename;
			$this->maxWidth = $maxWidth;
			$this->maxHeight = $maxHeight;
		
	}
	
	/*
	 * Generiert das Thumbnail
	 */
	protected function generateThumbnail()
	{
		if(file_exists($this->sourcePath))
		{
			// Dateierweiterung auslesen
			$ext = strtolower(substr($this->sourcePath, strrpos($this->sourcePath, ".")) );
			
			// Derzeit kann der ThumbnailGenerator nur mit JPGs und PNGs umgehen
			if($ext == ".png")
			{
				$image = ImageCreateFromPNG($this->sourcePath);
			}
			else if(($ext == ".jpeg")||($ext == ".jpg"))
			{
				$image = ImageCreateFromJPEG($this->sourcePath);
			}
			
			// Originalausmaße auslesen
			$originalWidth = imagesx($image);
			$originalHeight = imagesy($image);
			
			// Verhältnisse auslesen
			$relationWidth = $this->maxWidth / $originalWidth;
			$relationHeight = $this->maxHeight / $originalHeight;
			
			// Schalter für Berrechnung
			if ($relationWidth <= $relationHeight)
			{
				$this->maxHeight = intval($originalHeight * $relationWidth);
			}
			else
			{
				$this->maxWidth = intval($originalWidth * $relationHeight);
			}
			
			// Thumbnail-Objekt erstellen und befüllen
			$thumbnail = ImageCreateTrueColor($this->maxWidth, $this->maxHeight);
			ImageCopyResampled($thumbnail, $image, 0, 0, 0, 0, $this->maxWidth, $this->maxHeight, $originalWidth, $originalHeight);
			
			// Abspeichern
			imagejpeg($thumbnail, $this->destinationPath);
			
			// Speicher wieder freigeben
			ImageDestroy($image);
			ImageDestroy($thumbnail);	
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/*
	 * Gibt den Pfad des Thumbnails zurück. Dabei wird bei Bedarf das Thumbnail erstellt
	 */
	public function getThumbnailPath()
	{
		if(!file_exists($this->destinationPath))
		{
			if(!$this->generateThumbnail())
			{
				return "data/noimage.jpg";
			}
		}
		
		return $this->destinationPath;
	}
}

?>
