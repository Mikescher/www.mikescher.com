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
        $fns = [
            $this->dir().'/snippet_hist.html',
            $this->dir().'/snippet_tier.html'
        ];

        foreach ($fns as $fn) {
            if (!file_exists($fn)) return ['result'=>'err', 'message' => 'File not found: ' . $fn];

            if (filemtime($fn) < time()-(10*24*60*60)) return ['result'=>'warn', 'message' => 'Rendered data is older than 10 days'];
        }

        return ['result' => 'ok', 'message' => ''];
    }

    public function getHistory(): string
    {
        $fn = $this->dir().'/snippet_hist.html';
        if (!file_exists($fn)) return '';

        return file_get_contents($fn);
    }

    public function getTierlist(): string
    {
        $fn = $this->dir().'/snippet_tier.html';
        if (!file_exists($fn)) return '';

        return file_get_contents($fn);
    }
}