<?php

/*
 * Abstrakte Basisklasse für "Generisches" Array. Es Lässt nur Objekte einer
 * bestimmten Klasse an
 */
abstract class BaseList implements ArrayAccess 
{
	private $data = array();
	
	// Muss von der erbenden Klasse implementiert werden
	protected abstract function getClassname();
	
	// Kontrolliert ob ein Offset existiert
	public function offsetExists($offset) 
	{
		return array_key_exists($this->data, $offset);
	}
	
	// Gibt einen Wert zurück
	public function offsetGet($offset) 
	{
		return $this->data[$offset];
	}
	
	// Setzt einen Wert. Dabei können nur Objekte der definierten
	// Klasse hinzugefügt werden 
	public function offsetSet($offset, $value) 
	{
		$classname = $this->getClassname();
		if(!($value instanceof $classname))
		{
			new Exception("Die Liste kann nur Elemente vom Typ '" . $this->getClassname() . "' aufnehmen!");
		}
		
		if (is_null($offset)) 
		{
			$this->data[] = $value;
		} 
		else 
		{
			$this->data[$offset] = $value;
		}
	}
	
	// Offset löschen
	public function offsetUnset($offset) 
	{
		unset($this->data[$offset]);
	}
	
	// Fügt einen Wert hinzu.
	public function add($object)
	{
		$this->offsetSet(null,$object);
	}
	
	// Gibt alle Daten zurück
	public function getAllData()
	{
		return $this->data;
	}
}
?>