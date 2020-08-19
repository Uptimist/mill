<?php
function ValidateEmail($email)
{
    $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
    return preg_match($pattern, $email);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formid'] == 'form1') {
    $mailto = 'bsv10k@yandex.ru';
    $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
    $mailbcc = 'andrei-presser@yandex.ru';
    $subject = 'Заявка с моб. версии сайта DIN-MEL.RU';
    $message = 'Посетитель с мобильной версии сайта оставил заявку на прайс и перешел к его скачиванию';
    $success_url = './mobile-thankyou.html';
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
if ($_GET['p'] == 'c_muka') {
    $zag = 'ЦЕЛЬНОЗЕРНОВАЯ МУКА';
} else {
    $zag = 'МУКА ВЫСШЕЙ КАТЕГОРИИ';
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Динская мельница | Мука, отруби, манная крупа оптом от производителя из Краснодара</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link href="favicon.png" rel="shortcut icon" type="image/x-icon">
    <link href="lp.css" rel="stylesheet">
    <link href="/fonts/fregat.css" rel="stylesheet">
    <link href="mobile.css" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129269798-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-129269798-1');
    </script>
</head>
<body>
<div id="container">
</div>
<div id="Layer2" style="position:relative;height:425px;">
    <div id="Layer2_Container"
         style="width:320px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text5"
             style="position:absolute;left:0px;top:175px;width:320px;height:138px;text-align:center;z-index:0;text-shadow: 0px 1px 0px rgba(255,255,255,0.8);">
            <span style="line-height: 1.05;color:#FC2014;font-weight:bold;<?php if ($_GET['p'] == 'c_muka') {
                echo 'font-size:30px;';
            } else {
                echo 'font-size:35px;';
            } ?>"><?php echo $zag; ?></span><span
                    style="color:#FC2014;font-weight:bold;font-size:24px;"><br></span><span
                    style="color:#1E1E1E;font-size:21px;">ОПТОМ ОТ ПРОИЗВОДИТЕЛЯ В КРАСНОДАРЕ</span>
        </div>
        <div id="wb_Image1" style="position:absolute;left:89px;top:55px;width:143px;height:103px;z-index:1;">
            <img src="images/logo.png" id="Image1" alt=""></div>
        <div id="wb_Shape22" style="position:absolute;left:64px;top:340px;width:192px;height:42px;z-index:2;">
            <a href="#Layer1"><img class="hover" src="images/img0024_hover.png" alt=""
                                   style="border-width:0;width:192px;height:42px;"><span><img src="images/img0024.png"
                                                                                              id="Shape22" alt=""
                                                                                              style="width:192px;height:42px;"></span></a>
        </div>
        <div id="wb_Image41" style="position:absolute;left:65px;top:15px;width:21px;height:21px;z-index:3;">
            <img src="images/i22.png" id="Image41" alt=""></div>
        <div id="wb_Text7"
             style="position:absolute;left:85px;top:15px;width:182px;height:22px;text-align:center;z-index:4;">
            <span style="color:#FC2014;font-size:19px;"><strong><a href="tel:+79385156161"
                                                                                     class="style2">+7 (938) 515-61-61</a></strong></span>
        </div>
    </div>
</div>

<div class="product-grid">
    <div class="product" style="left:10px;top:290px;">
        <img src="images/prod1.jpg" alt="">
        <span class="title">Мука пшеничная хлебопекарная<br>Высший сорт</span>
        <span class="gost">ГОСТ Р 52189-2003</span>
        <p><span>Фасовка:</span>
            - 50 кг (полипропиленовый мешок)
            <br>- 25 кг (полипропиленовый мешок)
            <br>- 10 кг (полипропиленовый мешок)
            <br>- 5 кг (полипропиленовый мешок)
            <br>- 2 кг (бумажный пакет)</p>
        <a href="#Layer1">Узнать цену</a>
    </div>
    <div class="product" style="left:490px;top:290px;">
        <img src="images/prod2.jpg" alt="">
        <span class="title">Мука пшеничная хлебопекарная<br>1 сорт</span>
        <span class="gost">ГОСТ Р 52189-2003</span>
        <p><span>Фасовка:</span>
            - 50 кг (полипропиленовый мешок)
            <br>- 25 кг (полипропиленовый мешок)</p>
        <a href="#Layer1">Узнать цену</a>
    </div>
    <div class="product" style="left:10px;top:840px;">
        <img src="images/prod3.jpg" alt="">
        <span class="title">Мука пшеничная хлебопекарная<br>2 сорт</span>
        <span class="gost">ГОСТ Р 52189-2003</span>
        <p><span>Фасовка:</span>
            - 50 кг (полипропиленовый мешок)</p>
        <a href="#Layer1">Узнать цену</a>
    </div>
  
    <div class="product" style="left:10px;top:1500px;">
        <img src="images/prod5.jpg" alt="">
        <span class="title">Манная крупа</span>
        <span class="gost">Марка М</span>
        <p><span>Фасовка:</span>
            - 50 кг (полипропиленовый мешок)</p>
        <a href="#Layer1">Узнать цену</a>
    </div>
    <div class="product" style="left:490px;top:1500px;">
        <img src="images/prod6.jpg" alt="">
        <span class="title">Отруби пшеничные</span>
        <span class="gost">ГОСТ 7169-66</span>
        <p><span>Фасовка:</span>
            - от 20 до 25 кг (по желанию клиента) в полипропиленовые мешки</p>
        <a href="#Layer1">Узнать цену</a>
    </div>
</div>

<div id="Layer37" style="position:relative;height:530px;">
    <div id="Layer37_Container"
         style="width:320px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Image10" style="position:absolute;left:25px;top:53px;width:41px;height:41px;z-index:5;">
            <img src="images/ic1.png" id="Image10" alt=""></div>
        <div id="wb_Image11" style="position:absolute;left:25px;top:141px;width:41px;height:41px;z-index:6;">
            <img src="images/ic2.png" id="Image11" alt=""></div>
        <div id="wb_Image35" style="position:absolute;left:15px;top:228px;width:58px;height:35px;z-index:7;">
            <img src="images/ic3.png" id="Image35" alt=""></div>
        <div id="wb_Image38" style="position:absolute;left:25px;top:313px;width:41px;height:42px;z-index:8;">
            <img src="images/ic4.png" id="Image38" alt=""></div>
        <div id="wb_Text44"
             style="position:absolute;left:85px;top:53px;width:235px;height:44px;z-index:9;text-align:left;">
            <span style="color:#000000;font-size:19px;">&#1057;&#1086;&#1073;&#1083;&#1102;&#1076;&#1077;&#1085;&#1080;&#1077; &#1089;&#1088;&#1086;&#1082;&#1086;&#1074; &#1080; &#1075;&#1088;&#1072;&#1092;&#1080;&#1082;&#1086;&#1074; &#1087;&#1086;&#1089;&#1090;&#1072;&#1074;&#1086;&#1082;</span>
        </div>
        <div id="wb_Text45"
             style="position:absolute;left:85px;top:148px;width:235px;height:22px;z-index:10;text-align:left;">
            <span style="color:#000000;font-size:19px;">&#1057;&#1082;&#1080;&#1076;&#1082;&#1072; &#1079;&#1072; &#1086;&#1073;&#1098;&#1077;&#1084;</span>
        </div>
        <div id="wb_Text46"
             style="position:absolute;left:85px;top:313px;width:235px;height:44px;z-index:11;text-align:left;">
            <span style="color:#000000;font-size:19px;">&#1062;&#1077;&#1085;&#1099; &#1073;&#1077;&#1079; &#1082;&#1086;&#1084;&#1080;&#1089;&#1089;&#1080;&#1080;<br>&#1086;&#1090; &#1087;&#1088;&#1086;&#1080;&#1079;&#1074;&#1086;&#1076;&#1080;&#1090;&#1077;&#1083;&#1103;</span>
        </div>
        <div id="wb_Text47"
             style="position:absolute;left:85px;top:233px;width:235px;height:22px;z-index:12;text-align:left;">
            <span style="color:#000000;font-size:19px;">&#1056;&#1072;&#1073;&#1086;&#1090;&#1072;&#1077;&#1084; &#1087;&#1086; &#1074;&#1089;&#1077;&#1081; &#1056;&#1086;&#1089;&#1089;&#1080;&#1080;</span>
        </div>
        <div id="wb_Text48"
             style="position:absolute;left:85px;top:413px;width:235px;height:66px;z-index:13;text-align:left;">
            <span style="color:#000000;font-size:19px;">&#1042;&#1089;&#1103; &#1087;&#1088;&#1086;&#1076;&#1091;&#1082;&#1094;&#1080;&#1103; &#1089;&#1086;&#1086;&#1090;&#1074;&#1077;&#1090;&#1089;&#1090;&#1074;&#1091;&#1077;&#1090; &#1074;&#1089;&#1077;&#1084; &#1085;&#1086;&#1088;&#1084;&#1072;&#1084; &#1043;&#1054;&#1057;&#1058;</span>
        </div>
        <div id="wb_Image40" style="position:absolute;left:15px;top:408px;width:56px;height:34px;z-index:14;">
            <img src="images/ic6.png" id="Image40" alt=""></div>
    </div>
</div>
<div id="Layer1" style="position:relative;height:540px;">
    <div id="Layer1_Container"
         style="width:320px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Form1" style="position:absolute;left:0px;top:232px;width:320px;height:308px;z-index:19;">
            <form name="MobileForm" method="post" action="<?php echo basename(__FILE__); ?>"
                  enctype="multipart/form-data" accept-charset="UTF-8" id="Form1">
                <input type="hidden" name="formid" value="form1">
                <input type="text" id="Editbox1"
                       style="position:absolute;left:10px;top:15px;width:283px;height:40px;line-height:40px;z-index:15;"
                       name="Имя" value="" required placeholder="&#1042;&#1072;&#1096;&#1077; &#1080;&#1084;&#1103;*">
                <input type="text" id="Editbox2"
                       style="position:absolute;left:10px;top:80px;width:283px;height:40px;line-height:40px;z-index:16;"
                       name="Телефон" value="" required
                       placeholder="&#1042;&#1072;&#1096; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;*">
                <input type="submit" id="Button1" name="submit" value="Получить прайс-лист"
                       style="position:absolute;left:10px;top:210px;width:300px;height:52px;z-index:17;background-image: linear-gradient(to top, #FC2014, #FF4500) !important; cursor:pointer;">
                <input type="text" id="Editbox3"
                       style="position:absolute;left:10px;top:145px;width:283px;height:40px;line-height:40px;z-index:18;"
                       name="E-mail" value="" required placeholder="&#1042;&#1072;&#1096; e-mail*">
            </form>
        </div>
        <div id="wb_Text27"
             style="position:absolute;left:10px;top:45px;width:310px;height:99px;z-index:20;text-align:left;">
            <span style="color:#1E1E1E;font-weight:bold;font-size:32px;">ПОЛУЧИТЕ<br></span><span
                    style="color:#1E1E1E;font-size:24px;">ПОЛНЫЙ ПРАЙС-ЛИСТ<br>НА ПРОДУКЦИЮ</span>
        </div>
        <div id="wb_Text28"
             style="position:absolute;left:10px;top:166px;width:310px;height:38px;z-index:21;text-align:left;">
            <span style="color:#000000;font-size:17px;">&#1054;&#1089;&#1090;&#1072;&#1074;&#1100;&#1090;&#1077; &#1079;&#1072;&#1103;&#1074;&#1082;&#1091; &#1080; &#1087;&#1086;&#1083;&#1091;&#1095;&#1080;&#1090;&#1077; &#1087;&#1086;&#1083;&#1085;&#1099;&#1081; &#1087;&#1088;&#1072;&#1081;&#1089;-&#1083;&#1080;&#1089;&#1090; &#1085;&#1072; &#1074;&#1089;&#1102; &#1087;&#1088;&#1086;&#1076;&#1091;&#1082;&#1094;&#1080;&#1102;</span>
        </div>
    </div>
</div>
<div id="Layer1" style="position:relative;height:440px;background-color: #fafafa;">
    <div id="Layer1_Container"
         style="width:320px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text27"
             style="position:absolute;left:10px;top:45px;width:310px;z-index:20;text-align:left;">
            <span style="color:#1E1E1E;font-weight:bold;font-size:32px;">КОНТАКТЫ</span>
        </div>
        <div id="wb_Image39" style="position:absolute;left:10px;top:128px;width:18px;height:24px;z-index:109;">
            <img src="images/i11.png" id="Image39" alt=""></div>
        <div id="wb_Image41" style="position:absolute;left:10px;top:203px;width:21px;height:21px;z-index:110;">
            <img src="images/i22.png" id="Image41" alt=""></div>
        <div id="wb_Image42" style="position:absolute;left:8px;top:247px;width:24px;height:25px;z-index:111;">
            <img src="images/i33.png" id="Image42" alt=""></div>
        <div id="wb_Image43" style="position:absolute;left:10px;top:297px;width:20px;height:14px;z-index:112;">
            <img src="images/i44.png" id="Image43" alt=""></div>
        <div id="wb_Text57" style="position:absolute;left:50px;top:130px;width:290px;height:57px;z-index:116;text-align:left;">
            <span style="color:#000000;font-size:17px;"><strong>Адрес:</strong> 353204, Россия, Краснодарский край, ст. Динская, ул. Крайняя, 12А</span>
        </div>
        <div id="wb_Text60" style="position:absolute;left:50px;top:205px;width:250px;height:19px;z-index:115;text-align:left;">
            <span style="color:#000000;font-size:17px;"><strong>Телефон:</strong> +7 (938) 515-61-61</span>
        </div>
        <div id="wb_Text59" style="position:absolute;left:50px;top:249px;width:330px;height:19px;z-index:114;text-align:left;">
            <span style="color:#000000;font-size:17px;"><strong>Офис (бух.):</strong> 8 (86162) 5-16-40</span>
        </div>
        <div id="wb_Text58" style="position:absolute;left:50px;top:294px;width:250px;height:19px;z-index:113;text-align:left;">
            <span style="color:#000000;font-size:17px;"><strong>E-mail:</strong> bsv10k@yandex.ru</span>
        </div>
        <div id="wb_Text61" style="position:absolute;left:0px;top: 370px;width: 320px;height:38px;text-align:center;z-index:117;">
            <span style="color:#000000;font-size:17px;"><strong>"Динская мельница" </strong><br>ИП Брецкий С.В.</span>
        </div>
    </div>
</div>
<div id="Layer8" style="position:relative;height:50px;background-color: #ffffff;">
    <div id="Layer8_Container"
         style="width:320px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text8"
             style="position:absolute;left:0px;top:15px;width:320px;height:16px;text-align:center;z-index:44;">
            <span style="color:#000000;font-size:13px;"><a href="http://din-mel.ru/?m=1" class="style2">Полная версия сайта</a></span>
        </div>
    </div>
</div>
</body>
</html>
