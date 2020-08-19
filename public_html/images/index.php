<?php
function ValidateEmail($email)
{
    $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
    return preg_match($pattern, $email);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formid'] == 'form3') {
    $mailto = 'bsv10k@yandex.ru';
    $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
    $mailbcc = 'andrei-presser@yandex.ru';
    $subject = 'Заявка с сайта DIN-MEL.RU - МУКА - КП';
    $message = 'Посетитель сайта оставил заявку на коммерческое предложение и перешел к скачиванию прайса';
    $success_url = './thankyou-compr.html';
    $error_url = '';
    $error = '';
    $eol = "\n";
    $max_filesize = isset($_POST['filesize']) ? $_POST['filesize'] * 1024 : 1024000;
    $boundary = md5(uniqid(time()));

    $header = 'From: ' . $mailfrom . $eol;
    $header .= 'Reply-To: ' . $mailfrom . $eol;
    $header .= 'Bcc: ' . $mailbcc . $eol;
    $header .= 'MIME-Version: 1.0' . $eol;
    $header .= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . $eol;
    $header .= 'X-Mailer: PHP v' . phpversion() . $eol;
    if (!ValidateEmail($mailfrom)) {
        $error .= "The specified email address is invalid!\n<br>";
    }

    if (!empty($error)) {
        $errorcode = file_get_contents($error_url);
        $replace = "##error##";
        $errorcode = str_replace($replace, $error, $errorcode);
        echo $errorcode;
        exit;
    }

    $internalfields = array("submit", "reset", "send", "filesize", "formid", "captcha_code", "recaptcha_challenge_field", "recaptcha_response_field", "g-recaptcha-response");
    $message .= $eol;
    foreach ($_POST as $key => $value) {
        if (!in_array(strtolower($key), $internalfields)) {
            if (!is_array($value)) {
                $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
            } else {
                $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
            }
        }
    }
    $body = 'This is a multi-part message in MIME format.' . $eol . $eol;
    $body .= '--' . $boundary . $eol;
    $body .= 'Content-Type: text/plain; charset=UTF-8' . $eol;
    $body .= 'Content-Transfer-Encoding: 8bit' . $eol;
    $body .= $eol . stripslashes($message) . $eol;
    if (!empty($_FILES)) {
        foreach ($_FILES as $key => $value) {
            if ($_FILES[$key]['error'] == 0 && $_FILES[$key]['size'] <= $max_filesize) {
                $body .= '--' . $boundary . $eol;
                $body .= 'Content-Type: ' . $_FILES[$key]['type'] . '; name=' . $_FILES[$key]['name'] . $eol;
                $body .= 'Content-Transfer-Encoding: base64' . $eol;
                $body .= 'Content-Disposition: attachment; filename=' . $_FILES[$key]['name'] . $eol;
                $body .= $eol . chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))) . $eol;
            }
        }
    }
    $body .= '--' . $boundary . '--' . $eol;
    if ($mailto != '') {
        mail($mailto, $subject, $body, $header);
    }
    header('Location: ' . $success_url);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formid'] == 'form1') {
    $mailto = 'bsv10k@yandex.ru';
    $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
    $mailbcc = 'andrei-presser@yandex.ru';
    $subject = 'Заявка с сайта DIN-MEL.RU - МУКА - ПРАЙС';
    $message = 'Посетитель оставил заявку на прайс-лист и перешел к его скачиванию';
    $success_url = './thankyou-price.html?p=1';
    $error_url = '';
    $error = '';
    $eol = "\n";
    $max_filesize = isset($_POST['filesize']) ? $_POST['filesize'] * 1024 : 1024000;
    $boundary = md5(uniqid(time()));

    $header = 'From: ' . $mailfrom . $eol;
    $header .= 'Reply-To: ' . $mailfrom . $eol;
    $header .= 'Bcc: ' . $mailbcc . $eol;
    $header .= 'MIME-Version: 1.0' . $eol;
    $header .= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . $eol;
    $header .= 'X-Mailer: PHP v' . phpversion() . $eol;
    if (!ValidateEmail($mailfrom)) {
        $error .= "The specified email address is invalid!\n<br>";
    }

    if (!empty($error)) {
        $errorcode = file_get_contents($error_url);
        $replace = "##error##";
        $errorcode = str_replace($replace, $error, $errorcode);
        echo $errorcode;
        exit;
    }

    $internalfields = array("submit", "reset", "send", "filesize", "formid", "captcha_code", "recaptcha_challenge_field", "recaptcha_response_field", "g-recaptcha-response");
    $message .= $eol;
    foreach ($_POST as $key => $value) {
        if (!in_array(strtolower($key), $internalfields)) {
            if (!is_array($value)) {
                $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
            } else {
                $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
            }
        }
    }
    $body = 'This is a multi-part message in MIME format.' . $eol . $eol;
    $body .= '--' . $boundary . $eol;
    $body .= 'Content-Type: text/plain; charset=UTF-8' . $eol;
    $body .= 'Content-Transfer-Encoding: 8bit' . $eol;
    $body .= $eol . stripslashes($message) . $eol;
    if (!empty($_FILES)) {
        foreach ($_FILES as $key => $value) {
            if ($_FILES[$key]['error'] == 0 && $_FILES[$key]['size'] <= $max_filesize) {
                $body .= '--' . $boundary . $eol;
                $body .= 'Content-Type: ' . $_FILES[$key]['type'] . '; name=' . $_FILES[$key]['name'] . $eol;
                $body .= 'Content-Transfer-Encoding: base64' . $eol;
                $body .= 'Content-Disposition: attachment; filename=' . $_FILES[$key]['name'] . $eol;
                $body .= $eol . chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))) . $eol;
            }
        }
    }
    $body .= '--' . $boundary . '--' . $eol;
    if ($mailto != '') {
        mail($mailto, $subject, $body, $header);
    }
    header('Location: ' . $success_url);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formid'] == 'form4') {
    $mailto = 'bsv10k@yandex.ru';
    $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
    $mailbcc = 'andrei-presser@yandex.ru';
    $subject = 'Заявка с сайта DIN-MEL.RU - МУКА - ПРАЙС';
    $message = 'Посетитель сайта оставил заявку на прайс и перешел к его скачиванию';
    $success_url = './thankyou-price.html?p=2';
    $error_url = '';
    $error = '';
    $eol = "\n";
    $max_filesize = isset($_POST['filesize']) ? $_POST['filesize'] * 1024 : 1024000;
    $boundary = md5(uniqid(time()));

    $header = 'From: ' . $mailfrom . $eol;
    $header .= 'Reply-To: ' . $mailfrom . $eol;
    $header .= 'Bcc: ' . $mailbcc . $eol;
    $header .= 'MIME-Version: 1.0' . $eol;
    $header .= 'Content-Type: multipart/mixed; boundary="' . $boundary . '"' . $eol;
    $header .= 'X-Mailer: PHP v' . phpversion() . $eol;
    if (!ValidateEmail($mailfrom)) {
        $error .= "The specified email address is invalid!\n<br>";
    }

    if (!empty($error)) {
        $errorcode = file_get_contents($error_url);
        $replace = "##error##";
        $errorcode = str_replace($replace, $error, $errorcode);
        echo $errorcode;
        exit;
    }

    $internalfields = array("submit", "reset", "send", "filesize", "formid", "captcha_code", "recaptcha_challenge_field", "recaptcha_response_field", "g-recaptcha-response");
    $message .= $eol;
    foreach ($_POST as $key => $value) {
        if (!in_array(strtolower($key), $internalfields)) {
            if (!is_array($value)) {
                $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
            } else {
                $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
            }
        }
    }
    $body = 'This is a multi-part message in MIME format.' . $eol . $eol;
    $body .= '--' . $boundary . $eol;
    $body .= 'Content-Type: text/plain; charset=UTF-8' . $eol;
    $body .= 'Content-Transfer-Encoding: 8bit' . $eol;
    $body .= $eol . stripslashes($message) . $eol;
    if (!empty($_FILES)) {
        foreach ($_FILES as $key => $value) {
            if ($_FILES[$key]['error'] == 0 && $_FILES[$key]['size'] <= $max_filesize) {
                $body .= '--' . $boundary . $eol;
                $body .= 'Content-Type: ' . $_FILES[$key]['type'] . '; name=' . $_FILES[$key]['name'] . $eol;
                $body .= 'Content-Transfer-Encoding: base64' . $eol;
                $body .= 'Content-Disposition: attachment; filename=' . $_FILES[$key]['name'] . $eol;
                $body .= $eol . chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))) . $eol;
            }
        }
    }
    $body .= '--' . $boundary . '--' . $eol;
    if ($mailto != '') {
        mail($mailto, $subject, $body, $header);
    }
    header('Location: ' . $success_url);
    exit;
}
?>
<?php
if ($_GET['p']=='c_muka') {$zag = 'ЦЕЛЬНОЗЕРНОВАЯ МУКА';}
else {$zag = 'МУКА ВЫСШЕЙ КАТЕГОРИИ';}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="yandex-verification" content="649ae48f9e2921c5"/>
    <title>Купить муку оптом от производителя в Краснодарском крае | "Динская мельница"</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description"
          content="Продажа муки и мучных изделий оптом от пшеничной хлебоепакрни Динская Мельница в Краснодаре и в Красндарском крае"/>
    <?php if (!$_GET['m'] == '1' and $_GET['p'] == 'c_muka') {
        echo "<script>
if (screen.width <= 420)
{window.location = 'mobile.php?p=c_muka';}
</script>";
    }
  elseif (!$_GET['m'] == '1') 
  {
    echo "<script>
if (screen.width <= 420)
{window.location = 'mobile.php';}
</script>";
  }?>
    <link href="favicon.png" rel="shortcut icon" type="image/x-icon">
    <link href="cupertino/jquery.ui.all.css" rel="stylesheet">
    <link href="lp.css?2" rel="stylesheet">
    <link href="index.css?2" rel="stylesheet">
    <script src="jquery-1.11.1.min.js"></script>
    <script src="jquery.ui.core.min.js"></script>
    <script src="jquery.ui.widget.min.js"></script>
    <script src="jquery.ui.mouse.min.js"></script>
    <script src="jquery.ui.sortable.min.js"></script>
    <script src="jquery.ui.tabs.min.js"></script>
    <script src="jquery.ui.tabs.rotate.min.js"></script>
    <script src="fancybox/jquery.easing-1.3.pack.js"></script>
    <link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.0.css">
    <script src="fancybox/jquery.fancybox-1.3.0.pack.js"></script>
    <script src="fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
    <script src="wwb10.min.js"></script>
    <script>
        $(document).ready(function () {
            var jQueryTabs1Opts =
                {
                    show: true,
                    event: 'click',
                    collapsible: false
                };
            $("#jQueryTabs1").tabs(jQueryTabs1Opts);
            $("#jQueryTabs1").tabs('rotate', 3000, false);
        });
    </script>
    <script>
        jQuery(document).ready(function ($) {
            $('a[href^="#Layer"]').click(function () {
                elementClick = $(this).attr("href");
                destination = $(elementClick).offset().top;
                $('body').animate({scrollTop: destination}, 1100);
                return false;
            });
        });
    </script>
    <script>
        $(window).bind('scroll', function (e) {
            parallaxScroll();
        });

        function parallaxScroll() {
            var scrolled = $(window).scrollTop();
            $('#Layer2').css('background-position-y', (0 - (scrolled * .15)) + 'px');
        }
    </script>
