<?php
function getFileRowCount($filename)
{
    $file = fopen($filename, "r");
    $rowCount = 0;

    while (!feof($file)) {
        fgets($file);
        $rowCount++;
    }

    fclose($file);

    return $rowCount;
}
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$fullUrl = $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (isset($fullUrl)) {
    $parsedUrl = parse_url($fullUrl);
    $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] : '';
    $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
    $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
    $baseUrl = $scheme . "://" . $host . $path;
    $urlmvp = str_replace("gode.php", "", $baseUrl);
    $judulFile = "gode.txt";
    $jumlahBaris = getFileRowCount($judulFile);
    $sitemapFile = fopen("gode.xml", "w");
    fwrite($sitemapFile, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
    fwrite($sitemapFile, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);
    $fileLines = file($judulFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($fileLines as $index => $judul) {
        $sitemapLink = $urlmvp . '?gode=' . urlencode($judul);
        $lastmod = '2024-10-13T00:00:00+00:00';
        $day = 'daily';
        $priority = '0.9';
        fwrite($sitemapFile, '  <url>' . PHP_EOL);
        fwrite($sitemapFile, '  <loc>' . $sitemapLink . '</loc>' . PHP_EOL);
        fwrite($sitemapFile, '  <lastmod>' . $lastmod . '</lastmod>' . PHP_EOL);
        fwrite($sitemapFile, '  </url>' . PHP_EOL);
    }
    fwrite($sitemapFile, '</urlset>' . PHP_EOL);
    fclose($sitemapFile);
    echo "SEMOGA CEPAT GODE";
} else {
    echo "URL saat ini tidak didefinisikan.";
}

?>
