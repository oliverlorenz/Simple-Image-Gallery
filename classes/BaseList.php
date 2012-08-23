<?php

/*
 * Abstrakte Basisklasse f�r "Generisches" Array. Es L�sst nur Objekte einer
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
	
	// Gibt einen Wert zur�ck
	public function offsetGet($offset) 
	{
		return $this->data[$offset];
	}
	
	// Setzt einen Wert. Dabei k�nnen nur Objekte der definierten
	// Klasse hinzugef�gt werden 
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
	
	// Offset l�schen
	public function offsetUnset($offset) 
	{
		unset($this->data[$offset]);
	}
	
	// F�gt einen Wert hinzu.
	public function add($object)
	{
		$this->offsetSet(null,$object);
	}
	
	// Gibt alle Daten zur�ck
	public function getAllData()
	{
		return $this->data;
	}
}
?>