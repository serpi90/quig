<?php
require_once('config.php');
require_once('class.Phrase.php');
require_once('class.PhrasePNGBuilder.php');
require_once('loadPhrases.php');

$phrase = getPhrase();
$imageFile = $imagesFolder . '/' . $phrase->md5() . '.png';

// Dont create the image if it already exists.
if (!file_exists($imageFile)) {
	$pngBuilder = new PhrasePNGBuilder($textFont, $authorFont, $textSize, $authorSize, $backgroundColor, $borderColor, $textColor, $authorColor);
	$pngBuilder->phrase($phrase, $charactersPerLine);
	$image = $pngBuilder->build();
	// Save the image
	imagepng($image, $imageFile);
	// Unload resources.
	imagedestroy($image);
}

copy($imageFile, 'phrase.png');

echo $phrase;
