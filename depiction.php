<?php
header('Content-Type: application/json; charset=utf-8');

// 获取 iOS 版本参数（越狱商店通常会传递这个参数）
$ios_version = $_GET['ios_version'] ?? $_GET['version'] ?? '未知';
$firmware = $_GET['firmware'] ?? '';

// 如果无法获取版本，尝试从 User-Agent 中解析
if ($ios_version === '未知' && !empty($firmware)) {
    $ios_version = $firmware;
}

// 判断兼容性
$compatible = false;
if ($ios_version !== '未知') {
    // 清理版本字符串，只保留数字和点
    $clean_version = preg_replace('/[^0-9.]/', '', $ios_version);
    $version_float = (float)$clean_version;
    $compatible = ($version_float >= 16.0 && $version_float <= 16.6);
}

// 生成按钮配置
if ($compatible) {
    $button_text = "✅ 您的系统: iOS {$ios_version} 兼容该软件包";
    $button_color = "#4CD964";
} else if ($ios_version === '未知') {
    $button_text = "⚠️ 无法检测系统版本，请手动确认兼容性";
    $button_color = "#FF9500";
} else {
    $button_text = "☹ 您的系统: iOS {$ios_version} 不兼容该软件包";
    $button_color = "#f15a22";
}

// 构建完整的 depiction 数据
$depiction = array(
    "minVersion" => "0.1",
    "headerImage" => "https://apt.htv123.com/image/0001.jpg",
    "tabs" => array(
        array(
            "tabname" => "插件介绍(Details)",
            "views" => array(
                array(              
                    "text" => $button_text,
                    "action" => "",     
                    "tintColor" => $button_color, 
                    "class" => "DepictionButtonView"
                ),
                array(
                    "class" => "DepictionLabelView",
                    "text" => "插件功能说明(Description)",
                    "fontWeight" => "semibold",
                    "fontSize" => 17,
                    "usePadding" => true,
                    "useMargins" => true,
                    "margins" => "{10,0,8,0}"
                ),
                array(
                    "markdown" => "\n电话助手授权版本,通话录音,通话记录合并,T9双卡选卡拨号键盘,短信双卡选卡,来去电归属地,黑名单,骚扰拦截,状态栏图标替换,时间格式修改,常用小功能等强大插件",
                    "useSpacing" => true,
                    "class" => "DepictionMarkdownView"
                ),
                array(
                    "spacing" => 20,
                    "class" => "DepictionSpacerView"
                ),
                array(
                    "class" => "DepictionSeparatorView"
                ),
                array(
                    "title" => "赞助正版授权",
                    "action" => "https://buy.htv123.com",
                    "class" => "DepictionTableButtonView"
                ),
                // ... 这里继续添加你原来的其他视图内容
            ),
            "class" => "DepictionStackView"
        ),
        array(
            "tabname" => "更新日志(Changelog)",
            "views" => array(
                array(              
                    "text" => $button_text,
                    "action" => "",     
                    "tintColor" => $button_color, 
                    "class" => "DepictionButtonView"
                ),
                array(
                    "class" => "DepictionSeparatorView"
                ),
                // ... 更新日志的其他内容
            ),
            "class" => "DepictionStackView"
        )
    ),
    "class" => "DepictionTabView"
);

echo json_encode($depiction, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
