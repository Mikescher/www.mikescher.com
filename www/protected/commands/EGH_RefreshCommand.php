<?php

include 'ExtendedGitGraph.php';

class EGH_RefreshCommand extends CConsoleCommand
{
    public function run($args)
    {
        $v = new ExtendedGitGraph('Mikescher');

        $v->setSessionOutput(false);
        $v->setRawDataPath('/var/www/website/www/protected/data/git_graph_raw.dat');
        $v->setFinDataPath('/var/www/website/www/protected/data/git_graph_data.dat');
        $v->setToken(file_get_contents('/var/www/website/www/protected/commands/github.token.secret'));

        //##########################################################

        $v->addSecondaryUsername("Sam-Development");
        $v->addSecondaryRepository("Anastron/ColorRunner");

        //##########################################################

        //$v->setToken(file_get_contents('api_token.secret'));
        $v->collect();

        //##########################################################

        $v->generateAndSave();
    }
}