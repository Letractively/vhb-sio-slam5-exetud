<?php
class MonException extends Exception {
	/**
	 * Instancie une exception en rendant le message obligatoire, le code restant facultatif
	 * @param string $message
	 * @param number $code
	 */
	public function __construct($message, $code = 0) {
		parent::__construct($message, $code);
	}
	/**
	 * Retourne une représentation textuelle de l'exception réduite au message 
	   caractérisant l'exception
	 * @see Exception::__toString()
	 */
	public function __toString() {
		return $this->message;
	}
}
?>