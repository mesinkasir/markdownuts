<?php
// run 
// php generate_sitemap.php

require_once 'vendor/autoload.php';  // Pastikan Anda telah menginstal symfony/yaml melalui Composer
require_once 'functions.php';  // Pastikan file ini ada dan berisi fungsi getPost() dan getPosts()

use Symfony\Component\Yaml\Yaml;

function getConfig() {
    $configFile = 'config.yml';
    if (!file_exists($configFile)) {
        die("Error: config.yml file not found.\n");
    }
    return Yaml::parseFile($configFile);
}

function generateSitemap() {
    $config = getConfig();
    $baseUrl = $config['url'] ?? 'https://example.com';

    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');

    // Tambahkan halaman utama
    addUrlToSitemap($xml, $baseUrl, 'daily', '1.0');

    // Tambahkan halaman statis
    $staticPages = getPost(null, 'page');
    if (is_array($staticPages)) {
        foreach ($staticPages as $slug => $page) {
            $pageUrl = $baseUrl . '/page/' . $slug;
            $lastMod = file_exists('pages/' . $slug . '.md') ? date('Y-m-d', filemtime('pages/' . $slug . '.md')) : date('Y-m-d');
            addUrlToSitemap($xml, $pageUrl, 'weekly', '0.9', $lastMod);
        }
    } else {
        echo "Warning: No static pages found or error in getPost() function.\n";
    }

    // Ambil semua post
    $page = 1;
    do {
        $result = getPosts($page);
        if (isset($result['posts']) && is_array($result['posts'])) {
            foreach ($result['posts'] as $post) {
                $postUrl = $baseUrl . '/post/' . $post['slug'];
                $lastMod = file_exists('posts/' . $post['slug'] . '.md') ? date('Y-m-d', filemtime('posts/' . $post['slug'] . '.md')) : date('Y-m-d');
                addUrlToSitemap($xml, $postUrl, 'weekly', '0.8', $lastMod);
            }
            $page++;
        } else {
            echo "Warning: No posts found or error in getPosts() function.\n";
            break;
        }
    } while ($page <= ($result['totalPages'] ?? 0));

    // Simpan sitemap
    if ($xml->asXML('sitemap.xml')) {
        echo "Sitemap generated successfully!\n";
    } else {
        echo "Error: Unable to save sitemap.xml\n";
    }
}

function addUrlToSitemap($xml, $loc, $changefreq, $priority, $lastmod = null) {
    $url = $xml->addChild('url');
    $url->addChild('loc', $loc);
    if ($lastmod) {
        $url->addChild('lastmod', $lastmod);
    }
    $url->addChild('changefreq', $changefreq);
    $url->addChild('priority', $priority);
}

// Panggil fungsi untuk menghasilkan sitemap
generateSitemap();
