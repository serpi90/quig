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

	function __construct($textFont, $authorFont, $textSize, $authorSize)
	{
		$this->textFont = $textFont;
		$this->authorFont = $authorFont;
		$this->textSize = $textSize;
		$this->authorSize = $authorSize;
		$this->spaceBelowText = 5;
		$padding = 5;
		$this->offset = $padding + 1;
		$this->text = '';
		$this->author = '';
	}

	function phrase($phrase, $charactersPerLine = 0)
	{
		if ($charactersPerLine <= 0) {
			$this->text = $phrase->phrase();
		} else {
			$this->text = wordwrap($phrase->phrase(), $charactersPerLine);
		}
		$this->author = '-' . $phrase->author();
	}

	function build()
	{
		// Calculate text boundaries and position.
		$box = imagettfbbox($this->textSize, 0, $this->textFont, $this->text);
		$textWidth = $box[2] - $box[6];
		$textHeight = $box[3] - $box[7];
		$textX = -$box[6] + $this->offset;
		$textY = -$box[7] + $this->offset;

		// Calculate author boundaries and position.
		$box = imagettfbbox($this->authorSize, 0, $this->authorFont, $this->author);
		$authorWidth = $box[2] - $box[6];
		$authorHeight = $box[3] - $box[7];
		$authorX = -$box[6] + $this->offset;
		$authorY = -$box[7] + $textHeight + $this->spaceBelowText + $this->offset;

		// Calculate image size
		$imageWidth = max($textWidth, $authorWidth) + $this->offset * 2;
		$imageHeight = $textHeight + $this->spaceBelowText + $authorHeight + $this->offset * 2;

		// Signature is right aligned, so we have to recalculate it.
		// Offset is substracted twice because it was added before, and we want right alignment.
		$authorX = $imageWidth - $authorWidth + $authorX - 2 * $this->offset;

		// Create a black image.
		$im = imagecreatetruecolor($imageWidth, $imageHeight);

		// Create the clours to be used.
		$white = imagecolorallocate($im, 255, 255, 255);
		$blue = imagecolorallocate($im, 0, 0, 255);
		$black = imagecolorallocate($im, 0, 0, 0);

		// Draw the border.
		imagefilledrectangle($im, 0, 0, $imageWidth, $imageHeight, $black);
		imagefilledrectangle($im, 1, 1, $imageWidth - 2, $imageHeight - 2, $white);

		// Put the text and author. Coordinates are the lower left pixel of the first character.
		imagettftext($im, $this->textSize, 0, $textX, $textY, $blue, $this->textFont, $this->text);
		imagettftext($im, $this->authorSize, 0, $authorX, $authorY, $black, $this->authorFont, $this->author);

		return $im;
	}
}
