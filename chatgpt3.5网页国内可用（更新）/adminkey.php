<!--原创 枭 -->
<!--论坛交流：bbs.119.cab-->

<?php
// 设置登录此页面需要用户名和密码
$user = '枭';
$pass = 'nbd';

// 检查是否已经输入了用户名和密码
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
    || $_SERVER['PHP_AUTH_USER'] !== $user || $_SERVER['PHP_AUTH_PW'] !== $pass) {

    // 如果没有输入用户名和密码，或者用户名和密码不匹配，则提示用户进行身份验证
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo '您需要输入用户名和密码才能访问此页面。';
    exit;
}

// 如果用户已经通过身份验证，则显示页面内容
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>更新 API Key 和 URL</title>
    <style>
        a.custom-link {
            text-decoration: none;
            color: inherit; /* 继承父元素的文字颜色 */
        }
    </style>
</head>
<body>
    <h1>更新 API Key</h1>
    <a href="https://blog.evv1.com/index.php/archives/24/" class="custom-link"><h6>没有openai账号？点击</h6></a>
    <a href="https://bbs.119.cab/" class="custom-link"><h3>自由国度一个精品论坛</h3></a>
    <form method="post">
        <label for="api_key">API Key:</label>
        <input type="text" name="api_key" id="api_key" value="<?php echo htmlspecialchars($OPENAI_API_KEY); ?>">
        <button type="submit">提交更新</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['api_key'])) {
        $new_api_key = $_POST['api_key'];
        $file_path = 'stream.php';
        $file_contents = file_get_contents($file_path);
        $new_file_contents = preg_replace('/\$OPENAI_API_KEY\s*=\s*".*?";/', "\$OPENAI_API_KEY = \"$new_api_key\";", $file_contents);
        file_put_contents($file_path, $new_file_contents);
        echo '<p>API key 更新成功!</p>';
    }
    ?>
    <br><br>
    <h1>更新 代理</h1>
    <p>使用官方代理接口的话 搭建服务器环境必须要在国外 可以访问官方代理接口的服务器或者虚拟主机</p>
  <p>不使用代理接口的话 服务器环境可以在国内服务器或者虚拟主机 无限制 因为是代理不确定 响应速度如果人多使用的话 也会受到影响 也有不稳定因素 建议自己搭建代理 （支持自定义代理url） </p>
<form method="post">
  <label for="url">代理URL:</label>
  
  <select name="url" id="url">
    <option value="https://api.openai.com/v1/chat/completions">【官方代理接口】 交流论坛bbs.119.cab</option>
    <option value="https://openai.1rmb.tk/v1/chat/completions">【网友代理接口】 交流论坛bbs.119.cab</option>
    <option value="https://api.1re.ren/v1/chat/completions">【枭的代理接口】 交流论坛bbs.119.cab</option>
    <option value="custom">自定义</option>
  </select>
  <input type="text" name="custom_url" id="custom_url" style="display: none;" placeholder="输入自定义URL">
  <button type="submit">提交更新</button>
</form>

<script>
  document.getElementById('url').addEventListener('change', function() {
    var custom_url_input = document.getElementById('custom_url');
    if (this.value === 'custom') {
      custom_url_input.style.display = 'block';
      custom_url_input.required = true;
    } else {
      custom_url_input.style.display = 'none';
      custom_url_input.required = false;
    }
  });