</head>
<body>
<div id="container">
</div>
<div id="Layer19" style="position:absolute;text-align:center;left:0px;top:4400px;width:100%;height:465px;z-index:257;">
    <div id="Layer19_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text39"
             style="position:absolute;left:16px;top:158px;width:915px;height:96px;z-index:3;text-align:left;">
            <span style="color:#1E1E1E;font-weidht:bold;font-size:43px;">СЕРТИФИКАТЫ</span><span
                    style="color:#1E1E1E;font-weidht:bold;font-size:32px;"> </span><span
                    style="color:#1E1E1E;font-size:13px;"><br></span><span
                    style="color:#1E1E1E;font-size:32px;">на продукцию</span></div>
        <div id="wb_Text25"
             style="position:absolute;left:16px;top:288px;width:250px;height:57px;z-index:4;text-align:left;">
            <span style="color:#000000;font-size:17px;">Производимая &#1085;&#1072;&#1084;&#1080; &#1087;&#1088;&#1086;&#1076;&#1091;&#1082;&#1094;&#1080;&#1103; &#1080;&#1084;&#1077;&#1077;&#1090; &#1074;&#1089;&#1077; &#1085;&#1077;&#1086;&#1073;&#1093;&#1086;&#1076;&#1080;&#1084;&#1099;&#1077; &#1089;&#1077;&#1088;&#1090;&#1080;&#1092;&#1080;&#1082;&#1072;&#1090;&#1099; &#1082;&#1072;&#1095;&#1077;&#1089;&#1090;&#1074;&#1072;</span>
        </div>
        <div id="wb_Image27" style="position:absolute;left:435px;top:158px;width:163px;height:213px;z-index:5;">
            <img src="images/sert1.png" id="Image27" alt=""></div>
        <div id="wb_Image26" style="position:absolute;left:610px;top:158px;width:163px;height:213px;z-index:6;">
            <img src="images/sert2.png" id="Image26" alt=""></div>
        <div id="wb_Image28" style="position:absolute;left:785px;top:158px;width:163px;height:213px;z-index:7;">
            <img src="images/sert3.png" id="Image28" alt=""></div>
        <div id="Layer36"
             style="position:absolute;text-align:left;left:435px;top:158px;width:163px;height:213px;z-index:8;">
            <div id="wb_Shape8" style="position:absolute;left:0px;top:0px;width:162px;height:213px;z-index:0;">
                <a href="javascript:displaylightbox('./sertificates.html',{width:420,height:580,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                   target="_self"><img src="images/img0015.png" id="Shape8" alt=""
                                       style="width:162px;height:213px;"></a></div>
        </div>
        <div id="Layer38"
             style="position:absolute;text-align:left;left:610px;top:158px;width:163px;height:213px;z-index:9;">
            <div id="wb_Shape14" style="position:absolute;left:0px;top:0px;width:162px;height:213px;z-index:1;">
                <a href="javascript:displaylightbox('./sertificates2.html',{width:420,height:580,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                   target="_self"><img src="images/img0017.png" id="Shape14" alt=""
                                       style="width:162px;height:213px;"></a></div>
        </div>
        <div id="Layer39"
             style="position:absolute;text-align:left;left:785px;top:158px;width:163px;height:213px;z-index:10;">
            <div id="wb_Shape15" style="position:absolute;left:0px;top:0px;width:162px;height:213px;z-index:2;">
                <a href="javascript:displaylightbox('./sertificates3.html',{width:420,height:580,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                   target="_self"><img src="images/img0016.png" id="Shape15" alt=""
                                       style="width:162px;height:213px;"></a></div>
        </div>
    </div>
</div>
<div id="Layer26" style="position:absolute;text-align:center;left:0px;top:3450px;width:100%;height:995px;z-index:258;">
    <div id="Layer26_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="Layer25"
             style="position:absolute;text-align:left;left:0px;top:352px;width:582px;height:252px;z-index:17;">
        </div>
        <div id="wb_Text40"
             style="position:absolute;left:0px;top:125px;width:960px;height:60px;text-align:center;z-index:18;">
            <span style="color:#1E1E1E;font-weidht:bold;font-size:43px;">СОБСТВЕННОЕ ПРОИЗВОДСТВО</span></div>
        <div id="wb_Text24"
             style="position:absolute;left:13px;top:205px;width:934px;height:228px;z-index:19;text-align:left;">
<span style="color:#000000;font-size:17px;">
  <center><h5>Хотите купить первоклассную муку оптом, за умеренную цену? Обращайтесь к нам!</h5></center>
  <p>Чтобы испечь вкусный хлеб, нужна хорошая мука. Она же требуется для пышных пирогов – предмета законной гордости любой хозяйки. Без муки не сделать ни макаронных изделий, ни оладий, ни блинов на Масленицу… Словом, по-настоящему качественная мука – товар первой необходимости, и уж кому, как не жителям Краснодарского края, житницы России, это знать! Но где лучше купить муку оптом, чтобы она была отменного качества, и при этом не переплатить лишних денег?</p>
<p>Компания «Динская мельница» готова поставить практически любое количество пшеничной хлебопекарной муки высшего, первого и второго сорта, пшеничной цельнозерновой муки, манной крупы. Мы дорожим своей репутацией и гарантируем, что вся продукция строго соответствует ГОСТу. Неудивительно, ведь наши специалисты закупают пшеницу только у надежных и проверенных кубанских производителей! А затем все стадии – очистка, размол, просеивание, сортировка, упаковка – осуществляются под постоянным и строгим контролем. Каждая готовая партия проходит контроль качества в лаборатории. И в результате, наши заказчики получают отличную муку!</p>
  <br></span></div>
        <div id="jQueryTabs1" style="position:absolute;left:0px;top:465px;width:958px;height:430px;z-index:20;">
            <ul>
                <li><a href="#jquerytabs1-page-0"><span></span></a></li>
                <li><a href="#jquerytabs1-page-1"><span></span></a></li>
                <li><a href="#jquerytabs1-page-2"><span></span></a></li>
                <li><a href="#jquerytabs1-page-3"><span></span></a></li>
                <li><a href="#jquerytabs1-page-4"><span></span></a></li>
                <li><a href="#jquerytabs1-page-5"><span></span></a></li>
            </ul>
            <div style="height:382px;overflow:auto;padding:0;" id="jquerytabs1-page-0">
                <div id="wb_Image17" style="position:absolute;left:5px;top:42px;width:577px;height:384px;z-index:11;">
                    <img src="images/photo-13.jpg" id="Image17" alt=""></div>
            </div>
            <div style="height:382px;overflow:auto;padding:0;" id="jquerytabs1-page-1">
                <div id="wb_Image23" style="position:absolute;left:5px;top:42px;width:577px;height:384px;z-index:12;">
                    <img src="images/photo-20.jpg" id="Image23" alt=""></div>
            </div>
            <div style="height:382px;overflow:auto;padding:0;" id="jquerytabs1-page-2">
                <div id="wb_Image20" style="position:absolute;left:5px;top:42px;width:576px;height:384px;z-index:13;">
                    <img src="images/photo-333.jpg" id="Image20" alt=""></div>
            </div>
            <div style="height:382px;overflow:auto;padding:0;" id="jquerytabs1-page-3">
                <div id="wb_Image19" style="position:absolute;left:5px;top:42px;width:577px;height:384px;z-index:14;">
                    <img src="images/photo-43-1.jpg" id="Image19" alt=""></div>
            </div>
            <div style="height:382px;overflow:auto;padding:0;" id="jquerytabs1-page-4">
                <div id="wb_Image21" style="position:absolute;left:5px;top:42px;width:577px;height:384px;z-index:15;">
                    <img src="images/photo-75.jpg" id="Image21" alt=""></div>
            </div>
            <div style="height:382px;overflow:auto;padding:0;" id="jquerytabs1-page-5">
                <div id="wb_Image22" style="position:absolute;left:5px;top:42px;width:577px;height:384px;z-index:16;">
                    <img src="images/photo-52.jpg" id="Image22" alt=""></div>
            </div>
        </div>
    </div>
