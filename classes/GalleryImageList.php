<?php

class GalleryImageList extends BaseList
{
	/* Es sind nur Objekte vom Typ IGalleryImage g�ltig */
	protected function getClassname()
	{
		return "IGalleryImage";
	}
}
?>