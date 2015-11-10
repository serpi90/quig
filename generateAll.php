<?php
require_once('config.php');
require_once('class.Phrase.php');
require_once('class.PhrasePNGBuilder.php');
require_once('loadPhrases.php');

$pngBuilder = new PhrasePNGBuilder( $textFont, $authorFont, $textSize, $authorSize );
$counter = 0;

foreach( getPhrases( ) AS $phrase ) {
	$text = wordwrap( $phrase->phrase( ), $charactersPerLine );
	$author = $phrase->author( );

	$hash = $phrase->md5( );
	$imageFile = $imagesFolder.'/'.$hash.'.png';

	$pngBuilder->phrase( $phrase, $charactersPerLine );
	$image = $pngBuilder->build();
	// Save the image
	imagepng( $image, $imageFile );
	// Unload resources.
	imagedestroy( $image );

	$counter++;
}

echo "Generated {$counter} phrases as png files";
?>

