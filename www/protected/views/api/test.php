<?php
/* @var $this APIController */

/* @var $gm HighscoreGames */
$gm = HighscoreGames::model()->findByPk(1);

echo nl2br(print_r( $gm->ENTRIES, true));