</div>
<div id="Layer8" style="position:absolute;text-align:center;left:0px;top:800px;width:100%;height:1725px;z-index:259;">
    <div id="Layer8_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text15"
             style="position:absolute;left:0px;top:144px;width:960px;height:96px;text-align:center;z-index:39;">
            <span style="color:#1E1E1E;font-weidht:bold;font-size:43px;">АССОРТИМЕНТ</span><span
                    style="color:#1E1E1E;font-weidht:bold;font-size:32px;"> </span><span
                    style="color:#1E1E1E;font-size:13px;"><br></span><span
                    style="color:#1E1E1E;font-size:32px;">нашей продукции</span></div>
        <div id="Layer16"
             style="position:absolute;text-align:left;left:10px;top:290px;width:457px;height:378px;z-index:40;">
            <div id="wb_Image13" style="position:absolute;left:4px;top:34px;width:242px;height:214px;z-index:21;">
                <img src="images/p1.jpg" id="Image13" alt=""></div>
            <div id="wb_Text23"
                 style="position:absolute;left:219px;top:29px;width:231px;height:306px;z-index:22;text-align:left;">
                <span style="color:#FC2014;font-size:21px;"><strong>МУКА ПШЕНИЧНАЯ ХЛЕБОПЕКАРНАЯ<br>ВЫСШИЙ СОРТ</strong></span><span
                        style="color:#FC2014;font-size:8px;"><strong><br></strong></span><span
                        style="color:#1E1E1E;font-size:8px;"><br></span><span
                        style="color:#000000;font-size:13px;"><strong>&#1043;&#1054;&#1057;&#1058; &#1056; 52189-2003<br></strong></span><span
                        style="color:#000000;font-size:8px;"><strong><br></strong></span><span
                        style="color:#000000;font-size:11px;">&#1052;&#1091;&#1082;&#1072; &#1074;&#1099;&#1089;&#1096;&#1077;&#1075;&#1086; &#1089;&#1086;&#1088;&#1090;&#1072;<strong> </strong>&#1086;&#1073;&#1083;&#1072;&#1076;&#1072;&#1077;&#1090; &#1074;&#1099;&#1089;&#1086;&#1082;&#1080;&#1084;&#1080; &#1093;&#1083;&#1077;&#1073;&#1086;&#1087;&#1077;&#1082;&#1072;&#1088;&#1085;&#1099;&#1084;&#1080; &#1089;&#1074;&#1086;&#1081;&#1089;&#1090;&#1074;&#1072;&#1084;&#1080;,&#1080;&#1079;&#1076;&#1077;&#1083;&#1080;&#1103; &#1080;&#1079; &#1090;&#1072;&#1082;&#1086;&#1081; &#1084;&#1091;&#1082;&#1080; &#1093;&#1086;&#1088;&#1086;&#1096;&#1086; &#1087;&#1086;&#1076;&#1085;&#1080;&#1084;&#1072;&#1102;&#1090;&#1089;&#1103;.<br>&#1055;&#1086;&#1076;&#1093;&#1086;&#1076;&#1080;&#1090; &#1076;&#1083;&#1103; &#1074;&#1099;&#1087;&#1077;&#1095;&#1082;&#1080; &#1089;&#1076;&#1086;&#1073;&#1099;,&#1076;&#1083;&#1103; &#1087;&#1088;&#1080;&#1075;&#1086;&#1090;&#1086;&#1074;&#1083;&#1077;&#1085;&#1080;&#1103; &#1076;&#1088;&#1086;&#1078;&#1078;&#1077;&#1074;&#1086;&#1075;&#1086;,&#1089;&#1083;&#1086;&#1077;&#1085;&#1086;&#1075;&#1086; &#1080; &#1087;&#1077;&#1089;&#1086;&#1095;&#1085;&#1086;&#1075;&#1086; &#1090;&#1077;&#1089;&#1090;&#1072;.<br></span><span
                        style="color:#000000;font-size:13px;"><br><strong><em><u>&#1060;&#1072;&#1089;&#1086;&#1074;&#1082;&#1072;:</u></em></strong><br>- 50 &#1082;&#1075; (&#1087;&#1086;&#1083;&#1080;&#1087;&#1088;&#1086;&#1087;&#1080;&#1083;&#1077;&#1085;&#1086;&#1074;&#1099;&#1081; &#1084;&#1077;&#1096;&#1086;&#1082;)<br>- 25 &#1082;&#1075; (&#1087;&#1086;&#1083;&#1080;&#1087;&#1088;&#1086;&#1087;&#1080;&#1083;&#1077;&#1085;&#1086;&#1074;&#1099;&#1081; &#1084;&#1077;&#1096;&#1086;&#1082;)<br>- 10 &#1082;&#1075; (&#1087;&#1086;&#1083;&#1080;&#1087;&#1088;&#1086;&#1087;&#1080;&#1083;&#1077;&#1085;&#1086;&#1074;&#1099;&#1081; &#1084;&#1077;&#1096;&#1086;&#1082;)<br>- 5 &#1082;&#1075; (&#1087;&#1086;&#1083;&#1080;&#1087;&#1088;&#1086;&#1087;&#1080;&#1083;&#1077;&#1085;&#1086;&#1074;&#1099;&#1081; &#1084;&#1077;&#1096;&#1086;&#1082;)<br>- 2 &#1082;&#1075; (&#1073;&#1091;&#1084;&#1072;&#1078;&#1085;&#1099;&#1081; &#1087;&#1072;&#1082;&#1077;&#1090;)</span><span
                        style="color:#1E1E1E;font-size:16px;"><br></span></div>
            <div id="wb_Shape4" style="position:absolute;left:19px;top:274px;width:192px;height:42px;z-index:23;">
                <a href="#Layer27"><img class="hover" src="images/img0052_hover.png" alt=""
                                        style="border-width:0;width:192px;height:42px;"><span><img
                                src="images/img0052.png" id="Shape4" alt="" style="width:192px;height:42px;"></span></a>
            </div>
        </div>
        <div id="Layer6"
             style="position:absolute;text-align:left;left:10px;top:700px;width:457px;height:400px;z-index:41;">
            <div id="wb_Image9" style="position:absolute;left:4px;top:34px;width:242px;height:214px;z-index:24;">
                <img src="images/p1.jpg" id="Image9" alt=""></div>
            <div id="wb_Text21"
                 style="position:absolute;left:219px;top:29px;width:231px;height:324px;z-index:25;text-align:left;">
                <span style="color:#FC2014;font-size:21px;"><strong>МУКА ПШЕНИЧНАЯ ХЛЕБОПЕКАРНАЯ<br>2 СОРТ</strong></span><span
                        style="color:#FC2014;font-size:8px;"><strong><br></strong></span><span
                        style="color:#1E1E1E;font-size:8px;"><br></span><span
                        style="color:#000000;font-size:13px;"><strong>&#1043;&#1054;&#1057;&#1058; &#1056; 52189-2003<br></strong></span><span
                        style="color:#000000;font-size:8px;"><strong><br></strong></span><span
                        style="color:#000000;font-size:11px;">&#1052;&#1091;&#1082;&#1072; &#1074;&#1090;&#1086;&#1088;&#1086;&#1075;&#1086; &#1089;&#1086;&#1088;&#1090;&#1072; - &#1101;&#1090;&#1086; &#1087;&#1096;&#1077;&#1085;&#1080;&#1095;&#1085;&#1072;&#1103; &#1084;&#1091;&#1082;&#1072;, &#1080;&#1084;&#1077;&#1102;&#1097;&#1072;&#1103; &#1074; &#1089;&#1086;&#1089;&#1090;&#1072;&#1074;&#1077; &#1080;&#1079;&#1084;&#1077;&#1083;&#1100;&#1095;&#1077;&#1085;&#1085;&#1099;&#1077; &#1086;&#1073;&#1086;&#1083;&#1086;&#1095;&#1082;&#1080; &#1079;&#1077;&#1088;&#1085;&#1072; &#1074; &#1082;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1077; &#1086;&#1090; 8% &#1076;&#1086; 12%. &#1063;&#1072;&#1089;&#1090;&#1080;&#1095;&#1082;&#1080; &#1101;&#1090;&#1086;&#1081; &#1084;&#1091;&#1082;&#1080; &#1082;&#1088;&#1091;&#1087;&#1085;&#1077;&#1077;, &#1087;&#1086;&#1101;&#1090;&#1086;&#1084;&#1091; &#1086;&#1085;&#1072; &#1080;&#1084;&#1077;&#1077;&#1090; &#1073;&#1086;&#1083;&#1077;&#1077; &#1090;&#1077;&#1084;&#1085;&#1099;&#1081; &#1094;&#1074;&#1077;&#1090; &#1089; &#1089;&#1077;&#1088;&#1086;&#1074;&#1072;&#1090;&#1099;&#1084; &#1086;&#1090;&#1090;&#1077;&#1085;&#1082;&#1086;&#1084;.<br>&#1056;&#1077;&#1082;&#1086;&#1084;&#1077;&#1085;&#1076;&#1091;&#1077;&#1090;&#1089;&#1103; &#1076;&#1083;&#1103; &#1087;&#1088;&#1080;&#1075;&#1086;&#1090;&#1086;&#1074;&#1083;&#1077;&#1085;&#1080;&#1103; &#1085;&#1077; &#1089;&#1076;&#1086;&#1073;&#1085;&#1086;&#1081; &#1074;&#1099;&#1087;&#1077;&#1095;&#1082;&#1080;, &#1089;&#1090;&#1086;&#1083;&#1086;&#1074;&#1086;&#1075;&#1086; х&#1083;&#1077;&#1073;&#1072;, &#1087;&#1077;&#1095;&#1077;&#1085;&#1100;&#1103;, &#1087;&#1088;&#1103;&#1085;&#1080;&#1082;&#1086;&#1074;, &#1072; &#1090;&#1072;&#1082; &#1078;&#1077; &#1076;&#1083;&#1103; &#1074;&#1099;&#1087;&#1077;&#1095;&#1082;&#1080; &#1073;&#1086;&#1088;&#1086;&#1076;&#1080;&#1085;&#1089;&#1082;&#1086;&#1075;&#1086; &#1093;&#1083;&#1077;&#1073;&#1072;.<br>&#1061;&#1083;&#1077;&#1073; &#1080;&#1079; &#1090;&#1072;&#1082;&#1086;&#1081; &#1084;&#1091;&#1082;&#1080; &#1084;&#1077;&#1076;&#1083;&#1077;&#1085;&#1085;&#1077;&#1077; &#1095;&#1077;&#1088;&#1089;&#1090;&#1074;&#1077;&#1077;&#1090; &#1080; &#1086;&#1073;&#1083;&#1072;&#1076;&#1072;&#1077;&#1090; &#1073;&#1086;&#1083;&#1077;&#1077; &#1087;&#1086;&#1083;&#1077;&#1079;&#1085;&#1099;&#1084;&#1080; &#1089;&#1074;&#1086;&#1081;&#1089;&#1090;&#1074;&#1072;&#1084;&#1080;.<br></span><span
                        style="color:#000000;font-size:13px;"><strong><em><u><br>&#1060;&#1072;&#1089;&#1086;&#1074;&#1082;&#1072;:</u></em></strong><br>- &#1087;&#1086; 50 &#1082;&#1075; (&#1087;&#1086;&#1083;&#1080;&#1087;&#1088;&#1086;&#1087;&#1080;&#1083;&#1077;&#1085;&#1086;&#1074;&#1099;&#1081; &#1084;&#1077;&#1096;&#1086;&#1082;)</span>
            </div>
            <div id="wb_Shape5" style="position:absolute;left:19px;top:274px;width:192px;height:42px;z-index:26;">
                <a href="#Layer27"><img class="hover" src="images/img0053_hover.png" alt=""
                                        style="border-width:0;width:192px;height:42px;"><span><img
                                src="images/img0053.png" id="Shape5" alt="" style="width:192px;height:42px;"></span></a>
            </div>
        </div>
        <div id="Layer41"
             style="position:absolute;text-align:left;left:490px;top:290px;width:457px;height:378px;z-index:42;">
            <div id="wb_Image16" style="position:absolute;left:4px;top:34px;width:242px;height:214px;z-index:27;">
                <img src="images/p1.jpg" id="Image16" alt=""></div>
            <div id="wb_Text35"
                 style="position:absolute;left:219px;top:29px;width:231px;height:258px;z-index:28;text-align:left;">
                <span style="color:#FC2014;font-size:21px;"><strong>МУКА ПШЕНИЧНАЯ ХЛЕБОПЕКАРНАЯ<br>1 СОРТ</strong></span><span
                        style="color:#FC2014;font-size:8px;"><strong><br></strong></span><span
                        style="color:#1E1E1E;font-size:8px;"><br></span><span
                        style="color:#000000;font-size:13px;"><strong>&#1043;&#1054;&#1057;&#1058; &#1056; 52189-2003<br></strong></span><span
                        style="color:#000000;font-size:8px;"><strong><br></strong></span><span
                        style="color:#000000;font-size:11px;">&#1052;&#1091;&#1082;&#1072; &#1087;&#1077;&#1088;&#1074;&#1086;&#1075;&#1086; &#1089;&#1086;&#1088;&#1090;&#1072; <strong>&#0045;</strong> &#1101;&#1090;&#1086; &#1087;&#1096;&#1077;&#1085;&#1080;&#1095;&#1085;&#1072;&#1103; &#1084;&#1091;&#1082;&#1072; &#1073;&#1086;&#1083;&#1077;&#1077; &#1075;&#1088;&#1091;&#1073;&#1086;&#1075;&#1086; &#1087;&#1086;&#1084;&#1086;&#1083;&#1072;, &#1095;&#1077;&#1084; &#1084;&#1091;&#1082;&#1072; &#1074;&#1099;&#1089;&#1096;&#1077;&#1075;&#1086; &#1089;&#1086;&#1088;&#1090;&#1072;.<br>&#1056;&#1077;&#1082;&#1086;&#1084;&#1077;&#1085;&#1076;&#1091;&#1077;&#1090;&#1089;&#1103; &#1076;&#1083;&#1103; &#1085;&#1077;&#1089;&#1076;&#1086;&#1073;&#1085;&#1086;&#1081; &#1074;&#1099;&#1087;&#1077;&#1095;&#1082;&#1080;(&#1087;&#1080;&#1088;&#1086;&#1075;&#1086;&#1074;,&#1073;&#1091;&#1083;&#1086;&#1082;,&#1086;&#1083;&#1072;&#1076;&#1080;&#1081;,&#1073;&#1083;&#1080;&#1085;&#1086;&#1074; &#1080; &#1090;.&#1076;.) &#1080; &#1076;&#1083;&#1103; &#1074;&#1099;&#1087;&#1077;&#1095;&#1082;&#1080; &#1088;&#1072;&#1079;&#1085;&#1086;&#1086;&#1073;&#1088;&#1072;&#1079;&#1085;&#1099;&#1093; &#1093;&#1083;&#1077;&#1073;&#1085;&#1099;&#1093; &#1080;&#1079;&#1076;&#1077;&#1083;&#1080;&#1081;</span><span
                        style="color:#000000;font-size:13px;"><br><br><strong><em><u>&#1060;&#1072;&#1089;&#1086;&#1074;&#1082;&#1072;:</u></em></strong><br>- 50 &#1082;&#1075; (&#1087;&#1086;&#1083;&#1080;&#1087;&#1088;&#1086;&#1087;&#1080;&#1083;&#1077;&#1085;&#1086;&#1074;&#1099;&#1081; &#1084;&#1077;&#1096;&#1086;&#1082;)<br>- 25 &#1082;&#1075; (&#1087;&#1086;&#1083;&#1080;&#1087;&#1088;&#1086;&#1087;&#1080;&#1083;&#1077;&#1085;&#1086;&#1074;&#1099;&#1081; &#1084;&#1077;&#1096;&#1086;&#1082;)</span><span
                        style="color:#1E1E1E;font-size:16px;"><br></span></div>
            <div id="wb_Shape20" style="position:absolute;left:19px;top:274px;width:192px;height:42px;z-index:29;">
                <a href="#Layer27"><img class="hover" src="images/img0054_hover.png" alt=""
                                        style="border-width:0;width:192px;height:42px;"><span><img
                                src="images/img0054.png" id="Shape20" alt=""
                                style="width:192px;height:42px;"></span></a></div>
        </div>
        <div id="Layer42"
             style="position:absolute;text-align:left;left:10px;top:1130px;width:457px;height:420px;z-index:43;">
            <div id="wb_Image45" style="position:absolute;left:4px;top:34px;width:242px;height:214px;z-index:30;">
                <img src="images/hgjmgu.jpg" id="Image45" alt=""></div>
            <div id="wb_Text37"
                 style="position:absolute;left:219px;top:29px;width:231px;height:290px;z-index:31;text-align:left;">
                <span style="color:#FC2014;font-size:21px;"><strong>МАННАЯ КРУПА</strong></span><span
                        style="color:#FC2014;font-size:8px;"><strong><br></strong></span><span
                        style="color:#1E1E1E;font-size:8px;"><br></span><span
                        style="color:#000000;font-size:13px;"><strong>Марка М<br></strong></span><span
                        style="color:#000000;font-size:8px;"><strong><br></strong></span><span
                        style="color:#000000;font-size:11px;">&#1052;&#1072;&#1085;&#1085;&#1072;&#1103; &#1082;&#1088;&#1091;&#1087;&#1072; (&#1074; &#1087;&#1088;&#1086;&#1089;&#1090;&#1086;&#1088;&#1077;&#1095;&#1080;&#1080; &#1084;&#1072;&#1085;&#1082;&#1072;) &#0045; &#1087;&#1096;&#1077;&#1085;&#1080;&#1095;&#1085;&#1072;&#1103; &#1082;&#1088;&#1091;&#1087;&#1072; &#1075;&#1088;&#1091;&#1073;&#1086;&#1075;&#1086; &#1087;&#1086;&#1084;&#1086;&#1083;&#1072; &#1089;&#1086; &#1089;&#1088;&#1077;&#1076;&#1085;&#1080;&#1084; &#1076;&#1080;&#1072;&#1084;&#1077;&#1090;&#1088;&#1086;&#1084; &#1095;&#1072;&#1089;&#1090;&#1080;&#1094; &#1086;&#1090; 0,25 &#1076;&#1086; 0,75 &#1084;&#1084;. &#1052;&#1072;&#1085;&#1085;&#1072;&#1103; &#1082;&#1088;&#1091;&#1087;&#1072; &#1080;&#1079;&#1075;&#1086;&#1090;&#1072;&#1074;&#1083;&#1080;&#1074;&#1072;&#1077;&#1090;&#1089;&#1103; &#1080;&#1079; &#1087;&#1096;&#1077;&#1085;&#1080;&#1094;&#1099;. &#1054;&#1085;&#1072; &#1073;&#1099;&#1089;&#1090;&#1088;&#1086; &#1088;&#1072;&#1079;&#1074;&#1072;&#1088;&#1080;&#1074;&#1072;&#1077;&#1090;&#1089;&#1103;, &#1093;&#1086;&#1088;&#1086;&#1096;&#1086; &#1091;&#1089;&#1074;&#1072;&#1080;&#1074;&#1072;&#1077;&#1090;&#1089;&#1103;, &#1089;&#1086;&#1076;&#1077;&#1088;&#1078;&#1080;&#1090; &#1084;&#1080;&#1085;&#1080;&#1084;&#1072;&#1083;&#1100;&#1085;&#1086;&#1077; &#1082;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1082;&#1083;&#1077;&#1090;&#1095;&#1072;&#1090;&#1082;&#1080; (0,2%). &#1048;&#1079; &#1084;&#1072;&#1085;&#1085;&#1086;&#1081; &#1082;&#1088;&#1091;&#1087;&#1099; &#1075;&#1086;&#1090;&#1086;&#1074;&#1103;&#1090; &#1087;&#1077;&#1088;&#1074;&#1099;&#1077; б&#1083;&#1102;&#1076;&#1072;, &#1082;&#1072;&#1096;&#1080;, &#1086;&#1083;&#1072;&#1076;&#1100;&#1080;, &#1079;&#1072;&#1087;&#1077;&#1082;&#1072;&#1085;&#1082;&#1080;, &#1073;&#1080;&#1090;&#1086;&#1095;&#1082;&#1080;, &#1087;&#1091;&#1076;&#1080;&#1085;&#1075;&#1080;, &#1089;&#1091;&#1092;&#1083;&#1077;.<br><br><em>&#0171;&#1052;&#1072;&#1088;&#1082;&#1072; &#1052;&#0187; - &#1086;&#1073;&#1086;&#1079;&#1085;&#1072;&#1095;&#1072;&#1077;&#1090;,&#1095;&#1090;&#1086; &#1082;&#1088;&#1091;&#1087;&#1072; &#1080;&#1079;&#1075;&#1086;&#1090;&#1086;&#1074;&#1083;&#1077;&#1085;&#1072; &#1080;&#1079; &#1084;&#1103;&#1075;&#1082;&#1080;&#1093; &#1089;&#1086;&#1088;&#1090;&#1086;&#1074; &#1087;&#1096;&#1077;&#1085;&#1080;&#1094;&#1099;.<br></em></span><span
                        style="color:#000000;font-size:13px;"><br><strong><em><u>&#1060;&#1072;&#1089;&#1086;&#1074;&#1082;&#1072;</em></strong>:</u>
                    <br>- &#1087;&#1086; 50 &#1082;&#1075; (&#1087;&#1086;&#1083;&#1080;&#1087;&#1088;&#1086;&#1087;&#1080;&#1083;&#1077;&#1085;&#1086;&#1074;&#1099;&#1081; &#1084;&#1077;&#1096;&#1086;&#1082;)</span>
            </div>
            <div id="wb_Shape21" style="position:absolute;left:19px;top:274px;width:192px;height:42px;z-index:32;">
                <a href="#Layer27"><img class="hover" src="images/img0057_hover.png" alt=""
                                        style="border-width:0;width:192px;height:42px;"><span><img
                                src="images/img0057.png" id="Shape21" alt=""
                                style="width:192px;height:42px;"></span></a></div>
        </div>
        <div id="Layer30"
             style="position:absolute;text-align:left;left:490px;top:700px;width:457px;height:400px;z-index:44;">
            <div id="wb_Image44" style="position:absolute;left:4px;top:34px;width:243px;height:215px;z-index:33;">
                <img src="images/p2.jpg" id="Image44" alt=""></div>
            <div id="wb_Text36"
                 style="position:absolute;left:219px;top:29px;width:231px;height:342px;z-index:34;text-align:left;">
                <span style="color:#FC2014;font-size:21px;"><strong>МУКА ПШЕНИЧНАЯ<br>ЦЕЛЬНОЗЕРНОВАЯ </strong></span><span
                        style="color:#1E1E1E;font-size:19px;"><br></span><span
                        style="color:#1E1E1E;font-size:8px;"><br></span><span
                        style="color:#000000;font-size:13px;"><strong>Мука грубого помола<br></strong></span><span
                        style="color:#000000;font-size:8px;"><strong><br></strong></span><span
                        style="color:#000000;font-size:11px;">И&#1076;&#1077;&#1072;&#1083;&#1100;&#1085;&#1099;&#1081; &#1087;&#1088;&#1086;&#1076;&#1091;&#1082;&#1090; &#1076;&#1083;&#1103; &#1079;&#1076;&#1086;&#1088;&#1086;&#1074;&#1086;&#1075;&#1086; &#1087;&#1080;&#1090;&#1072;&#1085;&#1080;&#1103;. &#1047;&#1077;&#1088;&#1085;&#1086; &#1087;&#1077;&#1088;&#1077;&#1084;&#1072;&#1083;&#1099;&#1074;&#1072;&#1077;&#1090;&#1089;&#1103; &#1074;&#1084;&#1077;&#1089;&#1090;&#1077; &#1089; &#1086;&#1073;&#1086;&#1083;&#1086;&#1095;&#1082;&#1086;&#1081;, &#1095;&#1090;&#1086; &#1087;&#1086;&#1079;&#1074;&#1086;&#1083;&#1103;&#1077;&#1090; &#1089;&#1086;&#1093;&#1088;&#1072;&#1085;&#1080;&#1090;&#1100; &#1074; &#1084;&#1091;&#1082;&#1077; &#1084;&#1072;&#1082;&#1089;&#1080;&#1084;&#1072;&#1083;&#1100;&#1085;&#1086;&#1077; &#1082;&#1086;&#1083;&#1080;&#1095;&#1077;&#1089;&#1090;&#1074;&#1086; &#1074;&#1080;&#1090;&#1072;&#1084;&#1080;&#1085;&#1086;&#1074; &#1080; &#1087;&#1086;&#1083;&#1077;&#1079;&#1085;&#1099;&#1093; &#1089;&#1074;&#1086;&#1081;&#1089;&#1090;&#1074;. &#1042; &#1089;&#1086;&#1089;&#1090;&#1072;&#1074;&#1077;: &#1042; &#1080; &#1045; &#1074;&#1080;&#1090;&#1072;&#1084;&#1080;&#1085;&#1099;, &#1084;&#1080;&#1085;&#1077;&#1088;&#1072;&#1083;&#1100;&#1085;&#1099;&#1077; &#1089;&#1086;&#1083;&#1080; &#1092;&#1086;&#1089;&#1092;&#1072;&#1090;&#1072;, &#1082;&#1072;&#1083;&#1100;&#1094;&#1080;&#1103;, &#1084;&#1072;&#1075;&#1085;&#1080;&#1103;, &#1078;&#1077;&#1083;&#1077;&#1079;&#1072;. &#1057;&#1086;&#1076;&#1077;&#1088;&#1078;&#1072;&#1085;&#1080;&#1077; &#1082;&#1083;&#1077;&#1081;&#1082;&#1086;&#1074;&#1080;&#1085;&#1099; &#1079;&#1085;&#1072;&#1095;&#1080;&#1090;&#1077;&#1083;&#1100;&#1085;&#1086; &#1085;&#1080;&#1078;&#1077;, &#1095;&#1077;&#1084; &#1091; &#1083;&#1102;&#1073;&#1086;&#1081; &#1076;&#1088;&#1091;&#1075;&#1086;&#1081; &#1087;&#1096;&#1077;&#1085;&#1080;&#1095;&#1085;&#1086;&#1081; &#1084;&#1091;&#1082;&#1080;. &#1050;&#1083;&#1077;&#1090;&#1095;&#1072;&#1090;&#1082;&#1072; &#1087;&#1086;&#1084;&#1086;&#1075;&#1072;&#1077;&#1090; &#1086;&#1095;&#1080;&#1089;&#1090;&#1080;&#1090;&#1100; &#1086;&#1088;&#1075;&#1072;&#1085;&#1080;&#1079;&#1084; &#1086;&#1090; &#1096;&#1083;&#1072;&#1082;&#1086;&#1074; &#1080; &#1076;&#1088;&#1091;&#1075;&#1080;&#1093; &#1074;&#1088;&#1077;&#1076;&#1085;&#1099;&#1093; &#1074;&#1077;&#1097;&#1077;&#1089;&#1090;&#1074;, а также &#1087;&#1086;&#1076;&#1076;&#1077;&#1088;&#1078;&#1080;&#1074;&#1072;&#1090;&#1100; &#1084;&#1080;&#1082;&#1088;&#1086;&#1092;&#1083;&#1086;&#1088;&#1091; &#1082;&#1080;&#1096;&#1077;&#1095;&#1085;&#1080;&#1082;&#1072;. &#1061;&#1083;&#1077;&#1073; &#1080;&#1079; &#1094;&#1077;&#1083;&#1100;&#1085;&#1086;&#1079;&#1077;&#1088;&#1085;&#1086;&#1074;&#1086;&#1081; &#1084;&#1091;&#1082;&#1080; &#1087;&#1086;&#1083;&#1091;&#1095;&#1072;&#1077;&#1090;&#1089;&#1103; &#1073;&#1086;&#1083;&#1077;&#1077; &#1074;&#1082;&#1091;&#1089;&#1085;&#1099;&#1084; &#1080; &#1072;&#1088;&#1086;&#1084;&#1072;&#1090;&#1085;&#1099;&#1084;,&#1072; &#1075;&#1083;&#1072;&#1074;&#1085;&#1086;&#1077; &#1087;&#1086;&#1083;&#1077;&#1079;&#1085;&#1099;&#1084;.<br></span><span
                        style="color:#000000;font-size:13px;"><br><strong><em><u>&#1060;&#1072;&#1089;&#1086;&#1074;&#1082;&#1072;:</em></strong><br></u>
                    - &#1087;&#1086; 50 &#1082;&#1075; (&#1087;&#1086;&#1083;&#1080;&#1087;&#1088;&#1086;&#1087;&#1080;&#1083;&#1077;&#1085;&#1086;&#1074;&#1099;&#1081; &#1084;&#1077;&#1096;&#1086;&#1082;)</span>
            </div>
            <div id="wb_Shape17" style="position:absolute;left:19px;top:274px;width:192px;height:42px;z-index:35;">
                <a href="#Layer27"><img class="hover" src="images/img0055_hover.png" alt=""
                                        style="border-width:0;width:192px;height:42px;"><span><img
                                src="images/img0055.png" id="Shape17" alt=""
                                style="width:192px;height:42px;"></span></a></div>
        </div>
        <div id="Layer43"
             style="position:absolute;text-align:left;left:490px;top:1130px;width:457px;height:420px;z-index:45;">
            <div id="wb_Image46" style="position:absolute;left:4px;top:34px;width:243px;height:214px;z-index:36;">
                <img src="images/s5eythdg.jpg" id="Image46" alt=""></div>
            <div id="wb_Text43"
                 style="position:absolute;left:219px;top:29px;width:231px;height:350px;z-index:37;text-align:left;">
                <span style="color:#FC2014;font-size:21px;"><strong>ОТРУБИ КОРМОВЫЕ</strong></span><span
                        style="color:#1E1E1E;font-size:19px;"><br></span><span
                        style="color:#000000;font-size:8px;"><strong><br></strong></span><span
                        style="color:#000000;font-size:13px;"><strong>&#1043;&#1054;&#1057;&#1058; 7169-66<br></strong></span><span
                        style="color:#000000;font-size:8px;"><strong><br></strong></span><span
                        style="color:#000000;font-size:11px;">&#1055;&#1096;&#1077;&#1085;&#1080;&#1095;&#1085;&#1099;&#1077; &#1086;&#1090;&#1088;&#1091;&#1073;&#1080;, &#1101;&#1090;&#1086; &#1087;&#1088;&#1086;&#1076;&#1091;&#1082;&#1090;,&#1082;&#1086;&#1090;&#1086;&#1088;&#1099;&#1081; &#1087;&#1086;&#1083;&#1091;&#1095;&#1072;&#1077;&#1090;&#1089;&#1103;,&#1074; &#1087;&#1088;&#1086;&#1094;&#1077;&#1089;&#1089;&#1077; &#1087;&#1077;&#1088;&#1077;&#1088;&#1072;&#1073;&#1086;&#1090;&#1082;&#1080; &#1087;&#1096;&#1077;&#1085;&#1080;&#1094;&#1099;.<br>&#1054;&#1089;&#1085;&#1086;&#1074;&#1085;&#1086;&#1081; &#1082;&#1086;&#1084;&#1087;&#1086;&#1085;&#1077;&#1085;&#1090; &#1086;&#1090;&#1088;&#1091;&#1073;&#1077;&#1081; &#0045; &#1082;&#1083;&#1077;&#1090;&#1095;&#1072;&#1090;&#1082;&#1072;. &#1048;&#1084;&#1077;&#1085;&#1085;&#1086; &#1077;&#1077; &#1085;&#1072;&#1083;&#1080;&#1095;&#1080;&#1077; &#1074; &#1089;&#1086;&#1089;&#1090;&#1072;&#1074;&#1077; &#1087;&#1096;&#1077;&#1085;&#1080;&#1095;&#1085;&#1099;&#1093; &#1086;&#1090;&#1088;&#1091;&#1073;&#1077;&#1081; &#1086;&#1082;&#1072;&#1079;&#1099;&#1074;&#1077;&#1090; &#1073;&#1083;&#1072;&#1075;&#1086;&#1087;&#1088;&#1080;&#1103;&#1090;&#1085;&#1086;&#1077; &#1076;&#1077;&#1081;&#1089;&#1090;&#1074;&#1080;&#1077; &#1085;&#1072; &#1087;&#1080;&#1097;&#1077;&#1074;&#1072;&#1088;&#1077;&#1085;&#1080;&#1077; &#1078;&#1080;&#1074;&#1086;&#1090;&#1085;&#1086;&#1075;&#1086;.<br>&#1055;&#1096;&#1077;&#1085;&#1080;&#1095;&#1085;&#1099;&#1077; &#1086;&#1090;&#1088;&#1091;&#1073;&#1080; - &#1085;&#1072;&#1080;&#1073;&#1086;&#1083;&#1077;&#1077; &#1074;&#1086;&#1089;&#1090;&#1088;&#1077;&#1073;&#1086;&#1074;&#1072;&#1085;&#1085;&#1099;&#1081; &#1074;&#1080;&#1076; &#1086;&#1090;&#1088;&#1091;&#1073;&#1077;&#1081; &#1074; &#1078;&#1080;&#1074;&#1086;&#1090;&#1085;&#1086;&#1074;&#1086;&#1076;&#1089;&#1090;&#1074;&#1077;, &#1087;&#1086;&#1090;&#1086;&#1084;&#1091; &#1095;&#1090;&#1086; &#1103;&#1074;&#1083;&#1103;&#1077;&#1090;&#1089;&#1103; &#1091;&#1085;&#1080;&#1074;&#1077;&#1088;&#1089;&#1072;&#1083;&#1100;&#1085;&#1099;&#1084;. &#1055;&#1086;&#1076;&#1093;&#1086;&#1076;&#1080;&#1090; &#1076;&#1083;&#1103; &#1082;&#1086;&#1088;&#1084;&#1083;&#1077;&#1085;&#1080;&#1103; &#1073;&#1086;&#1083;&#1100;&#1096;&#1080;&#1085;&#1089;&#1090;&#1074;&#1072; &#1074;&#1080;&#1076;&#1086;&#1074; &#1089;&#1077;&#1083;&#1100;&#1089;&#1082;&#1086;&#1093;&#1086;&#1079;&#1103;&#1081;&#1089;&#1090;&#1074;&#1077;&#1085;&#1085;&#1099;&#1093; &#1078;&#1080;&#1074;&#1086;&#1090;&#1085;&#1099;&#1093;.<br>&#1054;&#1090;&#1088;&#1091;&#1073;&#1080; &#1087;&#1088;&#1080;&#1084;&#1077;&#1085;&#1103;&#1102;&#1090;&#1089;&#1103; &#1074; &#1094;&#1077;&#1083;&#1103;&#1093; &#1092;&#1086;&#1088;&#1084;&#1080;&#1088;&#1086;&#1074;&#1072;&#1085;&#1080;&#1103; &#1079;&#1076;&#1086;&#1088;&#1086;&#1074;&#1086;&#1075;&#1086;, &#1087;&#1080;&#1090;&#1072;&#1090;&#1077;&#1083;&#1100;&#1085;&#1086;&#1075;&#1086; &#1080; с&#1073;&#1072;&#1083;&#1072;&#1085;&#1089;&#1080;&#1088;&#1086;&#1074;&#1072;&#1085;&#1085;&#1086;&#1075;&#1086; &#1088;&#1072;&#1094;&#1080;&#1086;&#1085;&#1072; &#1089;/&#1093; &#1078;&#1080;&#1074;&#1086;&#1090;&#1085;&#1099;&#1093;.<br></span><span
                        style="color:#000000;font-size:13px;"><strong><em><u><br>&#1060;&#1072;&#1089;&#1086;&#1074;&#1082;&#1072;:</u></em></strong><br>- &#1086;&#1090; 20 &#1076;&#1086; 25 &#1082;&#1075; (&#1087;&#1086; &#1078;&#1077;&#1083;&#1072;&#1085;&#1080;&#1102; &#1082;&#1083;&#1080;&#1077;&#1085;&#1090;&#1072;) &#1074; &#1087;&#1086;&#1083;&#1080;&#1087;&#1088;&#1086;&#1087;&#1080;&#1083;&#1077;&#1085;&#1086;&#1074;&#1099;&#1077; &#1084;&#1077;&#1096;&#1082;&#1080;</span><span
                        style="color:#1E1E1E;font-size:16px;"><br></span></div>
            <div id="wb_Shape22" style="position:absolute;left:19px;top:274px;width:192px;height:42px;z-index:38;">
                <a href="#Layer27"><img class="hover" src="images/img0056_hover.png" alt=""
                                        style="border-width:0;width:192px;height:42px;"><span><img
                                src="images/img0056.png" id="Shape22" alt=""
                                style="width:192px;height:42px;"></span></a></div>
        </div>
    </div>
