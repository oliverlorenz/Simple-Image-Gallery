<?php

/*
 * Gallerie-Objekt
 */
class StandardImageGallery implements IImageGallery, IView
{
	protected $galleryProvider;
	protected $imagesPerPage;
	protected $page;
	protected $pageImages;
	
	public function __construct($galleryProvider, $imagesPerPage = 3)
	{
		// Es MUSS ein IGalleryImagesProvider übergeben werden!
		if($galleryProvider instanceof IGalleryImagesProvider)
		{
			$this->galleryProvider = $galleryProvider;
			$this->galleryProvider->imagesPerPage = $imagesPerPage;
		}
		else
		{
			new Exception("Es muss ein IGalleryImagesProvider übergeben!");
		}
		
		$this->imagesPerPage = $imagesPerPage;
		
		// Anzuzeigende Seite festlegen
		if(isset($_GET["page"]) && ctype_digit($_GET["page"]))
		{
			$this->page = $_GET["page"];
		}
		else
		{
			$this->page = 0;
		}
	}
	
	/*
	 * Gibt das HTML zurück
	 */
	public function getHtml()
	{
		// Bilder der Seite laden
		$this->pageImages = $this->galleryProvider->getPage($this->page);
		
		// Das Rendern der Seite auslagern
		$galleryPage = new GalleryPage($this->pageImages);
		
		// Galerie über einfaches Template zusammenbauen und Stringersetzungen durchführen
		$html = implode("",file("template/standardgallery.htm"));
		$html = str_replace("{PAGE}",$this->page, $html);
		$html = str_replace("{IMAGESCOUNT}",$this->galleryProvider->getCount(), $html);
		$html = str_replace("{IMAGESPERPAGE}",$this->imagesPerPage, $html);
		$html = str_replace("{IMAGES}", $galleryPage->getHtml(), $html);
		$html = str_replace("{NAVIGATION}", $this->getNavigation(), $html);
		return $html;
	}
	
	/*
	 * Baut das HTML der Navidation zusammen
	 */
	protected function getNavigation()
	{
		$html = "";
		
		// Zurück-Button
		if($this->page == 0)
		{
			$html .= "<span class=\"button previousbutton\">Zur&uuml;ck</span>";
		}
		else
		{
			$html .= "<a href=\"index.php?page=" . ($this->page - 1) . "\" class=\"button previousbutton\">Zur&uuml;ck</a>";
		}
		
		// Weiter-Button
		if(count($this->pageImages->getAllData()) < $this->imagesPerPage)
		{
			$html .= "<span class=\"button nextbutton\">Weiter</span>";
		}
		else
		{
			$html .= "<a href=\"index.php?page=" . ($this->page + 1) . "\" class=\"button nextbutton\">Weiter</a>";
		}
		
		return $html;
	}
}

?>
