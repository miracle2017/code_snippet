<?php


$str = <<<eof
<div>好的</div>
<div class="kk">
    <div>
        <div class="tt">中文</div>
    </div>
    <p>what</p>
</div>
<div>下面</div>
eof;


//array_splice($input, $offset, $length, $replacement);
preg_match($pattern, $replacement, $subject);
$re = html_splice('/<p>/', $str, "是否");
var_dump($re);

/**
 * 提取正则匹配到的html的dom元素,或替换得到新html
 * @param string $pattern '正则表达式: 请以html标签开头如`<span`'
 * @param string $str 'html: 请确保html标签都有闭合,否则匹配结果无法保证'
 * @param string $replacement '可选,不指定(默认)则返回匹配到的html;指定时,则返回将匹配的html换为$replacement的新$str
 * @return bool|false|int|string 'html标签没闭合或正则不合法返回false, 没有匹配到内容返回0, 正常时则返回字符串'
 */
function html_splice($pattern, $str, $replacement = null)
{
    if (1 === ($pregRe = preg_match($pattern, $str, $m, PREG_OFFSET_CAPTURE))) {
        $start = $m[0][1];
        if (preg_match('/<(\w+?)[ |>]/', $pattern, $t, null, 1)) {
            $tag = $t[1];
        } else {
            //输入正则不合法因为匹配不到html标签
            return false;
        }
    } else {
        //指定正则没有匹配任何内容
        return $pregRe;
    }
    $pos = $start + ($strLen = strlen($tag) + 1);
    $sum = 1;
    while ($sum > 0) {
        $l = strpos($str, "<$tag", $pos);
        $r = strpos($str, "</$tag>", $pos);
        $cur = $r > $l ? 1 : -1;
        if (!$r) {
            //标签没有闭合
            return false;
        }
        if (!$l || 0 == $sum = ($cur + $sum)) {
            $end = $r + ($strLen + 2);
            break;
        }
        $pos = ($l < $r ? $l : $r) + $strLen;
    }
    if (empty($replacement)) {
        //获取匹配到html值
        return substr($str, $start, $end - $start);
    } else {
        //替换匹配到html并返回替换后完整的html
        return substr($str, 0, $start) . $replacement . substr($str, $end);
    }
}