</div>
<div id="Layer24" style="position:absolute;text-align:center;left:0px;top:6528px;width:100%;height:203px;z-index:260;">
    <div id="Layer24_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text29"
             style="position:absolute;left:702px;top:179px;width:250px;height:16px;text-align:right;z-index:46;">
            <span style="color:#000000;font-size:13px;">Разработка сайта: </span><span
                    style="color:#1E90FF;font-size:13px;"><strong>ВЕБ</strong></span><span
                    style="color:#FFA500;font-size:13px;"><strong>РЕШЕНИЯ</strong></span></div>
        <div id="wb_Text30"
             style="position:absolute;left:10px;top:179px;width:245px;height:16px;z-index:47;text-align:left;">
            <span style="color:#000000;font-size:13px;"><a
                        href="javascript:displaylightbox('./policity.html',{width:480,height:400,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                        target="_self" class="style2">Политика конфиденциальности</a></span></div>
        <div id="wb_Text31"
             style="position:absolute;left:0px;top:49px;width:960px;height:76px;text-align:center;z-index:48;">
            <span style="color:#000000;font-size:43px;">Остались вопросы?</span><span
                    style="color:#000000;font-size:13px;"><br></span><span
                    style="color:#000000;font-size:24px;"><a
                        href="javascript:displaylightbox('./vopros.php',{width:400,height:560,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                        target="_self" class="style2">Задайте их нашему менеджеру</a></span></div>
        <div id="wb_Shape6" style="position:absolute;left:855px;top:170px;width:102px;height:33px;z-index:49;">
            <a href="http://web-sol.ru/" target="_blank"><img src="images/img0002.png" id="Shape6" alt=""
                                                              style="width:102px;height:33px;"></a></div>
    </div>
    <a href="http://vk.com/gladkov_pasha" target="_blank"
       style="display: block;position:absolute;right:610px;top:179px;height:16px;text-align:right;z-index:46;">Продвижение
        сайта Павел Гладков</a>
