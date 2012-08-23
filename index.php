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
	
	// Datenquelle Initialisieren und GalleryImagesProvider übergeben
	$dataSource = new XmlDataSource("data/imageGallery01.xml");
	$galleryprovider = new GalleryImagesProvider($dataSource);
	
	// Intitalisieren des Views. Diesem wird nur noch der GalleryImagesProvider
	// und die gewünschte Anzahl von anzuzeigenden Bildern übergeben
	$gallery = new StandardImageGallery($galleryprovider, 9);
	
	// Um möglichst felxibel zu sein nutzt die seite ein einfaches HTML-Template
	$html = implode("",file("template/template.htm"));
	
	// Einfügen der Tabelle am entsprechenden Platzhalter
	$html = str_replace("{GALLERY}",$gallery->getHtml(), $html);
	
	// Ausgabe des gesamten HTML-Codes
	echo $html;
?>
