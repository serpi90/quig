<?php
class Phrase
{
	private $phrase;
	private $author;

	public function __construct($phrase, $author)
	{
		$this->phrase = $phrase;
		$this->author = $author;
	}

	public function phrase()
	{
		return $this->phrase;
	}

	public function author()
	{
		return $this->author;
	}

	public function __toString()
	{
		return $this->phrase() . ' - ' . $this->author();
	}

	public function md5()
	{
		return md5($this->__toString());
	}
}