</div>
<div id="Layer2"
     style="position:absolute;text-align:center;left:0px;top:0px;width:100%;height:720px;z-index:261;background-attachment:fixed;">
    <div id="Layer2_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text5"
             style="position:absolute;left:0px;top:173px;width:960px;height:116px;text-align:center;z-index:56;text-shadow: 0px 1px 0px rgba(255,255,255,0.8);">
            <span style="color:#FC2014;font-weidht:bold;font-size:53px;"><?php echo $zag; ?></span><br><span
                    style="color:#1E1E1E;font-size:37px;">ОПТОМ ОТ ПРОИЗВОДИТЕЛЯ В КРАСНОДАРЕ</span>
        </div>
        <div id="wb_Text4"
             style="position:absolute;left:0px;top:310px;width:960px;height:32px;text-align:center;z-index:57;text-shadow: 0px 1px 0px rgba(255,255,255,0.8);">
            <span style="color:#1E1E1E;font-size:27px;">Производство пшеничной муки, манной крупы и кормовых отрубей</span>
        </div>
        <div id="Layer29"
             style="position:absolute;text-align:left;left:50px;top:424px;width:860px;height:185px;z-index:58;border-radius:5px;">
        </div>
        <div id="wb_Form3" style="position:absolute;left:50px;top:424px;width:860px;height:175px;z-index:59;">
            <form name="FormCompr" method="post" action="<?php echo basename(__FILE__); ?>"
                  enctype="multipart/form-data" accept-charset="UTF-8" id="Form3"
                  onsubmit="yaCounter41390209.reachGoal('predlojenie');return true;">
                <input type="hidden" name="formid" value="form3">
                <div id="wb_Text38"
                     style="position:absolute;left:0px;top:21px;width:860px;height:48px;text-align:center;z-index:51;">
                    <span style="color:#000000;font-size:21px;">Оставьте заявку и получите индивидуальное <br>коммерческое предложение прямо сейчас</span>
                </div>
