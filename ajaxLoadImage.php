<?php
	// Einbinden der notwendigen Klassen
	require_once("classes/IView.php");
	require_once("classes/IDataSource.php");
	require_once("classes/BaseList.php");
	require_once("classes/GalleryImageList.php");
	require_once("classes/XmlDataSource.php");
	require_once("classes/IGalleryImage.php");
	require_once("classes/GalleryImage.php");
	require_once("classes/GalleryPage.php");
	require_once("classes/IImageGallery.php");
	require_once("classes/IGalleryImagesProvider.php");
	require_once("classes/GalleryImagesProvider.php");
	require_once("classes/StandardImageGallery.php");
	require_once("classes/ThumbnailGenerator.php");
	
if(isset($_POST["page"]) && isset($_POST["imagesPerPage"]) && ctype_digit($_POST["page"]) && ctype_digit($_POST["imagesPerPage"]))
{
	// Daten auslesen
	$page = $_POST["page"];
	$imagesPerPage = $_POST["imagesPerPage"];
	
	// Gleiches Prinzip wie in der index.php:
	// Datenquelle Initialisieren und GalleryImagesProvider übergeben
	$dataSource = new XmlDataSource("data/imageGallery01.xml");
	$galleryProvider = new GalleryImagesProvider($dataSource);
	
	// Anzahl der Bilder pro Seite setzen
	$galleryProvider->imagesPerPage = $imagesPerPage;
	
	// Page rendern und ausgeben. Dieser Content wird dann per AJAX in die Galerie geladen
	$galleryPage = new GalleryPage($galleryProvider->getPage($page));
	echo $galleryPage->getHtml();
}
?>
