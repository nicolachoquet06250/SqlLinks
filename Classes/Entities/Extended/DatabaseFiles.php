<?php

class DatabaseFiles {

	/**
	 * @param object $object
	 * @return string
	 */
	public function encode(stdClass $object): string {
		switch (get_class($this)) {
			case 'Json':
				return json_encode($object);
			case 'Xml':
				return $object->asXML();
			default:
				return json_encode($object);
		}
	}

	/**
	 * @param string $string
	 * @return array|stdClass|SimpleXMLElement
	 */
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

	/**
	 * @param $file
	 * @param $to_write
	 * @return bool
	 */
	public function write_in_file($file, $to_write) {
		$f = fopen($file, 'w+');
		fwrite($f, $to_write);
		fclose($f);
		return true;
	}

	/**
	 * @param $file
	 * @return bool|string
	 * @throws Exception
	 */
	public function read_file($file) {
		if(file_exists($file)) {
			return file_get_contents($file);
		}
		throw new Exception("Le fichier {$file} n'existe pas !");
	}
}