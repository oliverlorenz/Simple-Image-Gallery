<?php

class GalleryImageList extends BaseList
{
	/* Es sind nur Objekte vom Typ IGalleryImage gültig */
	protected function getClassname()
	{
		return "IGalleryImage";
	}
}
?>