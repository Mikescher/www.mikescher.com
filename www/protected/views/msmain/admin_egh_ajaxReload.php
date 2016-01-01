<?php

include 'extendedGitGraph.php';

$v = new ExtendedGitGraph('Mikescher');
$v->setSessionOutput(true);

//##########################################################

$v->addSecondaryUsername("Sam-Development");
$v->addSecondaryRepository("Anastron/ColorRunner");

//##########################################################

$v->setToken(file_get_contents('api_token.secret'));
$v->collect();

//##########################################################

$v->generateAndSave();