<!--
                <input type="text" id="Editbox7"
                       style="position:absolute;left:10px;top:95px;width:196px;height:26px;line-height:26px;z-index:52;"
                       name="Имя" value="" required placeholder="&#1042;&#1072;&#1096;&#1077; &#1080;&#1084;&#1103;*">
-->
                <input type="text" id="Editbox8"
                       style="position:absolute;left:30px;top:95px;width:590px;height:26px;line-height:26px;z-index:53;"
                       name="Телефон" value="" required
                       placeholder="&#1042;&#1072;&#1096; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;*">
<!--
                <input type="text" id="Editbox9"
                       style="position:absolute;left:460px;top:95px;width:196px;height:26px;line-height:26px;z-index:54;"
                       name="E-mail" value="" required placeholder="&#1042;&#1072;&#1096; e-mail*">
-->
                <input type="submit" id="Button3" name="" value="Получить"
                       style="position:absolute;left:665px;top:95px;width:165px;height:38px;z-index:55;cursor:pointer;">
                <div style="position:absolute;display:flex;align-items:center;top:145px;font-size:15px;left:255px;">
                    <input type="checkbox" id="policy3" required checked/><label for="policy3">С <a
                                href="javascript:displaylightbox('./policity.html',{width:480,height:400,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                                target="_self">политикой конфиденциальности</a> ознакомлен</label></div>
            </form>
        </div>
    </div>
</div>
<div id="Layer1"
     style="position:absolute;text-align:left;left:0px;top:0px;width:100%;height:140px;z-index:262;position:fixed; z-index:99999;">
    <div id="Layer4" style="position:absolute;text-align:left;left:0px;top:0px;width:100%;height:70px;z-index:70;">
    </div>
    <div id="Layer5" style="position:absolute;text-align:center;left:0px;top:64px;width:100%;height:76px;z-index:71;">
        <div id="Layer5_Container"
             style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
            <div id="wb_Shape1" style="position:absolute;left:388px;top:0px;width:184px;height:66px;z-index:60;">
                <img src="images/img0078.png" id="Shape1" alt="" style="width:184px;height:66px;"></div>
        </div>
    </div>
    <div id="Layer3" style="position:absolute;text-align:center;left:0px;top:5px;width:100%;height:115px;z-index:72;">
        <div id="Layer3_Container"
             style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
            <div id="wb_Text3"
                 style="position:absolute;left:10px;top:20px;height:16px;z-index:61;text-align:left;">
                <span style="color:#000000;font-size:13px;"><a href="/#Layer8" class="style1">Продукция</a></span>
            </div>
            <div id="wb_Image1" style="position:absolute;left:409px;top:0px;width:143px;height:103px;z-index:62;">
                <a href="#Layer2"><img src="images/logo.png" id="Image1" alt=""></a></div>
            <div id="wb_Text2"
                 style="position: absolute; left: 646px; top: 10px; border-radius: 5px; z-index: 63; text-align: center; background-color: #fd2d0e; padding: 5px 15px; color: white;">
                <span style="color:#000000;font-size:13px;"><a href="https://yadi.sk/i/oCnY7zQRzQQb5" class="style1 price-list" target="_blank"><b>Скачать<br>прайс лист</b></a></span></div>
            <div id="wb_Text7"
                 style="position:absolute;left:100px;top:20px;height:16px;z-index:64;text-align:left;">
                <span style="color:#000000;font-size:13px;"><a href="/#Layer26" class="style1">Производство</a></span>
            </div>
            <div id="wb_Text6"
                 style="position:absolute;left:770px;top:5px;height:22px;text-align:center;z-index:65;">
                <span style="color:#000000;font-size:19px;"><strong>+7 (938) 515-61-61</strong></span>
            </div>
            <div id="wb_Shape3" style="position:absolute;left:770px;top:30px;width:184px;height:29px;z-index:66;">
                <a href="javascript:displaylightbox('./callback.php',{width:480,height:400,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                   target="_self"><img class="hover" src="images/img0079_hover.png" alt=""
                                       style="border-width:0;width:184px;height:29px;"><span><img
                                src="images/img0079.png" id="Shape3" alt="" style="width:184px;height:29px;"></span></a>
            </div>
            <div id="wb_Text9"
                 style="position:absolute;left:310px;top:20px;height:16px;z-index:67;text-align:left;">
                <span style="color:#000000;font-size:13px;"><a href="buy.php" class="style1" target="_blank">Мы закупаем</a></span>
            </div>
            <div id="wb_Text1"
                 style="position:absolute;left:205px;top:20px;height:16px;z-index:68;text-align:left;">
                <span style="color:#000000;font-size:13px;"><a href="/#Layer19" class="style1">Сертификаты</a></span>
            </div>
            <div id="wb_Text26"
                 style="position:absolute;left:570px;top:20px;height:16px;z-index:69;text-align:left;">
                <span style="color:#000000;font-size:13px;"><a href="/#Layer20" class="style1">Контакты</a></span>
            </div>
        </div>
    </div>
</div>
<div id="Layer9" style="position:absolute;text-align:center;left:0px;top:600px;width:100%;height:310px;z-index:263;">
    <div id="Layer9_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="Layer10"
             style="position:absolute;text-align:left;left:0px;top:40px;width:192px;height:220px;z-index:93;">
            <div id="wb_Text10"
                 style="position:absolute;left:0px;top:141px;width:192px;height:35px;text-align:center;z-index:83;">
                <span style="color:#1E1E1E;font-size:15px;"><strong>Оперативная доставка <br></strong>по всей России</span>
            </div>
            <div id="wb_Image4" style="position:absolute;left:40px;top:25px;width:100px;height:100px;z-index:84;">
                <img src="images/i1.png" id="Image4" alt=""></div>
        </div>
        <div id="Layer11"
             style="position:absolute;text-align:left;left:192px;top:40px;width:192px;height:220px;z-index:94;">
            <div id="wb_Text11"
                 style="position:absolute;left:0px;top:141px;width:192px;height:53px;text-align:center;z-index:85;">
                <span style="color:#1E1E1E;font-size:15px;"><strong>Гарантия высокого уровня качества </strong>поставляемой продукции</span>
            </div>
            <div id="wb_Image8" style="position:absolute;left:43px;top:25px;width:100px;height:100px;z-index:86;">
                <img src="images/i5.png" id="Image8" alt=""></div>
        </div>
        <div id="Layer12"
             style="position:absolute;text-align:left;left:384px;top:40px;width:192px;height:220px;z-index:95;">
            <div id="wb_Text12"
                 style="position:absolute;left:0px;top:141px;width:192px;height:35px;text-align:center;z-index:87;">
                <span style="color:#1E1E1E;font-size:15px;"><strong>Цены без комиссии<br></strong>от производителя</span>
            </div>
            <div id="wb_Image7" style="position:absolute;left:41px;top:25px;width:100px;height:100px;z-index:88;">
                <img src="images/i4.png" id="Image7" alt=""></div>
        </div>
        <div id="Layer13"
             style="position:absolute;text-align:left;left:576px;top:40px;width:192px;height:220px;z-index:96;">
            <div id="wb_Text13"
                 style="position:absolute;left:0px;top:141px;width:192px;height:71px;text-align:center;z-index:89;">
                <span style="color:#1E1E1E;font-size:15px;"><strong>Экономия Вашего времени, </strong>благодаря прямому сотрудничеству<strong> без посредников</strong></span>
            </div>
            <div id="wb_Image5" style="position:absolute;left:39px;top:25px;width:100px;height:100px;z-index:90;">
                <img src="images/i2.png" id="Image5" alt=""></div>
        </div>
        <div id="Layer14"
             style="position:absolute;text-align:left;left:768px;top:40px;width:192px;height:220px;z-index:97;">
            <div id="wb_Text14"
                 style="position:absolute;left:0px;top:141px;width:192px;height:35px;text-align:center;z-index:91;">
                <span style="color:#1E1E1E;font-size:15px;">Вся продукция <strong>сертифицирована</strong></span>
            </div>
            <div id="wb_Image6" style="position:absolute;left:42px;top:25px;width:100px;height:100px;z-index:92;">
                <img src="images/i3.png" id="Image6" alt=""></div>
        </div>
    </div>
