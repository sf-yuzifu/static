<?php
$url = '';
if (isset($_GET['url'])) {
  $inputUrl = trim($_GET['url']);

  // 验证URL格式
  if (filter_var($inputUrl, FILTER_VALIDATE_URL)) {
    $url = htmlspecialchars($inputUrl, ENT_QUOTES, 'UTF-8');
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>安全显示外部URL</title>
  <style>
    iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: unset;
    }
  </style>
</head>

<body>
  <?php if (!empty($url)): ?>
    <iframe src="<?php echo $url; ?>" sandbox="allow-same-origin allow-scripts allow-forms"></iframe>

  <?php else: ?>
    <div class="error">
      <p>这里嵌入了一个iframe窗口</p>
      <p>但是不知道为什么他提供的链接没用？</p>
    </div>
  <?php endif; ?>
</body>

</html>