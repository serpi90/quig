<?php
require_once('config.php');
require_once('class.Phrase.php');
require_once('class.PhrasePNGBuilder.php');
require_once('loadPhrases.php');

$pngBuilder = new PhrasePNGBuilder($textFont, $authorFont, $textSize, $authorSize);
$counter = 0;

// Generate images for all phrases that have not been generated before
foreach (getPhrases() as $phrase) {
	$text = wordwrap($phrase->phrase(), $charactersPerLine);
	$author = $phrase->author();

	$hash = $phrase->md5();
	$imageFile = $imagesFolder . '/' . $hash . '.png';

	if (!file_exists($imageFile)) {
		$pngBuilder->phrase($phrase, $charactersPerLine);
		$image = $pngBuilder->build();
		// Save the image
		imagepng($image, $imageFile);
		// Unload resources.
		imagedestroy($image);
		$counter++;
	}
}

echo "Generated {$counter} phrases as png files, current is: {$phrase}";