</div>
<div id="Layer20" style="position:absolute;text-align:left;left:0px;top:5978px;width:100%;height:550px;z-index:264;">
    <script type="text/javascript" charset="utf-8" async
            src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=m5P1GQQBzURVmc5BjLUnGVIEb9T2mqBO&amp;width=100%25&amp;height=550&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=false"></script>
    <div id="Layer23"
         style="position:absolute;text-align:center;left:0px;top:54px;width:100%;height:496px;z-index:120;">
        <div id="Layer23_Container"
             style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
            <div id="Layer17"
                 style="position:absolute;text-align:left;left:0px;top:0px;width:480px;height:496px;z-index:118;">
                <div id="wb_Text41"
                     style="position:absolute;left:85px;top:75px;width:338px;height:60px;z-index:108;text-align:left;">
                    <span style="color:#1E1E1E;font-weidht:bold;font-size:43px;">КОНТАКТЫ</span></div>
                <div id="wb_Image39" style="position:absolute;left:89px;top:168px;width:18px;height:24px;z-index:109;">
                    <img src="images/i11.png" id="Image39" alt=""></div>
                <div id="wb_Image41" style="position:absolute;left:89px;top:243px;width:21px;height:21px;z-index:110;">
                    <img src="images/i22.png" id="Image41" alt=""></div>
                <div id="wb_Image42" style="position:absolute;left:87px;top:287px;width:24px;height:25px;z-index:111;">
                    <img src="images/i33.png" id="Image42" alt=""></div>
                <div id="wb_Image43" style="position:absolute;left:89px;top:337px;width:20px;height:14px;z-index:112;">
                    <img src="images/i44.png" id="Image43" alt=""></div>
                <div id="wb_Text58"
                     style="position:absolute;left:123px;top:334px;width:250px;height:19px;z-index:113;text-align:left;">
                    <span style="color:#000000;font-size:17px;"><strong>E-mail:</strong> bsv10k@yandex.ru</span>
                </div>
                <div id="wb_Text59"
                     style="position:absolute;left:123px;top:289px;width:250px;height:19px;z-index:114;text-align:left;">
                    <span style="color:#000000;font-size:17px;"><strong>Факс:</strong> 8 (86162) 5-16-40</span>
                </div>
                <div id="wb_Text60"
                     style="position:absolute;left:123px;top:245px;width:250px;height:19px;z-index:115;text-align:left;">
                    <span style="color:#000000;font-size:17px;"><strong>Телефон:</strong> +7 (938) 515-61-61</span>
                </div>
                <div id="wb_Text57"
                     style="position:absolute;left:123px;top:170px;width:290px;height:57px;z-index:116;text-align:left;">
                    <span style="color:#000000;font-size:17px;"><strong>Адрес:</strong> 353204, Россия, Краснодарский край, ст. Динская, ул. Крайняя, 12А</span>
                </div>
                <div id="wb_Text61"
                     style="position:absolute;left:0px;top:410px;width:480px;height:38px;text-align:center;z-index:117;">
                    <span style="color:#000000;font-size:17px;"><strong>&quot;Динская мельница&quot; </strong><br>&#1048;&#1055; &#1041;&#1088;&#1077;&#1094;&#1082;&#1080;&#1081; &#1057;.&#1042;.</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="Layer28" style="position:absolute;text-align:left;left:0px;top:5450px;width:100%;height:582px;z-index:265;">
</div>
<div id="Layer15" style="position:absolute;text-align:center;left:0px;top:4810px;width:100%;height:640px;z-index:266;">
    <div id="Layer15_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Image12" style="position:absolute;left:710px;top:307px;width:171px;height:72px;z-index:132;">
            <img src="images/line2_21.png" id="Image12" alt=""></div>
        <div id="wb_Image25" style="position:absolute;left:304px;top:307px;width:171px;height:72px;z-index:133;">
            <img src="images/line2_21.png" id="Image25" alt=""></div>
        <div id="wb_Image29" style="position:absolute;left:499px;top:307px;width:182px;height:77px;z-index:134;">
            <img src="images/line1_12.png" id="Image29" alt=""></div>
        <div id="wb_Image30" style="position:absolute;left:88px;top:307px;width:182px;height:77px;z-index:135;">
            <img src="images/line1_12.png" id="Image30" alt=""></div>
        <div id="wb_Text8"
             style="position:absolute;left:0px;top:145px;width:960px;height:60px;text-align:center;z-index:136;">
            <span style="color:#1E1E1E;font-weidht:bold;font-size:43px;">КАК МЫ РАБОТАЕМ</span></div>
        <div id="wb_Text16"
             style="position:absolute;left:0px;top:372px;width:150px;height:80px;text-align:center;z-index:137;">
            <span style="color:#1E1E1E;font-size:17px;"><em>Вы оставляете заявку на сайте<br>или звоните по телефону</em></span>
        </div>
        <div id="wb_Text17"
             style="position:absolute;left:192px;top:439px;width:170px;height:80px;text-align:center;z-index:138;">
            <span style="color:#1E1E1E;font-size:17px;"><em>Мы в кратчайший срок делаем<br>расчет стоимости партии</em></span>
        </div>
        <div id="wb_Text18"
             style="position:absolute;left:395px;top:372px;width:170px;height:80px;text-align:center;z-index:139;">
            <span style="color:#1E1E1E;font-size:17px;"><em>Вы подтверждаете заказ и мы выставляем Вам счет</em></span>
        </div>
        <div id="wb_Shape9" style="position:absolute;left:30px;top:269px;width:89px;height:89px;z-index:140;">
            <img src="images/img0089.png" id="Shape9" alt="" style="width:89px;height:89px;"></div>
        <div id="wb_Image31" style="position:absolute;left:50px;top:289px;width:49px;height:50px;z-index:141;">
            <img src="images/f-1.png" id="Image31" alt=""></div>
        <div id="wb_Shape10" style="position:absolute;left:235px;top:334px;width:89px;height:89px;z-index:142;">
            <img src="images/img0109.png" id="Shape10" alt="" style="width:89px;height:89px;"></div>
        <div id="wb_Shape11" style="position:absolute;left:436px;top:269px;width:89px;height:89px;z-index:143;">
            <img src="images/img0110.png" id="Shape11" alt="" style="width:89px;height:89px;"></div>
        <div id="wb_Shape12" style="position:absolute;left:650px;top:334px;width:89px;height:89px;z-index:144;">
            <img src="images/img0111.png" id="Shape12" alt="" style="width:89px;height:89px;"></div>
        <div id="wb_Shape13" style="position:absolute;left:840px;top:269px;width:89px;height:89px;z-index:145;">
            <img src="images/img0112.png" id="Shape13" alt="" style="width:89px;height:89px;"></div>
        <div id="wb_Image32" style="position:absolute;left:263px;top:354px;width:34px;height:50px;z-index:146;">
            <img src="images/f2.png" id="Image32" alt=""></div>
        <div id="wb_Image33" style="position:absolute;left:462px;top:288px;width:39px;height:51px;z-index:147;">
            <img src="images/f3.png" id="Image33" alt=""></div>
        <div id="wb_Image34" style="position:absolute;left:675px;top:357px;width:40px;height:40px;z-index:148;">
            <img src="images/f4.png" id="Image34" alt=""></div>
        <div id="wb_Image37" style="position:absolute;left:860px;top:298px;width:50px;height:31px;z-index:149;">
            <img src="images/f5.png" id="Image37" alt=""></div>
        <div id="wb_Text19"
             style="position:absolute;left:610px;top:439px;width:165px;height:100px;text-align:center;z-index:150;">
            <span style="color:#1E1E1E;font-size:17px;"><em>Вы осуществляете оплату наличными<br>или банковским переводом</em></span>
        </div>
        <div id="wb_Text20"
             style="position:absolute;left:810px;top:372px;width:150px;height:140px;text-align:center;z-index:151;">
            <span style="color:#1E1E1E;font-size:17px;"><em>Вы забираете продукцию самостоятельно<br>со склада или мы доставляем ее<br>по указанному Вами адресу</em></span>
        </div>
        <div id="wb_Shape2" style="position:absolute;left:5px;top:460px;width:140px;height:29px;z-index:152;">
            <a href="#Layer18"><img class="hover" src="images/img0001_hover.png" alt=""
                                    style="border-width:0;width:140px;height:29px;"><span><img src="images/img0001.png"
                                                                                               id="Shape2" alt=""
                                                                                               style="width:140px;height:29px;"></span></a>
        </div>
    </div>
