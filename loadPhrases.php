<?php
require_once('class.Phrase.php');

define('PHRASE', 1);
define('AUTHOR', 2);

function getPhrases()
{
	// You should populate this list however you want.
	return array(
		new Phrase('A central lesson of science is that to understand complex issues (or even simple ones), we must try to free our minds of dogma and to guarantee the freedom to publish, to contradict, and to experiment. Arguments from authority are unacceptable.', 'Carl Sagan'),
		new Phrase('All life is nucleic acid; the rest is commentary', 'Isaac Asimov'),
		new Phrase('Anyone who is capable of getting themselves made President should on no account be allowed to do the job', 'Douglas Adams'),
		new Phrase('It is a well-known fact that those people who must want to rule people are, ipso facto, those least suited to do it', 'Douglas Adams'),
		new Phrase('Frankly, my dear, I don\'t give a damn.', 'Rhett Butler'),
		new Phrase('I\'m going to make him an offer he can\'t refuse.', 'Vito Corleone'),
		new Phrase('May the Force be with you.', 'Han Solo')
	);
}

function getPhrase()
{
	$phrases = getPhrases();
	return $phrases[array_rand($phrases)];
}
