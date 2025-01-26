<title><?php echo htmlspecialchars($currentPage['title'] ?? $post['title'] ?? $tag['name'] ?? $config['title']); ?></title>
<meta content="<?php echo htmlspecialchars($currentPage['title'] ?? $post['title'] ?? $config['title']); ?>" property="og:title">
<meta content="<?php echo htmlspecialchars($currentPage['title'] ?? $post['title'] ?? $config['title']); ?>" name="twitter:title">
<meta content="<?php echo htmlspecialchars($currentPage['title'] ?? $post['title'] ?? $config['title']); ?>" name="title">
<meta content="<?php echo htmlspecialchars($currentPage['title'] ?? $post['title'] ?? $config['title']); ?>" property="og:site_name">
<meta content="<?php echo htmlspecialchars($currentPage['description'] ?? $post['description']?? $config['description']); ?>" name="description">
<meta content="<?php echo htmlspecialchars($currentPage['description'] ?? $post['description']?? $config['description']); ?>" property="facebook:description">
<meta content="<?php echo htmlspecialchars($currentPage['description'] ?? $post['description']?? $config['description']); ?>" property="og:description">
<meta content="<?php echo htmlspecialchars($currentPage['description'] ?? $post['description']?? $config['description']); ?>" name="twitter:description">
<meta property="twitter:card" content="summary_large_image">
<meta content="<?php echo htmlspecialchars($currentPage['image'] ?? $post['image']?? $config['image']); ?>" name="twitter:image">
<meta content="<?php echo htmlspecialchars($currentPage['image'] ?? $post['image']?? $config['image']); ?>" property="facebook:image">
<meta content="<?php echo htmlspecialchars($currentPage['image'] ?? $post['image']?? $config['image']); ?>" property="og:image">
<meta content="<?php echo htmlspecialchars($currentPage['description'] ?? $post['description']?? $config['description']); ?>" property="og:image:alt">
<meta content="<?php echo htmlspecialchars($currentPage['description'] ?? $post['description'] ?? $config['description']); ?>" name="twitter:image:alt">
<link href="<?php echo $config['icon'];?>" rel="icon" type="image/x-icon">
<meta content="<?php echo $config['social']['facebook'];?>" property="facebook:author">
<meta content="<?php echo $config['social']['twitter_user'];?>" property="twitter:author">
<meta content="<?php echo $config['social']['twitter'];?>" name="twitter:site">
<meta property="og:type" content="website">
<meta content="https://www.fiverr.com/creativitas" name="developer">
<meta name="language" content="<?php echo $config['language'];?>">
<meta name="locale" content="<?php echo $config['locale'];?>">
<meta property="og:locale" content="<?php echo $config['locale'];?>">
<meta name="generator" content="markdownuts">
<meta content="index, follow" name="robots">
<link rel="stylesheet" href="<?php echo $config['url'];?>/design/css/markdownut.min.css">