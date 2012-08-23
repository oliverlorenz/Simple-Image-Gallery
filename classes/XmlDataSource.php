<?php

/*
 * Datenquelle für die Galerie. In diesem Fall werden die Daten aus einer XML-Datei geholt
 */
class XmlDataSource implements IDataSource
{
	protected $xmlFile;
	protected $data;
	protected $simplexml;
	
	public function __construct($xmlFile)
	{
		// Prüfen ob die Datei existiert und den Inhalt in ein SimpleXmlElement parsen
		if(file_exists($xmlFile))
		{
			$this->xmlFile = $xmlFile;
			$this->simplexml = simplexml_load_file($this->xmlFile);
		}
		else
		{
			new Exception("Die XML-Datei " . $this->xmlFile . " ist nicht vorhanden!");
		}
	}
	
	/*
	 * Rückgabe der Rohdaten
	 */
	public function getData()
	{
		foreach($this->simplexml->children() as $child)
		{
			$attributes = $child->attributes();
			$data[] = array((string)$attributes["path"], (string)$attributes["title"]);
		}
		return $data;
	}
}

?>