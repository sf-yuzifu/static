<?php
function isValidUrl($url)
{
  // 保持原有的URL验证逻辑不变
  if (filter_var($url, FILTER_VALIDATE_URL)) return true;
  if (preg_match('%^//[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(/\S*)?$%i', $url)) return true;
  if (preg_match('%^[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(/\S*)?$%i', $url)) return true;
  return false;
}

// 白名单域名数组
$whitelist = [
  'music.163.com',
  'www.music.163.com'
];

$url = '';
$shouldRedirect = false;

if (isset($_GET['url'])) {
  $inputUrl = trim($_GET['url']);
  if (isValidUrl($inputUrl)) {
    $url = htmlspecialchars($inputUrl, ENT_QUOTES, 'UTF-8');
    
    // 处理协议相对URL
    if (substr($url, 0, 2) === '//') {
      $url = 'https:' . $url;
    } 
    // 处理无协议URL
    elseif (!preg_match('%^https?://%i', $url) && !preg_match('%^/%', $url)) {
      $url = 'https://' . $url;
    }
    
    // 检查是否在白名单中
    $parsedUrl = parse_url($url);
    if (isset($parsedUrl['host'])) {
      $domain = strtolower($parsedUrl['host']);
      // 移除www前缀比较
      $domain = preg_replace('/^www\./', '', $domain);
      if (in_array($domain, $whitelist)) {
        $shouldRedirect = true;
      }
    }
  }
}

// 如果是白名单域名，直接跳转
if ($shouldRedirect) {
  header("Location: $url");
  exit;
}
?>

<!DOCTYPE html>
<html lang="zh-CN">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>编程猫防xss检测</title>
  <style>
    /* 基础样式重置 */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    :root {
      --bg-color: #f5f7fa;
      --text-color: #333;
      --container-bg: white;
      --shadow-color: rgba(0, 0, 0, 0.08);
      --error-icon-bg: #fee2e2;
      --error-icon-color: #dc2626;
      --title-color: #1f2937;
      --alert-bg: #fee2e2;
      --alert-color: #b91c1c;
      --alert-icon-bg: #dc2626;
    }

    @media (prefers-color-scheme: dark) {
      :root {
        --bg-color: #1a1a1a;
        --text-color: #e0e0e0;
        --container-bg: #2d2d2d;
        --shadow-color: rgba(0, 0, 0, 0.3);
        --error-icon-bg: #4a1c1c;
        --error-icon-color: #f87171;
        --title-color: #f3f4f6;
        --alert-bg: #4a1c1c;
        --alert-color: #fca5a5;
        --alert-icon-bg: #f87171;
      }
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      line-height: 1.6;
      color: var(--text-color);
      background-color: var(--bg-color);
      padding: 20px;
      transition: background-color 0.3s, color 0.3s;
    }

    iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: unset;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
    }

    /* 错误容器样式 */
    .error-container {
      max-width: 700px;
      margin: 50px auto;
      padding: 40px;
      border-radius: 12px;
      background-color: var(--container-bg);
      box-shadow: 0 4px 20px var(--shadow-color);
      text-align: center;
      transition: background-color 0.3s, box-shadow 0.3s;
    }

    .error-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 20px;
      background-color: var(--error-icon-bg);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--error-icon-color);
      font-size: 40px;
      font-weight: bold;
      transition: background-color 0.3s, color 0.3s;
    }

    .title {
      color: var(--title-color);
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
      transition: color 0.3s;
    }

    .alert {
      padding: 12px 16px;
      background-color: var(--alert-bg);
      color: var(--alert-color);
      border-radius: 6px;
      margin: 20px 0;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: background-color 0.3s, color 0.3s;
    }

    .alert:before {
      content: "!";
      display: inline-block;
      width: 20px;
      height: 20px;
      background-color: var(--alert-icon-bg);
      color: white;
      border-radius: 50%;
      text-align: center;
      line-height: 20px;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    @media (max-width: 600px) {
      .error-container {
        padding: 25px;
      }

      .title {
        font-size: 20px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <?php if (!empty($url)): ?>
      <iframe src="<?php echo $url; ?>" sandbox="allow-same-origin allow-scripts allow-forms"></iframe>
    <?php else: ?>
      <div class="error-container">
        <div class="error-icon">!</div>
        <h2 class="title">无法加载URL</h2>
        <div class="alert">
          无效的URL或未提供URL参数
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>