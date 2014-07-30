<?php
/* @var $this HighscoresController */
/* @var $game HighscoreGames */

for ($i = 0; $i < 50; $i++)
{
	print($game->ENTRIES[$i]->POINTS . '||' . htmlentities($game->ENTRIES[$i]->PLAYER) . "\r\n");
}