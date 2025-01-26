<?php
require_once 'Parsedown.php';
require_once 'vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

if (!function_exists('getConfig')) {
    function getConfig() {
        static $config = null;
        if ($config === null) {
            $configFile = __DIR__ . '/config.yml';
            if (!file_exists($configFile)) {
                throw new Exception('Config file not found');
            }
            $config = Yaml::parseFile($configFile);
        }
        return $config;
    }
}


function getPosts($page = 1) {
    $config = getConfig();
    $perPage = $config['posts_per_page'] ?? 5;  
    $postOrder = $config['post_order'] ?? 'date_desc';

    $files = glob('posts/*.md');

    if ($postOrder === 'date_asc') {
        usort($files, function($a, $b) {
            return filemtime($a) - filemtime($b);
        });
    } else {  
        usort($files, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
    }
    
    $totalPosts = count($files);
    $totalPages = ceil($totalPosts / $perPage);
    $start = ($page - 1) * $perPage;
    $paginatedFiles = array_slice($files, $start, $perPage);
    
    $posts = [];
    foreach ($paginatedFiles as $file) {
        $posts[] = getPost(basename($file, '.md'));
    }
    
    return [
        'posts' => $posts,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'postsPerPage' => $perPage
    ];
}


function getPost($slug = null, $type = 'post') {
    $folder = ($type === 'page') ? "pages" : "posts";
    
    if ($slug === null && $type === 'page') {
        // Return all static pages
        $pages = [];
        foreach (glob("{$folder}/*.md") as $file) {
            $slug = basename($file, '.md');
            $pages[$slug] = getPost($slug, 'page');
        }
        return $pages;
    }
    
    $file = "{$folder}/{$slug}.md";
    if (!file_exists($file)) {
        return null;
    }
    
    $content = file_get_contents($file);
    $parsedown = new Parsedown();
    
    preg_match('/^---\s*\n(.*?)\n---\s*\n(.*)/s', $content, $matches);
    $frontMatter = Yaml::parse($matches[1]);
    $markdown = $matches[2];
    
    $formattedDate = '';
    $formattedDateIndo = '';
    if ($type === 'post' && isset($frontMatter['date'])) {
        try {
            if (is_numeric($frontMatter['date'])) {
                $date = new DateTime();
                $date->setTimestamp($frontMatter['date']);
            } elseif (is_string($frontMatter['date'])) {
                $date = new DateTime($frontMatter['date']);
            } else {
                throw new Exception("Invalid date format");
            }
            
            $formattedDate = $date->format('d F Y'); 
            
            $bulan = array (
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );
            $formattedDateIndo = $date->format('d') . ' ' . $bulan[(int)$date->format('n')] . ' ' . $date->format('Y');
        } catch (Exception $e) {
            error_log("Error parsing date for post {$slug}: " . $e->getMessage());
            // Use current date as fallback
            $date = new DateTime();
            $formattedDate = $date->format('d F Y');
            $formattedDateIndo = $date->format('d') . ' ' . $bulan[(int)$date->format('n')] . ' ' . $date->format('Y');
        }
    }
 
    $tags = [];
    if ($type === 'post' && isset($frontMatter['tags'])) {
        $tags = $frontMatter['tags'];
        if (is_string($tags)) {
            $tags = array_map('trim', explode(',', $tags));
        }
        $tags = array_map(function($tag) {
            return [
                'name' => $tag,
                'url' => '/tag/' . urlencode(strtolower(str_replace(' ', '-', $tag)))
            ];
        }, $tags);
    }
    
    $description = substr(strip_tags($parsedown->text($markdown)), 0, 150) . '...';
    
    return [
        'slug' => $slug,
        'title' => $frontMatter['title'] ?? '',
        'description' => $frontMatter['description'] ?? '',
        'tags' => $tags,
        'date' => $formattedDate,
        'dateIndo' => $formattedDateIndo,
        'content' => $parsedown->text($markdown),
        'type' => $type
    ];
}


function getPreviousNextPosts($currentSlug) {
    $files = glob('posts/*.md');
    usort($files, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    
    $currentIndex = array_search("posts/{$currentSlug}.md", $files);
    $prevPost = $currentIndex > 0 ? basename($files[$currentIndex - 1], '.md') : null;
    $nextPost = $currentIndex < count($files) - 1 ? basename($files[$currentIndex + 1], '.md') : null;
    
    return [
        'prev' => $prevPost ? getPost($prevPost) : null,
        'next' => $nextPost ? getPost($nextPost) : null
    ];
}


function getAllTags() {
    $files = glob('posts/*.md');
    $allTags = [];
    foreach ($files as $file) {
        $post = getPost(basename($file, '.md'));
        foreach ($post['tags'] as $tag) {
            if (!isset($allTags[$tag['name']])) {
                $allTags[$tag['name']] = $tag;
            }
        }
    }
    return $allTags;
}


function displayTags($tags) {
    $config = getConfig();
    
    if (empty($tags)) {
        return '';
    }
    
    $tagLinks = array_map(function($tag) use ($config) {
        $tagName = is_array($tag) ? ($tag['name'] ?? '') : $tag;
        
        if (empty($tagName)) {
            return '';
        }
        
        $tagPath = $config['tag_path'] ?? '/tag';  // Default ke '/tag' jika tidak ada di config
        $url = rtrim($config['url'], '/') . $tagPath . '/' . urlencode($tagName);
        
        return '<a href="' . $url . '">' . htmlspecialchars($tagName) . '</a>';
    }, $tags);
    
    $tagLinks = array_filter($tagLinks);
    
    return implode(', ', $tagLinks);
}



function getPostsByTag($tag, $page = 1, $perPage = 5) {
    $files = glob('../posts/*.md');
    if (empty($files)) {
        error_log("No .md files found in ../posts/");
        return ['posts' => [], 'totalPages' => 0, 'currentPage' => 1, 'totalPosts' => 0];
    }

    usort($files, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    
    $taggedPosts = [];
    foreach ($files as $file) {
        $post = getPost(basename($file, '.md'));
        if (!$post) {
            error_log("Failed to get post data for file: " . basename($file));
            continue;
        }

        if (!isset($post['tags']) || !is_array($post['tags'])) {
            error_log("Invalid tags data for post: " . $post['title']);
            continue;
        }

        $postTags = array_column($post['tags'], 'name');
        if (in_array(strtolower($tag), array_map('strtolower', $postTags))) {
            $taggedPosts[] = $post;
        }
    }
    
    $totalPosts = count($taggedPosts);
    $totalPages = ceil($totalPosts / $perPage);
    $start = ($page - 1) * $perPage;
    $paginatedPosts = array_slice($taggedPosts, $start, $perPage);
    
    return [
        'posts' => $paginatedPosts,
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'totalPosts' => $totalPosts
    ];
}
