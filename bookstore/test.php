<?php
$url = "https://www.books.com.tw/products/0010872787?sloc=main";
// 讀取網頁源始碼
$getFile = file_get_contents($url);
$dom = new DOMDocument();
@$dom->loadHTML($getFile);

$xpath = new DOMXPath($dom);
$result = '';
foreach($xpath->evaluate('//div[@class="content"]') as $childNode) {
  $result .= $dom->saveHtml($childNode);
}
echo $result;
?>