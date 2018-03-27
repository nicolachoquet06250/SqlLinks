<?php

class DatabaseFiles {
	public function encode(object $object): string {
		switch (get_class($this)) {
			case 'Json':
				return json_encode($object);
			case 'Xml':
				return $object->asXML();
			default:
				return json_encode($object);
		}
	}

	public function decode(string $string) {
		switch (get_class($this)) {
			case 'Json':
				return json_decode($string);
			case 'Xml':
				return new SimpleXMLElement($string);
			default:
				return json_decode($string);

		}
	}
}