<?php

namespace internals\modules;
use IWebsiteModule;
use PDO;
use Throwable;
use Website;

class ProjectLawful implements IWebsiteModule
{
    /** @var Website */
    private $site;

    public $variants = [
        'avatars-moreinfo'               => 'project-lawful-avatars-moreinfo.epub',
        'avatars'                        => 'project-lawful-avatars.epub',
        'biggerhtml'                     => 'project-lawful-biggerhtml.epub',
        'inline'                         => 'project-lawful-inline.epub',
        'moreinfo'                       => 'project-lawful-moreinfo.epub',
        'onlymainstory-avatars-moreinfo' => 'project-lawful-onlymainstory-avatars-moreinfo.epub',
        'onlymainstory-avatars'          => 'project-lawful-onlymainstory-avatars.epub',
        'onlymainstory-biggerhtml'       => 'project-lawful-onlymainstory-biggerhtml.epub',
        'onlymainstory-inline'           => 'project-lawful-onlymainstory-inline.epub',
        'onlymainstory-moreinfo'         => 'project-lawful-onlymainstory-moreinfo.epub',
        'sfw-avatars-moreinfo'           => 'project-lawful-sfw-avatars-moreinfo.epub',
        'sfw-avatars'                    => 'project-lawful-sfw-avatars.epub',
        'sfw-biggerhtml'                 => 'project-lawful-sfw-biggerhtml.epub',
        'sfw-inline'                     => 'project-lawful-sfw-inline.epub',
        'sfw-moreinfo'                   => 'project-lawful-sfw-moreinfo.epub',
    ];

    public function __construct(Website $site)
    {
        $this->site = $site;
    }

    public function insertDownload($variant)
    {
        try
        {
            $this->site->modules->Database()->sql_query_assoc_prep('INSERT INTO projectlawful_downloadcounter (variant, ip, useragent) VALUES (:vr, :ip, :ua)',
            [
                [':vr', $variant,                           PDO::PARAM_STR],
                [':ip', get_client_ip(),                    PDO::PARAM_STR],
                [':ua', $_SERVER['HTTP_USER_AGENT'] ?? '',  PDO::PARAM_STR],
            ]);
            return true;
        }
        catch (Throwable $t)
        {
            return false;
        }
    }

    public function listDownloadCounts()
    {
        return $this->site->modules->Database()->sql_query_assoc('SELECT variant, COUNT(*) AS `count` FROM projectlawful_downloadcounter GROUP BY variant ORDER BY variant');
    }

    public function variantExists(string $variant)
    {
        return isset($this->variants[$variant]);
    }

    public function checkConsistency()
    {
        foreach ($this->variants as $key => $val) {
            $fn = __DIR__ . '/../../data/projectlawful/'.$val;
            if (!file_exists($fn)) {
                return ['result'=>'err', 'message' => 'File not found: ' . $fn];
            }
        }

        return ['result' => 'ok', 'message' => ''];
    }
}