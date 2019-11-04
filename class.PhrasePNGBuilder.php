<?php
require_once('class.Phrase.php');

class PhrasePNGBuilder
{
	private $textFont;
	private $authorFont;
	private $textSize;
	private $authorSize;
	private $text;
	private $author;

	private $spaceBelowText;
	private $offset;

	function __construct($textFont, $authorFont, $textSize = 12, $authorSize = 12, $backgroundColor = '#fff', $borderColor = '#000', $textColor = '#000', $authorColor = '#000')
	{
		$this->textFont = $textFont;
		$this->authorFont = $authorFont;
		$this->textSize = $textSize;
		$this->authorSize = $authorSize;
		$this->backgroundColor = $backgroundColor;
		$this->borderColor = $borderColor;
		$this->textColor = $textColor;
		$this->authorColor = $authorColor;

		$this->spaceBelowText = 5;
		$this->borderSize = 3;
		$this->padding = 5;		
		$this->text = '';
		$this->author = '';
	}

	private function colorFromHex($im, $hex)
	{
		$hex = str_replace('#', '', $hex);
		switch (strlen($hex)) {
			case 6:
				$red = substr($hex, 0, 2);
				$green = substr($hex, 2, 2);
				$blue = substr($hex, 4, 2);
				break;
			case 3:
				$red = str_repeat(substr($hex, 0, 1), 2);
				$green = str_repeat(substr($hex, 1, 1), 2);
				$blue = str_repeat(substr($hex, 2, 1), 2);
				break;
			default:
				$red = '0';
				$green = '0';
				$blue = '0';
				break;
		}
		return imagecolorallocate($im, hexdec($red), hexdec($green), hexdec($blue));
	}

	function phrase($phrase, $charactersPerLine = 0)
	{
		if ($charactersPerLine <= 0) $this->text = $phrase->phrase();
		else $this->text = wordwrap($phrase->phrase(), $charactersPerLine);
		$this->author = '-' . $phrase->author();
	}

	function build()
	{
		// Calculate text boundaries and position.
		$box = imagettfbbox($this->textSize, 0, $this->textFont, $this->text);
		$textWidth = $box[2] - $box[6];
		$textHeight = $box[3] - $box[7];
		$offset = $this->padding + $this->borderSize;
		$textX = -$box[6] + $offset;
		$textY = -$box[7] + $offset;

		// Calculate author boundaries and position.
		$box = imagettfbbox($this->authorSize, 0, $this->authorFont, $this->author);
		$authorWidth = $box[2] - $box[6];
		$authorHeight = $box[3] - $box[7];
		$authorX = -$box[6] + $offset;
		$authorY = -$box[7] + $textHeight + $this->spaceBelowText + $offset;

		// Calculate image size
		$imageWidth = max($textWidth, $authorWidth) + $offset * 2;
		$imageHeight = $textHeight + $this->spaceBelowText + $authorHeight + $offset * 2;
		$backgroundWidth = $imageWidth - 2 * ($this->borderSize - 1);
		$backgroundHeight = $imageHeight - 2 * ($this->borderSize - 1);
		// Signature is right aligned, so we have to recalculate it.
		// Offset is substracted twice because it was added before, and we want right alignment.
		$authorX = $imageWidth - $authorWidth + $authorX - 2 * $offset;

		// Create a black image.
		$im = imagecreatetruecolor($imageWidth, $imageHeight);

		// Create the colours to be used.
		$backgroundColor = $this->colorFromHex($im, $this->backgroundColor);
		$borderColor = $this->colorFromHex($im, $this->borderColor);
		$textColor = $this->colorFromHex($im, $this->textColor);
		$authorColor = $this->colorFromHex($im, $this->authorColor);

		// Draw the border.
		imagefilledrectangle($im, 0, 0, $imageWidth, $imageHeight, $borderColor);
		imagefilledrectangle($im, $this->borderSize, $this->borderSize, $backgroundWidth, $backgroundHeight, $backgroundColor);

		// Put the text and author. Coordinates are the lower left pixel of the first character.
		imagettftext($im, $this->textSize, 0, $textX, $textY, $textColor, $this->textFont, $this->text);
		imagettftext($im, $this->authorSize, 0, $authorX, $authorY, $authorColor, $this->authorFont, $this->author);

		return $im;
	}
}