</script>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['url'])) {
  if ($_POST['url'] === 'custom' && isset($_POST['custom_url'])) {
    $new_url = $_POST['custom_url'];
  } else {
    $new_url = $_POST['url'];
  }
  $file_path = 'stream.php';
  $file_contents = file_get_contents($file_path);
  $new_file_contents = preg_replace('/curl_setopt\(\$ch, CURLOPT_URL, \'(.*?)\'\);/', "curl_setopt(\$ch, CURLOPT_URL, '$new_url');", $file_contents);
  file_put_contents($file_path, $new_file_contents);
  echo '<p>URL 更新成功!</p>';
}
?>

    <style>
      body {
        background-color: #989996;
        font-family: Arial, sans-serif;
        text-align: center;
      }
      input[type="text"] {
        padding: 10px;
        margin: 10px;
        border-radius: 20px;
        border: none;
        width: 300px;
      }
      button {
        background-color: #ff8c00;
        color: white;
        border-radius: 20px;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
      }
      .result {
        margin-top: 50px;
        background-color: #f1d39c;
        padding: 20px;
        border-radius: 20px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        text-align: left;
        display: none;
        width: 600px;
        height: 400px;
      }
      .error {
        margin-top: 50px;
        background-color: #ffb6c1;
        padding: 20px;
        border-radius: 20px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        color: #800000;
        font-weight: bold;
      }
      .label {
        font-weight: bold;
        margin-bottom: 5px;
      }
      label[for="apiUrlInput"] {
        color: #000;
      }
    </style>
  </head>
  <body>
    <h1>API-KEY 信息查询</h1>
    <label for="apiUrlInput">API链接：</label>
    <select id="apiUrlInput" onchange="onApiUrlChange()">
      <option value="https://openai.1rmb.tk">
        【网友代理接口】交流论坛bbs.119.cab
      </option>
      <option value="https://api.openai.com">
        【官方代理接口】 交流论坛bbs.119.cab
      </option>
            <option value="https://api.1re.ren">
        【枭的代理接口】 交流论坛bbs.119.cab
      </option>
      <option value="custom">自定义 ...</option>
    </select>
    <input
      type="text"
      id="apiUrlCustom"
      placeholder="请输入API链接"
      style="display: none"
    />
    <input type="text" id="apiKeyInput" placeholder="YOUR_KEY" />
    <button onclick="sendCurlRequest()">发送请求</button>
    <div class="result" id="resultSection">
      <p class="label">总余额：</p>
      <p class="value" id="totalGranted"></p>
      <p class="label">已使用：</p>
      <p class="value" id="totalUsed"></p>
      <p class="label">剩余额度：</p>
      <p class="value" id="totalAvailable"></p>
      <p class="label">有效期起：</p>
      <p class="value" id="effectiveAt"></p>
      <p class="label">有效期止：</p>
      <p class="value" id="expiresAt"></p>
    </div>
    <div class="error" id="errorSection" style="display: none">
      <p id="errorMessage"></p>
    </div>
    <script>
      const resultSection = document.getElementById("resultSection");
      const errorSection = document.getElementById("errorSection");
      let timeoutId;
      function onApiUrlChange() {
        const apiUrlSelect = document.getElementById("apiUrlInput");
        const apiUrlCustom = document.getElementById("apiUrlCustom");
        if (apiUrlSelect.value === "custom") {
          apiUrlCustom.style.display = "inline";
        } else {
          apiUrlCustom.style.display = "none";
        }
      }
      function sendCurlRequest() {
        const apiUrlSelect = document.getElementById("apiUrlInput");
        const apiUrlCustom = document.getElementById("apiUrlCustom").value;
        const apiUrl =
          apiUrlSelect.value === "custom" ? apiUrlCustom : apiUrlSelect.value;
        const apiKey = document.getElementById("apiKeyInput").value;
        const url = `${apiUrl}/dashboard/billing/credit_grants`;

        if (!apiUrl) {
          alert("请设置API链接");
          return;
        }
        if (!apiKey) {
          alert("请填写API KEY");
          return;
        }
        const options = {
          method: "GET",
          headers: {
            Authorization: `Bearer ${apiKey}`
          }
        };

        timeoutId = setTimeout(() => {
          displayError(new Error("API链接无响应，请检查其有效性或网络情况"));
        }, 5000);

        fetch(url, options)
          .then((response) => {
            clearTimeout(timeoutId);
            if (!response.ok) {
              return response.json().then((error) => {
                throw new Error(error.error.message);
              });
            }
            return response.json();
          })
          .then((responseJson) => displayResult(responseJson))
          .catch((error) => displayError(error));
      }

      function displayResult(result) {
        const totalGrantedElement = document.getElementById("totalGranted");
        const totalUsedElement = document.getElementById("totalUsed");
        const totalAvailableElement = document.getElementById("totalAvailable");
        const effectiveAtElement = document.getElementById("effectiveAt");
        const expiresAtElement = document.getElementById("expiresAt");

        totalGrantedElement.innerText = result.total_granted;
        totalUsedElement.innerText = result.total_used;
        totalAvailableElement.innerText = result.total_available;
        effectiveAtElement.innerText =
          "从 " + formatDate(result.grants.data[0].effective_at) + " 开始";
        expiresAtElement.innerText =
          "到 " + formatDate(result.grants.data[0].expires_at) + " 结束";

        resultSection.style.display = "block";
        errorSection.style.display = "none";
      }

      function displayError(error) {
        clearTimeout(timeoutId);
        const errorMessageElement = document.getElementById("errorMessage");
        if (error.name === "AbortError") {
          errorMessageElement.innerText =
            "API链接无响应，请检查其有效性或网络情况";
        } else if (error.message.includes("Incorrect API key provided")) {
          errorMessageElement.innerText = "请检查API-KEY是否正确";
        }else if (error.message.includes("This key is")) {
          errorMessageElement.innerText = "您的openai账号已被封禁";
        } else {
          errorMessageElement.innerText =
            "API链接无响应，请检查其有效性或网络情况";
        }
        resultSection.style.display = "none";
        errorSection.style.display = "block";
      }

      function formatDate(timestamp) {
        const date = new Date(timestamp * 1000);
        const year = date.getFullYear();
        const month = addLeadingZero(date.getMonth() + 1);
        const day = addLeadingZero(date.getDate());
        const hour = addLeadingZero(date.getHours());
        const minute = addLeadingZero(date.getMinutes());
        const second = addLeadingZero(date.getSeconds());
        return `${year}-${month}-${day} ${hour}:${minute}:${second}`;
      }

      function addLeadingZero(number) {
        return number < 10 ? "0" + number : number;
      }
    </script>

</body>
</html>