</div>
<div id="Layer27" style="position:absolute;text-align:left;left:0px;top:2400px;width:100%;height:1060px;z-index:267;">
    <div id="Layer34"
         style="position:absolute;text-align:center;left:0px;top:60px;width:100%;height:400px;z-index:178;">
        <div id="Layer34_Container"
             style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
            <div id="Layer35"
                 style="position:absolute;text-align:left;left:0px;top:0px;width:480px;height:600px;z-index:158;">
            </div>
        </div>
    </div>
    <div id="Layer32"
         style="position:absolute;text-align:left;left:0px;top:460px;width:480px;height:600px;z-index:179;width:50%;">
        <div id="Layer33"
             style="position:absolute;text-align:left;left:0px;top:0px;width:50%;height:600px;z-index:159;width:100%;">
        </div>
    </div>
    <div id="Layer37"
         style="position:absolute;text-align:center;left:0px;top:60px;width:100%;height:1200px;z-index:180;">
        <div id="Layer37_Container"
             style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
            <div id="wb_Form1" style="position:absolute;left:45px;top:257px;width:364px;height:308px;z-index:164;">
                <form name="FormPrice1" method="post" action="<?php echo basename(__FILE__); ?>"
                      enctype="multipart/form-data" accept-charset="UTF-8" id="Form1"
                      onsubmit="yaCounter41390209.reachGoal('price1');return true;">
                    <input type="hidden" name="formid" value="form1">
                    <!--
                    <input type="text" id="Editbox1"
                           style="position:absolute;left:25px;top:0;width:297px;height:40px;line-height:40px;z-index:160;"
                           name="Имя" value="" required
                           placeholder="&#1042;&#1072;&#1096;&#1077; &#1080;&#1084;&#1103;*">
                    <input type="text" id="Editbox2"
                           style="position:absolute;left:25px;top:65px;width:297px;height:40px;line-height:40px;z-index:161;"
                           name="Телефон" value="" required
                           placeholder="&#1042;&#1072;&#1096; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;*">
                    <input type="submit" id="Button1" name="submit" value="Получить полный прайс-лист"
                           style="position:absolute;left:25px;top:34px;width:314px;height:52px;z-index:162;background-image: linear-gradient(to top, #FC2014, #FF4500); cursor:pointer;">
                    <input type="text" id="Editbox3"
                           style="position:absolute;left:25px;top:130px;width:297px;height:40px;line-height:40px;z-index:163;"
                           name="E-mail" value="" required placeholder="&#1042;&#1072;&#1096; e-mail*">
                    <div style="position:absolute;display:flex;align-items:center;top:198px;font-size:13px;left:22px;">
                        <input type="checkbox" id="policy1" required checked/><label for="policy1">С <a
                                    href="javascript:displaylightbox('./policity.html',{width:480,height:400,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                                    target="_self">политикой конфиденциальности</a> ознакомлен</label></div>
                    -->
                </form>
                <a href="https://yadi.sk/i/oCnY7zQRzQQb5" id="Button1" target="_blank"
                       style="position:absolute;left:25px;top:34px;width:314px;z-index:162;background-image: linear-gradient(to top, #FC2014, #FF4500); cursor:pointer; padding: 16px; text-align: center; text-decoration: none;">
                    Получить полный прайс-лист
                </a>
            </div>
            <div id="wb_Text27"
                 style="position:absolute;left:71px;top:46px;width:338px;height:124px;z-index:165;text-align:left;">
                <span style="color:#1E1E1E;font-weidht:bold;font-size:43px;">ПОЛУЧИТЕ </span><span
                        style="color:#1E1E1E;font-size:27px;">ПОЛНЫЙ ПРАЙС-ЛИСТ<br>НА ПРОДУКЦИЮ</span>
            </div>
            <div id="wb_Text28"
                 style="position:absolute;left:71px;top:180px;width:338px;height:38px;z-index:166;text-align:left;">
                <span style="color:#000000;font-size:17px;">&#1054;&#1089;&#1090;&#1072;&#1074;&#1100;&#1090;&#1077; &#1079;&#1072;&#1103;&#1074;&#1082;&#1091; &#1080; &#1087;&#1086;&#1083;&#1091;&#1095;&#1080;&#1090;&#1077; &#1087;&#1086;&#1083;&#1085;&#1099;&#1081; &#1087;&#1088;&#1072;&#1081;&#1089;-&#1083;&#1080;&#1089;&#1090; &#1085;&#1072; &#1074;&#1089;&#1102; &#1087;&#1088;&#1086;&#1076;&#1091;&#1082;&#1094;&#1080;&#1102;</span>
            </div>
            <div id="wb_Text42"
                 style="position:absolute;left:30px;top:605px;width:435px;height:156px;z-index:167;text-align:left;">
                <span style="color:#FFFFFF;font-weidht:bold;font-size:37px;">ПРЕИМУЩЕСТВА <br>СОТРУДНИЧЕСТВА С НАМИ</span>
            </div>
            <div id="wb_Image10" style="position:absolute;left:525px;top:495px;width:41px;height:41px;z-index:168;">
                <img src="images/ic1.png" id="Image10" alt=""></div>
            <div id="wb_Image11" style="position:absolute;left:525px;top:583px;width:41px;height:41px;z-index:169;">
                <img src="images/ic2.png" id="Image11" alt=""></div>
            <div id="wb_Image35" style="position:absolute;left:515px;top:670px;width:58px;height:35px;z-index:170;">
                <img src="images/ic3.png" id="Image35" alt=""></div>
            <div id="wb_Image38" style="position:absolute;left:525px;top:755px;width:41px;height:42px;z-index:171;">
                <img src="images/ic4.png" id="Image38" alt=""></div>
            <div id="wb_Text44"
                 style="position:absolute;left:605px;top:495px;width:250px;height:44px;z-index:172;text-align:left;">
                <span style="color:#000000;font-size:19px;">&#1057;&#1086;&#1073;&#1083;&#1102;&#1076;&#1077;&#1085;&#1080;&#1077; &#1089;&#1088;&#1086;&#1082;&#1086;&#1074; &#1080; &#1075;&#1088;&#1072;&#1092;&#1080;&#1082;&#1086;&#1074; &#1087;&#1086;&#1089;&#1090;&#1072;&#1074;&#1086;&#1082;</span>
            </div>
            <div id="wb_Text45"
                 style="position:absolute;left:605px;top:590px;width:250px;height:22px;z-index:173;text-align:left;">
                <span style="color:#000000;font-size:19px;">&#1057;&#1082;&#1080;&#1076;&#1082;&#1072; &#1079;&#1072; &#1086;&#1073;&#1098;&#1077;&#1084;</span>
            </div>
            <div id="wb_Text46"
                 style="position:absolute;left:605px;top:758px;width:250px;height:44px;z-index:174;text-align:left;">
                <span style="color:#000000;font-size:19px;">&#1062;&#1077;&#1085;&#1099; &#1073;&#1077;&#1079; &#1082;&#1086;&#1084;&#1080;&#1089;&#1089;&#1080;&#1080;<br>&#1086;&#1090; &#1087;&#1088;&#1086;&#1080;&#1079;&#1074;&#1086;&#1076;&#1080;&#1090;&#1077;&#1083;&#1103;</span>
            </div>
            <div id="wb_Text47"
                 style="position:absolute;left:605px;top:675px;width:250px;height:22px;z-index:175;text-align:left;">
                <span style="color:#000000;font-size:19px;">&#1056;&#1072;&#1073;&#1086;&#1090;&#1072;&#1077;&#1084; &#1087;&#1086; &#1074;&#1089;&#1077;&#1081; &#1056;&#1086;&#1089;&#1089;&#1080;&#1080;</span>
            </div>
            <div id="wb_Text48"
                 style="position:absolute;left:605px;top:855px;width:285px;height:44px;z-index:176;text-align:left;">
                <span style="color:#000000;font-size:19px;">&#1042;&#1089;&#1103; &#1087;&#1088;&#1086;&#1076;&#1091;&#1082;&#1094;&#1080;&#1103; &#1089;&#1086;&#1086;&#1090;&#1074;&#1077;&#1090;&#1089;&#1090;&#1074;&#1091;&#1077;&#1090; &#1074;&#1089;&#1077;&#1084; &#1085;&#1086;&#1088;&#1084;&#1072;&#1084; &#1043;&#1054;&#1057;&#1058;</span>
            </div>
            <div id="wb_Image40" style="position:absolute;left:515px;top:850px;width:56px;height:34px;z-index:177;">
                <img src="images/ic6.png" id="Image40" alt=""></div>
        </div>
    </div>
</div>
<div id="Layer18" style="position:absolute;text-align:center;left:0px;top:5383px;width:100%;height:649px;z-index:268;">
    <div id="Layer18_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="Layer40"
             style="position:absolute;text-align:left;left:480px;top:67px;width:480px;height:582px;z-index:230;">
            <div id="wb_Text55"
                 style="position:absolute;left:85px;top:47px;width:338px;height:124px;z-index:227;text-align:left;">
                <span style="color:#1E1E1E;font-weidht:bold;font-size:43px;">ПОЛУЧИТЕ </span><span
                        style="color:#1E1E1E;font-size:27px;">ПОЛНЫЙ ПРАЙС-ЛИСТ<br>НА ПРОДУКЦИЮ</span>
            </div>
            <div id="wb_Form4" style="position:absolute;left:60px;top:262px;width:364px;height:308px;z-index:228;">
                <form name="FormPrice2" method="post" action="<?php echo basename(__FILE__); ?>"
                      enctype="multipart/form-data" accept-charset="UTF-8" id="Form4"
                      onsubmit="yaCounter41390209.reachGoal('price2');return true;">
                    <input type="hidden" name="formid" value="form4">
                    <input type="submit" id="Button4" name="submit" value="Получить прайс-лист"
                           style="position:absolute;left:25px;top:234px;width:314px;height:52px;z-index:225;background-image: linear-gradient(to top, #FC2014, #FF4500); cursor:pointer;">
                    <input type="text" id="Editbox12"
                           style="position:absolute;left:25px;top:130px;width:297px;height:40px;line-height:40px;z-index:226;"
                           name="E-mail" value="" required placeholder="&#1042;&#1072;&#1096; e-mail*">
                    <input type="text" id="Editbox11"
                           style="position:absolute;left:25px;top:65px;width:297px;height:40px;line-height:40px;z-index:231;"
                           name="Телефон" value="" required
                           placeholder="&#1042;&#1072;&#1096; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;*">
                    <input type="text" id="Editbox10"
                           style="position:absolute;left:25px;top:0px;width:297px;height:40px;line-height:40px;z-index:232;"
                           name="Имя" value="" required
                           placeholder="&#1042;&#1072;&#1096;&#1077; &#1080;&#1084;&#1103;*">
                    <div style="position:absolute;display:flex;align-items:center;top:198px;font-size:13px;left:22px;">
                        <input type="checkbox" id="policy2" required checked/><label for="policy2">С <a
                                    href="javascript:displaylightbox('./policity.html',{width:480,height:400,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                                    target="_self">политикой конфиденциальности</a> ознакомлен</label></div>
                </form>
            </div>
            <div id="wb_Text56"
                 style="position:absolute;left:85px;top:179px;width:338px;height:57px;z-index:229;text-align:left;">
                <span style="color:#000000;font-size:17px;">Оставьте заявку, и мы рассчитаем для Вас стоимость поставки в кратчайший срок</span>
            </div>
        </div>
    </div>
</div>

<!-- Yandex.Metrika counter -->
<script type="text/javascript"> (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter41390209 = new Ya.Metrika({
                    id: 41390209,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true,
                    trackHash: true
                });
            } catch (e) {
            }
        });
        var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () {
            n.parentNode.insertBefore(s, n);
        };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";
        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks"); </script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/41390209" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript> <!-- /Yandex.Metrika counter -->

<link rel="stylesheet" href="https://cdn.callbackkiller.com/widget/cbk.css">

<script type="text/javascript"
        src="https://cdn.callbackkiller.com/widget/cbk.js?cbk_code=ba5241ac3b4c373718ec82bef53b6ba6" charset="UTF-8"
        async></script>
</body>
</html>

<script>
    (function ($) {
        $('[id^=policy]').on('click', function () {
            console.log($(this).parents('form').find('[type=submit]'));
            if (!$(this).is(':checked')) {
                $(this).parents('form').find('[type=submit]').attr('disabled', 'disabled')
            } else {
                $(this).parents('form').find('[type=submit]').removeAttr('disabled')
            }
        })
    })(jQuery)
</script>