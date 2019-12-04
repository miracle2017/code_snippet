<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\12\3 0003
 * Time: 19:00
 */


$str = <<<eof
<div>好的</div>
<div class="kk">
    <div>
        <div class="tt">中文</div>
    </div>
    <div>what</div>
</div>
<div>外面</div>
eof;

$p = mb_strpos($str, '<div class="kk">');
$end = find($str, $p + 4);
echo mb_substr($str, $p, $end - $p);

function find($str, $pos, $sum = 1)
{
    $l = mb_strpos($str, "<div", $pos);
    $r = mb_strpos($str, "</div>", $pos);
    $cur = $r > $l ? 1 : -1;
    if (!$r) {
        //标签没有闭合
        return false;
    }
    if (!$l || 0 == $sum = ($cur + $sum)) {
        return $r + 6;
    }
    return find($str, ($l < $r ? $l : $r) + 4, $sum);
}