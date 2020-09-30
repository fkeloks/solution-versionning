<?php

namespace ESGI\Controllers;

use ESGI\Core\Database\QueryBuilder;
use ESGI\Core\Tools\Cache;
use ESGI\Helpers\Route;
use ESGI\Models\AnnouncementsModel;
use ESGI\Models\PagesModel;

class SitemapController extends Controller
{
    /** @var array */
    private $urls = [];

    public function sitemapAction(): void
    {
        header('Content-Type: text/xml');
        $self = $this;

        echo Cache::remember('sitemap', static function () use ($self) {
            /** @var PagesModel[] $pages */
            $pages = PagesModel::fetchAll((new QueryBuilder)->where('status', '=', PagesModel::STATUS_PUBLISHED));
            foreach ($pages as $page) {
                $date = \DateTime::createFromFormat('Y-m-d H:i:s', $page->getUpdatedAt())->format('c');
                $self->addUrl($page->getPath(), $date, $page->getPath() === '/' ? '1.0' : '0.9');
            }

            $self->addUrl(url('auth.login'), null, '0.8');
            $self->addUrl(url('announcements.show'), null, '0.8');

            /** @var AnnouncementsModel[] $announcements */
            $announcements = AnnouncementsModel::fetchAll((new QueryBuilder)->where('status', '=', 1));
            foreach ($announcements as $announcement) {
                $date = \DateTime::createFromFormat('d/m/Y H:i', $announcement->getUpdatedAt())->format('c');
                $self->addUrl(url('announcements.show') . '/' . $announcement->getId(), $date, '0.7');
            }

            return $self->getSitemap();
        });
    }

    /**
     * Add url to sitemap
     *
     * @param string $path
     * @param string|null $date
     * @param string $priority
     */
    private function addUrl(string $path, ?string $date = null, string $priority = 'O.9'): void
    {
        if (is_null($date)) {
            $date = date('c');
        }

        if (strpos($path, 'http') !== 0) {
            $path = Route::getBaseUrl() . $path;
        }

        $this->urls[] = [
            'loc' => $path,
            'lastmod' => $date,
            'changefreq' => 'monthly',
            'priority' => $priority
        ];
    }

    private function getSitemap(): string
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');
        foreach ($this->urls as $urlAttributes) {
            $url = $xml->addChild('url');

            foreach ($urlAttributes as $attribute => $value) {
                $url->addChild($attribute, $value);
            }
        }

        return $xml->asXML();
    }
}
