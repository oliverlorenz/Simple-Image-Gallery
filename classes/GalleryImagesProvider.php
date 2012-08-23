<?php

/*
 * Wandelt die Rohdaten einer Datenquelle in definierte Objekte um
 */
class GalleryImagesProvider implements IGalleryImagesProvider
{
	protected $dataSource;
	protected $images;
	public $imagesPerPage;
	
	public function __construct($dataSource)
	{
		// Es MUSS ein IDataSource angegeben sein!
		if($dataSource instanceof IDataSource)
		{
			$this->dataSource = $dataSource;
		}
		else
		{
			new Exception("Es wurde keine g�ltige Datenquelle �bergeben! Die Datenquelle muss vom Typ IDataSource sein!");
		}
		$this->images = array();
	}
	
	/*
	 * Gibt eine GalleryImagesList f�r eine Seite zur�ck;
	 */
	public function getPage($pageindex)
	{
		// Alle Bilder holen
		$sourceimages = $this->getImages();
		$imagescount = count($sourceimages);
		
		// Kleinsten und gr��ten Index ermitteln
		$smallestIndex = $pageindex * $this->imagesPerPage;
		$largestIndex = ($pageindex + 1) * $this->imagesPerPage;
		
		// Array f�r IGalleryImages vorbereiten
		$pageImages = new GalleryImageList();
		
		// Index korrigieren falls die letzte Seite nicht vollst�ndig bef�llt
		// werden kann
		if($largestIndex > $imagescount)
		{
			$largestIndex = $imagescount;
		}
		
		// Auslesen der Bilder
		for($index = $smallestIndex; $index < $largestIndex; $index++)
		{
			$image = $sourceimages[$index];
			if($image == null)
			{
				break;
			}
			$pageImages->add($image);
		}
		
		return $pageImages;
	}
	
	/*
	 * Gibt die Anzahl der Bilder zur�ck
	 */
	public function getCount()
	{
		return count($this->getImages());
	}
	
	/*
	 * Lie�t die Datenquelle aus und Wandelt die Rohdaten in GalleryImages um
	 */
	public function getImages()
	{
		// Diese Funktion nur ein mal ausf�hren
		if(count($this->images) == 0)
		{
			// Auslesen und umwandeln
			$data = $this->dataSource->getData();
			foreach($data as $rawImageData)
			{
				$path = $rawImageData[0];
				$title = $rawImageData[1];
				
				$imageObj = new GalleryImage();
				$imageObj->path = $path;
				$imageObj->title = $title;
				
				$this->images[] = $imageObj;
			}
		}
		
		// R�ckgabe
		return $this->images;
	}
}

?>