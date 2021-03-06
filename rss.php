<?php
require_once('header.php');

$kw = isset($_GET['kw']) ? $_GET['kw'] : '';

$result = search($kw);


$date = date(DATE_RSS);

header('Content-Type: text/xml');

echo <<<EOF
<rss xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
    <channel>
        <title>KOTOMI RSS</title>
        <link>https://kotomi-rss.moe/</link>
        <description>KOTOMI RSS 资源页</description>
        <language>zh-cn</language>
        <copyright>版权属于原作者所有，本站仅作索引。</copyright>
        <pubDate>${date}</pubDate>

EOF;


foreach ($result as $res) {
    foreach ($res as $k => $v) {
        if ($k == 'description') {
            continue;
        }
        $res[$k] = htmlspecialchars($v);
    }
    
    echo <<<EOF
        <item>
            <title>{$res['title']}</title>
            <guid isPermaLink="false">{$res['guid']}</guid>
            <link>{$res['guid']}</link>
            <enclosure url="{$res['guid']}" type="application/x-bittorrent" />
            <description><![CDATA[ {$res['description']} ]]></description>
        </item>

EOF;
}

echo <<<EOF
    </channel>
</rss>
EOF;
?>
