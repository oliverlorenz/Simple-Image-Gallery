<?php

/*
 * View für eine Galerie-Seite
 */
class GalleryPage implements IView
{
	protected $images;
	protected $thumbnailGenerator;
	
	public function __construct($images)
	{
		if($images instanceof GalleryImageList)
		{
			$this->images = $images;
		}
		else
		{
		
		}
	}
	
	public function getHtml()
	{
		$html = "<ul class=\"images\">";
		
		foreach($this->images->getAllData() as $image)
		{
		
			// Thumbnail anzeigen
			$thumbnailGenerator = new ThumbnailGenerator($image->path, 140, 140);
			$imagepath = "data/" . $image->path;
			$html .= "<li class=\"\">";
			$html .= "<a target=\"_blank\" href=\"" . $imagepath . "\">";
			$html .= "<img src=\"" . $thumbnailGenerator->getThumbnailPath() . "\" alt=\"" . $image->title . "\" />";
			$html .= "<span class=\"title\">" . $image->title . "</span>";
			$html .= "</a>";
			$html .= "</li>";
		}
		$html .= "</ul>";
		return $html;
	}
}

?>