<?php

$this->beginWidget('CMarkdown', array('purifyOutput'=>true));

echo $content;

$this->endWidget();