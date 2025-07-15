<?php
function isValidUrl($url)
{
  // 保持原有的URL验证逻辑不变
  if (filter_var($url, FILTER_VALIDATE_URL)) return true;
  if (preg_match('%^//[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(/\S*)?$%i', $url)) return true;
  if (preg_match('%^[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(/\S*)?$%i', $url)) return true;
  return false;
}

$url = '';
if (isset($_GET['url'])) {
  $inputUrl = trim($_GET['url']);
  if (isValidUrl($inputUrl)) {
    $url = htmlspecialchars($inputUrl, ENT_QUOTES, 'UTF-8');
    if (substr($url, 0, 2) === '//') {
      $url = 'https:' . $url;
    } elseif (!preg_match('%^https?://%i', $url) && !preg_match('%^/%', $url)) {
      $url = 'https://' . $url;
    }
  }
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

    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
      line-height: 1.6;
      color: #333;
      background-color: #f5f7fa;
      padding: 20px;
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
      background-color: white;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      text-align: center;
    }

    .error-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto 20px;
      background-color: #fee2e2;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #dc2626;
      font-size: 40px;
      font-weight: bold;
    }

    .title {
      color: #1f2937;
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .alert {
      padding: 12px 16px;
      background-color: #fee2e2;
      color: #b91c1c;
      border-radius: 6px;
      margin: 20px 0;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .alert:before {
      content: "!";
      display: inline-block;
      width: 20px;
      height: 20px;
      background-color: #dc2626;
      color: white;
      border-radius: 50%;
      text-align: center;
      line-height: 20px;
      font-weight: bold;
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