<?php
$moe = $_GET["moe"];
$code = $_GET["code"];
$school = $_GET["school"];
if (empty($moe))
{
    echo '교육청 코드 입력';
}
if (empty($code))
{
    echo '학교 코드 입력';
}
if (empty($school))
{
    echo '학교 종류 코드 입력';
}

function get_url($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}

function get_meal($moe, $code, $school, $type)
{
    date_default_timezone_set("Asia/Seoul");

    $url = "https://stu." . $moe . ".go.kr/sts_sci_md00_001.do?&schulCode=" . $code . "&schulCrseScCode=" . $school;

    $meal = get_url($url);

    //급식표만 가져오기
    $pos = strpos($meal, '<tbody>') + strlen('<tbody>');
    $pos2 = strpos($meal, '</tbody>') + strlen('</tbody>');
    $meal = substr($meal, $pos, $pos2 - $pos);

    //불필요 태그 제거
    $meal = str_replace('<tr>', '', $meal);
    $meal = str_replace('</tr>', '', $meal);
    $meal = str_replace('<td>', '', $meal);
    $meal = str_replace('</td>', '', $meal);
    $meal = str_replace('<br />', "\\n", $meal);
    // &amp -> & 변환
    $meal = str_replace('&amp;', "&", $meal);
    // 알레르기 표시 삭제
    $meal = str_replace('10.', "", $meal);
    $meal = str_replace('11.', "", $meal);
    $meal = str_replace('12.', "", $meal);
    $meal = str_replace('13.', "", $meal);
    $meal = str_replace('14.', "", $meal);
    $meal = str_replace('15.', "", $meal);
    $meal = str_replace('16.', "", $meal);
    $meal = str_replace('17.', "", $meal);
    $meal = str_replace('18.', "", $meal);
    $meal = str_replace('1.', "", $meal);
    $meal = str_replace('2.', "", $meal);
    $meal = str_replace('3.', "", $meal);
    $meal = str_replace('4.', "", $meal);
    $meal = str_replace('5.', "", $meal);
    $meal = str_replace('6.', "", $meal);
    $meal = str_replace('7.', "", $meal);
    $meal = str_replace('8.', "", $meal);
    $meal = str_replace('9.', "", $meal);

    for ($i = 1;$i < 32;$i++)
    {
        $pos = strpos($meal, "<div>" . $i) + strlen("<div>" . $i);

        if ($pos === false) break;

        $meal = substr($meal, $pos, strlen($meal) - $pos);

        $pos = strpos($meal, "</div>");
        $meal_day[$i] = substr($meal, 2, $pos);

        $meal_day[$i] = str_replace('</', '', $meal_day[$i]);

        if ($meal_day[$i] == "") $meal_day[$i] .= "\\n급식이 없습니다!";

        $meal_month .= "[" . date("m") . "월 " . $i . "일 급식]\\n" . $meal_day[$i] . "\\n\\n";

        if ($i == date('t')) break;
    }

    if ($type == 0) return $meal_day[date('j') ];
    else if ($type == 1) if ($next) return $meal_day[1];
    else return $meal_day[date("j") + 1];
    else return $meal_month;
}

$todaymeal = get_meal($moe, $code, $school, 0);
$tomorrowmeal = get_meal($moe, $code, $school, 1);
$monthmeal = get_meal($moe, $code, $school, 2);

$result = '{"today":"오늘 급식\\n' . $todaymeal . '", "tomorrow":"내일 급식\\n' . $tomorrowmeal . '", "month":"이번달 급식\\n' . $monthmeal . '"}';
// 웹 서버 상태에 따라 주석 해제
// $result = iconv("UTF-8", "EUC-KR", $result);
echo $result
?>
