<?php

class EbookHistory implements IWebsiteModule
{
    /** @var Website */
    private $site;

    public function __construct(Website $site)
    {
        $this->site = $site;
    }

    public function dir(): string
    {
        return __DIR__ . '/../../dynamic/ehr/';
    }

    public function checkConsistency(): array
    {
        $fn = $this->dir().'/snippet.html';

        if (!file_exists($fn)) return ['result'=>'err', 'message' => 'File not found: ' . $fn];

        if (filemtime($fn) < time()-(10*24*60*60)) return ['result'=>'warn', 'message' => 'Rendered data is older than 10 days'];

        return ['result' => 'ok', 'message' => ''];
    }

    public function get(): string
    {
        $fn = $this->dir().'/snippet.html';
        if (!file_exists($fn)) return '';

        return file_get_contents($fn);
    }
}