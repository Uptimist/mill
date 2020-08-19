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
    } elseif (!$_GET['m'] == '1') {
        echo "<script>
if (screen.width <= 420)
{window.location = 'mobile.php';}
</script>";
    } ?>
    <link href="favicon.png" rel="shortcut icon" type="image/x-icon">
    <link href="cupertino/jquery.ui.all.css" rel="stylesheet">
    <link href="lp.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
    <link rel="stylesheet" href="fancybox/jquery.fancybox-1.3.0.css">
    <link href="/fonts/fregat.css" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
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
<div id="Layer2"
     style="text-align:center;width:100%;height:720px;z-index:261;background-attachment:fixed;">
    <div id="Layer2_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div style="position:absolute;left:0px;top:173px;width:960px;height:116px;text-align:center;z-index:56;text-shadow: 0px 1px 0px rgba(255,255,255,0.8);">
            <img src="images/top-text.png?gray-shadow" alt="top_text" style="width: 860px;">
        </div>
        <div id="Layer29"
             style="position:absolute;text-align:left;left:50px;top:424px;width:860px;height:185px;z-index:58;border-radius:5px;">
        </div>
        <div id="wb_Form3" style="position:absolute;left:50px;top:424px;width:860px;height:175px;z-index:59;text-shadow: rgba(150,150,150,.8) 0 1px;">
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
<div id="Layer8" style="margin-top: 220px;">
    <div id="Layer8_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text15"
             style="margin-bottom: 50px;">
            <span style="color:#1E1E1E;font-weight:bold;font-size:43px;">АССОРТИМЕНТ</span><span
                    style="color:#1E1E1E;font-weight:bold;font-size:32px;"> </span><span
                    style="color:#1E1E1E;font-size:13px;"><br></span><span
                    style="color:#1E1E1E;font-size:32px;">нашей продукции</span></div>
        <div class="product-grid">
            <div class="product" style="left:10px;top:290px;">
                <img src="images/prod1.jpg" alt="">
                <span class="title">Мука пшеничная хлебопекарная<br>Высший сорт</span>
                <span class="gost">ГОСТ Р 52189-2003</span>
                <div>
                <p><span>Фасовка:</span>
                    - 50 кг (полипропиленовый мешок)
                    <br>- 25 кг (полипропиленовый мешок)
                    <br>- 10 кг (полипропиленовый мешок)
                    <br>- 5 кг (полипропиленовый мешок)
                    <br>- 2 кг (бумажный пакет)</p>
                <p class="desc">Мука высшего сорта обладает высокими хлебопекарными свойствами,изделия из такой муки
                    хорошо поднимаются.
                    <br>Подходит для выпечки сдобы,для приготовления дрожжевого,слоеного и песочного теста.</p>
                </div>
                <a href="/#Layer27">Узнать цену</a>
            </div>
            <div class="product" style="left:490px;top:290px;">
                <img src="images/prod2.jpg" alt="">
                <span class="title">Мука пшеничная хлебопекарная<br>1 сорт</span>
                <span class="gost">ГОСТ Р 52189-2003</span>
                <p><span>Фасовка:</span>
                    - 50 кг (полипропиленовый мешок)
                    <br>- 25 кг (полипропиленовый мешок)</p>
                <p class="desc">Мука первого сорта - это пшеничная мука более грубого помола, чем мука высшего сорта.
                    <br>Рекомендуется для несдобной выпечки(пирогов,булок,оладий,блинов и т.д.) и для выпечки
                    разнообразных хлебных изделий.</p>
                <a href="/#Layer27">Узнать цену</a>
            </div>
            <div class="product" style="left:10px;top:840px;">
                <img src="images/prod3.jpg" alt="">
                <span class="title">Мука пшеничная хлебопекарная<br>2 сорт</span>
                <span class="gost">ГОСТ Р 52189-2003</span>
                <p><span>Фасовка:</span>
                    - 50 кг (полипропиленовый мешок)</p>
                <p class="desc">Мука второго сорта - это пшеничная мука, имеющая в составе измельченные оболочки зерна в
                    количестве от 8% до 12%. Частички этой муки крупнее, поэтому она имеет более темный цвет с сероватым
                    оттенком.
                    <br>Рекомендуется для приготовления не сдобной выпечки, столового хлеба, печенья, пряников, а так же
                    для выпечки бородинского хлеба.
                    <br>Хлеб из такой муки медленнее черствеет и обладает более полезными свойствами.</p>
                <a href="/#Layer27">Узнать цену</a>
            </div>

            <div class="product" style="left:10px;top:1500px;">
                <img src="images/prod5.jpg" alt="">
                <span class="title">Манная крупа</span>
                <span class="gost">Марка М</span>
                <p><span>Фасовка:</span>
                    - 50 кг (полипропиленовый мешок)</p>
                <p class="desc">Манная крупа (в просторечии манка) - пшеничная крупа грубого помола со средним
                    диаметром частиц от 0,25 до 0,75 мм. Манная крупа изготавливается из пшеницы.
                    Она быстро разваривается, хорошо усваивается, содержит минимальное количество клетчатки (0,2%).
                    Из манной крупы готовят первые блюда, каши, оладьи, запеканки, биточки, пудинги, суфле.
                    <br><br><i>«Марка М» - обозначает,что крупа изготовлена из мягких сортов пшеницы.</i>
                </p>
                <a href="/#Layer27">Узнать цену</a>
            </div>
            <div class="product" style="left:490px;top:1500px;">
                <img src="images/prod6.jpg" alt="">
                <span class="title">Отруби пшеничные</span>
                <span class="gost">ГОСТ 7169-66</span>
                <p><span>Фасовка:</span>
                    - от 20 до 25 кг (по желанию клиента) в полипропиленовые мешки</p>
                <p class="desc">Пшеничные отруби, это продукт,который получается,в процессе переработки пшеницы.
                    Основной компонент отрубей - клетчатка. Именно ее наличие в составе пшеничных отрубей оказывет
                    благоприятное действие на пищеварение животного.
                    <br>Пшеничные отруби - наиболее востребованный вид отрубей в животноводстве, потому что является
                    универсальным. Подходит для кормления большинства видов сельскохозяйственных животных.
                    <br>Отруби применяются в целях формирования здорового, питательного и сбалансированного рациона
                    с/х животных.
                </p>
                <a href="/#Layer27">Узнать цену</a>
            </div>
        </div>
    </div>
</div>
<div id="Layer27" style="position:relative; height: 1000px; margin-top: 50px;">
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
                <span style="color:#1E1E1E;font-weight:bold;font-size:43px;">ПОЛУЧИТЕ </span><span
                        style="color:#1E1E1E;font-size:27px;">ПОЛНЫЙ ПРАЙС-ЛИСТ<br>НА ПРОДУКЦИЮ</span>
            </div>
            <div id="wb_Text28"
                 style="position:absolute;left:71px;top:180px;width:338px;height:38px;z-index:166;text-align:left;">
                <span style="color:#000000;font-size:17px;">&#1054;&#1089;&#1090;&#1072;&#1074;&#1100;&#1090;&#1077; &#1079;&#1072;&#1103;&#1074;&#1082;&#1091; &#1080; &#1087;&#1086;&#1083;&#1091;&#1095;&#1080;&#1090;&#1077; &#1087;&#1086;&#1083;&#1085;&#1099;&#1081; &#1087;&#1088;&#1072;&#1081;&#1089;-&#1083;&#1080;&#1089;&#1090; &#1085;&#1072; &#1074;&#1089;&#1102; &#1087;&#1088;&#1086;&#1076;&#1091;&#1082;&#1094;&#1080;&#1102;</span>
            </div>
            <div id="wb_Text42"
                 style="position:absolute;left:30px;top:605px;width:435px;height:156px;z-index:167;text-align:left;">
                <span style="color:#FFFFFF;font-weight:bold;font-size:37px;">ПРЕИМУЩЕСТВА <br>СОТРУДНИЧЕСТВА С НАМИ</span>
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
<div id="Layer26" style="position:relative;margin: 180px 0 90px;">
    <div id="Layer26_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text40">
            <span style="color:#1E1E1E;font-weight:bold;font-size:43px;">СОБСТВЕННОЕ ПРОИЗВОДСТВО</span></div>
        <div id="wb_Text24"
             style="position:relative;left:13px;width:934px;margin-top: 30px">
            <span style="color:#000000;font-size:17px;">
                <div style="text-align: center;">
                    <h5>Хотите купить первоклассную муку оптом, за умеренную цену? Обращайтесь к нам!</h5>
                </div>
                <p>Чтобы испечь вкусный хлеб, нужна хорошая мука. Она же требуется для пышных пирогов – предмета
                    законной гордости любой хозяйки. Без муки не сделать ни макаронных изделий, ни оладий, ни блинов на
                    Масленицу… Словом, по-настоящему качественная мука – товар первой необходимости, и уж кому, как не
                    жителям Краснодарского края, житницы России, это знать! Но где лучше купить муку оптом, чтобы она
                    была отменного качества, и при этом не переплатить лишних денег?</p>
                <p>Компания «Динская мельница» готова поставить практически любое количество пшеничной хлебопекарной
                    муки высшего, первого и второго сорта, пшеничных отрубей, манной крупы. Мы дорожим
                    своей репутацией и гарантируем, что вся продукция строго соответствует ГОСТу. Неудивительно, ведь
                    наши специалисты закупают пшеницу только у надежных и проверенных кубанских производителей! А затем
                    все стадии – очистка, размол, просеивание, сортировка, упаковка – осуществляются под постоянным и
                    строгим контролем. Каждая готовая партия проходит контроль качества в лаборатории. И в результате,
                    наши заказчики получают отличную муку!<br></p>
            </span>
        </div>
        <div class="swiper-container gallery-top">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="/images/slide1.jpg">
                </div>
                <div class="swiper-slide">
                    <img src="/images/slide2.jpg">
                </div>
                <div class="swiper-slide">
                    <img src="/images/slide3.jpg">
                </div>
                <div class="swiper-slide">
                    <img src="/images/slide4.jpg">
                </div>
                <div class="swiper-slide">
                    <img src="/images/slide5.jpg">
                </div>
                <div class="swiper-slide">
                    <img src="/images/slide6.jpg">
                </div>
                <div class="swiper-slide">
                    <img src="/images/slide7.jpg">
                </div>
                <div class="swiper-slide">
                    <img src="/images/slide8.jpg">
                </div>
                <div class="swiper-slide">
                    <img src="/images/slide9.jpg">
                </div>
                <div class="swiper-slide">
                    <img src="/images/slide10.jpg">
                </div>
                <div class="swiper-slide">
                    <img src="/images/slide11.jpg">
                </div>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-button-white"></div>
            <div class="swiper-button-prev swiper-button-white"></div>
        </div>
        <div class="swiper-container gallery-thumbs">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="background-image:url('/images/slide1_mini.jpg')"></div>
                <div class="swiper-slide" style="background-image:url('/images/slide2_mini.jpg')"></div>
                <div class="swiper-slide" style="background-image:url('/images/slide3_mini.jpg')"></div>
                <div class="swiper-slide" style="background-image:url('/images/slide4_mini.jpg')"></div>
                <div class="swiper-slide" style="background-image:url('/images/slide5_mini.jpg')"></div>
                <div class="swiper-slide" style="background-image:url('/images/slide6_mini.jpg')"></div>
                <div class="swiper-slide" style="background-image:url('/images/slide7_mini.jpg')"></div>
                <div class="swiper-slide" style="background-image:url('/images/slide8_mini.jpg')"></div>
                <div class="swiper-slide" style="background-image:url('/images/slide9_mini.jpg')"></div>
                <div class="swiper-slide" style="background-image:url('/images/slide10_mini.jpg')"></div>
                <div class="swiper-slide" style="background-image:url('/images/slide11_mini.jpg')"></div>
            </div>
        </div>
</div>
</div>
<div id="Layer19" style="position:relative;text-align:center;height:465px;">
    <div id="Layer19_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text39"
             style="position:absolute;left:16px;top:158px;width:915px;height:96px;z-index:3;text-align:left;">
            <span style="color:#1E1E1E;font-weight:bold;font-size:43px;">СЕРТИФИКАТЫ</span><span
                    style="color:#1E1E1E;font-weight:bold;font-size:32px;"> </span><span
                    style="color:#1E1E1E;font-size:13px;"><br></span><span
                    style="color:#1E1E1E;font-size:32px;">на продукцию</span></div>
        <div id="wb_Text25"
             style="position:absolute;left:16px;top:288px;width:250px;height:57px;z-index:4;text-align:left;">
            <span style="color:#000000;font-size:17px;">Производимая &#1085;&#1072;&#1084;&#1080; &#1087;&#1088;&#1086;&#1076;&#1091;&#1082;&#1094;&#1080;&#1103; &#1080;&#1084;&#1077;&#1077;&#1090; &#1074;&#1089;&#1077; &#1085;&#1077;&#1086;&#1073;&#1093;&#1086;&#1076;&#1080;&#1084;&#1099;&#1077; &#1089;&#1077;&#1088;&#1090;&#1080;&#1092;&#1080;&#1082;&#1072;&#1090;&#1099; &#1082;&#1072;&#1095;&#1077;&#1089;&#1090;&#1074;&#1072;</span>
        </div>
        <div id="wb_Image27" style="position:absolute;left:435px;top:158px;width:163px;height:213px;z-index:5;">
            <img src="images/sert_small.png" id="Image27" alt=""></div>
        <div id="wb_Image26" style="position:absolute;left:610px;top:158px;width:163px;height:213px;z-index:6;">
            <img src="images/sert_manka_small.jpg" id="Image26" alt=""></div>
        <div id="wb_Image28" style="position:absolute;left:785px;top:158px;width:163px;height:213px;z-index:7;">
            <img src="images/sert_small.png" id="Image28" alt=""></div>
        <div id="Layer36"
             style="position:absolute;text-align:left;left:435px;top:158px;width:163px;height:213px;z-index:8;">
            <div id="wb_Shape8" style="position:absolute;left:0px;top:0px;width:162px;height:213px;z-index:0;">
                <a href="javascript:displaylightbox('./sertificates_1.html',{width:525,height:700,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                   target="_self"><img src="images/img0015.png" id="Shape8" alt=""
                                       style="width:162px;height:213px;"></a></div>
        </div>
        <div id="Layer38"
             style="position:absolute;text-align:left;left:610px;top:158px;width:163px;height:213px;z-index:9;">
            <div id="wb_Shape14" style="position:absolute;left:0px;top:0px;width:162px;height:213px;z-index:1;">
                <a href="javascript:displaylightbox('./sertificates_2.html',{width:525,height:700,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                   target="_self"><img src="images/img0017.png" id="Shape14" alt=""
                                       style="width:162px;height:213px;"></a></div>
        </div>
        <div id="Layer39"
             style="position:absolute;text-align:left;left:785px;top:158px;width:163px;height:213px;z-index:10;">
            <div id="wb_Shape15" style="position:absolute;left:0px;top:0px;width:162px;height:213px;z-index:2;">
                <a href="javascript:displaylightbox('./sertificates_3.html',{width:525,height:700,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                   target="_self"><img src="images/img0016.png" id="Shape15" alt=""
                                       style="width:162px;height:213px;"></a></div>
        </div>
    </div>
</div>
<div id="Layer191" style="position:relative;text-align:center;height:465px;">
    <div id="Layer19_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
        <div id="wb_Text39"
             style="position:absolute;left:630px;top:158px;width:330px;height:96px;z-index:3;text-align:left;">
            <span style="color:#1E1E1E;font-weight:bold;font-size:43px;">Отзывы</span><span
                    style="color:#1E1E1E;font-weight:bold;font-size:32px;"> </span><span
                    style="color:#1E1E1E;font-size:13px;"><br></span><span
                    style="color:#1E1E1E;font-size:32px;">наших партнёров</span></div>
        <div id="wb_Text25"
             style="position:absolute;left:630px;top:288px;width:330px;height:57px;z-index:4;text-align:left;">

        </div>
        <div id="wb_Image27" style="position:absolute;left:15px;top:158px;width:163px;height:213px;z-index:5;">
            <img src="images/blagodar1.png" id="Image27" alt=""></div>
        <div id="wb_Image26" style="position:absolute;left:190px;top:158px;width:163px;height:213px;z-index:6;">
            <img src="images/blagodar2.png" id="Image26" alt=""></div>
        <div id="wb_Image28" style="position:absolute;left:365px;top:158px;width:163px;height:213px;z-index:7;">
            <img src="images/blagodar3.png" id="Image28" alt=""></div>
        <div id="Layer36"
             style="position:absolute;text-align:left;left:15px;top:158px;width:163px;height:213px;z-index:8;">
            <div id="wb_Shape8" style="position:absolute;left:0px;top:0px;width:162px;height:213px;z-index:0;">
                <a href="javascript:displaylightbox('./blagodarnost_1.html',{width:525,height:700,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                   target="_self"><img src="images/img0015.png" id="Shape8" alt=""
                                       style="width:162px;height:213px;"></a></div>
        </div>
        <div id="Layer38"
             style="position:absolute;text-align:left;left:190px;top:158px;width:163px;height:213px;z-index:9;">
            <div id="wb_Shape14" style="position:absolute;left:0px;top:0px;width:162px;height:213px;z-index:1;">
                <a href="javascript:displaylightbox('./blagodarnost_2.html',{width:525,height:700,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                   target="_self"><img src="images/img0017.png" id="Shape14" alt=""
                                       style="width:162px;height:213px;"></a></div>
        </div>
        <div id="Layer39"
             style="position:absolute;text-align:left;left:365px;top:158px;width:163px;height:213px;z-index:10;">
            <div id="wb_Shape15" style="position:absolute;left:0px;top:0px;width:162px;height:213px;z-index:2;">
                <a href="javascript:displaylightbox('./blagodarnost_3.html',{width:525,height:700,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                   target="_self"><img src="images/img0016.png" id="Shape15" alt=""
                                       style="width:162px;height:213px;"></a></div>
        </div>
    </div>
</div>
<div id="Layer15" style="position:relative;height:640px;">
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
            <span style="color:#1E1E1E;font-weight:bold;font-size:43px;">КАК МЫ РАБОТАЕМ</span></div>
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
            <span style="color:#1E1E1E;font-size:17px;"><em>Вы подтверждаете заказ и мы договариваемся об удобных для вас времени и условиях поставки продукции</em></span>
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
            <a href="/#Layer27"><img class="hover" src="images/img0001_hover.png" alt=""
                                    style="border-width:0;width:140px;height:29px;"><span><img src="images/img0001.png"
                                                                                               id="Shape2" alt=""
                                                                                               style="width:140px;height:29px;"></span></a>
        </div>
    </div>
</div>
<div id="Layer28" style="position:relative;height:582px;">
    <div id="Layer40"
         style="position:absolute;text-align:left;right: calc(50% - 480px);x;top:0;width:480px;height:582px;">
        <div id="wb_Text55"
             style="position:absolute;left:85px;top:47px;width:338px;height:124px;z-index:227;text-align:left;">
            <span style="color:#1E1E1E;font-weight:bold;font-size:43px;">ПОЛУЧИТЕ </span><span
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
<div id="Layer20" style="position:relative;height:496px;">
    <script type="text/javascript" charset="utf-8" async
            src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=m5P1GQQBzURVmc5BjLUnGVIEb9T2mqBO&amp;width=100%25&amp;height=100%&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=false"></script>
    <div id="Layer17"
         style="position:absolute;left: calc(50% - 480px);top:0;width:480px;height:100%;">
        <div id="wb_Text41"
             style="position:absolute;left:75px;top:75px;width:338px;height:60px;z-index:108;text-align:left;">
            <span style="color:#1E1E1E;font-weight:bold;font-size:43px;">КОНТАКТЫ</span></div>
        <div id="wb_Image39" style="position:absolute;left:79px;top:168px;width:18px;height:24px;z-index:109;">
            <img src="images/i11.png" id="Image39" alt=""></div>
        <div id="wb_Image41" style="position:absolute;left:79px;top:243px;width:21px;height:21px;z-index:110;">
            <img src="images/i22.png" id="Image41" alt=""></div>
        <div id="wb_Image42" style="position:absolute;left:77px;top:287px;width:24px;height:25px;z-index:111;">
            <img src="images/i33.png" id="Image42" alt=""></div>
        <div id="wb_Image43" style="position:absolute;left:79px;top:337px;width:20px;height:14px;z-index:112;">
            <img src="images/i44.png" id="Image43" alt=""></div>
        <div id="wb_Text58"
             style="position:absolute;left:113px;top:334px;width:250px;height:19px;z-index:113;text-align:left;">
            <span style="color:#000000;font-size:17px;"><strong>E-mail:</strong> bsv10k@yandex.ru</span>
        </div>
        <div id="wb_Text59"
             style="position:absolute;left:113px;top:289px;width:330px;height:19px;z-index:114;text-align:left;">
            <span style="color:#000000;font-size:17px;"><strong>Офис (бухгалтерия):</strong> 8 (86162) 5-16-40</span>
        </div>
        <div id="wb_Text60"
             style="position:absolute;left:113px;top:245px;width:250px;height:19px;z-index:115;text-align:left;">
            <span style="color:#000000;font-size:17px;"><strong>Телефон:</strong> +7 (938) 515-61-61</span>
        </div>
        <div id="wb_Text57"
             style="position:absolute;left:113px;top:170px;width:290px;height:57px;z-index:116;text-align:left;">
            <span style="color:#000000;font-size:17px;"><strong>Адрес:</strong> 353204, Россия, Краснодарский край, ст. Динская, ул. Крайняя, 12А</span>
        </div>
        <div id="wb_Text61"
             style="position:absolute;left:0px;top:410px;width:480px;height:38px;text-align:center;z-index:117;">
            <span style="color:#000000;font-size:17px;"><strong>&quot;Динская мельница&quot; </strong><br>&#1048;&#1055; &#1041;&#1088;&#1077;&#1094;&#1082;&#1080;&#1081; &#1057;.&#1042;.</span>
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
    <div id="Layer3" style="position:absolute;text-align:center;left:0px;top:5px;width:100%;height:115px;z-index:72;font-size: 14px;">
        <div id="Layer3_Container"
             style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">
            <div id="wb_Text3"
                 style="position:absolute;left:10px;top:20px;height:16px;z-index:61;text-align:left;">
                <span><a href="/#Layer8" class="style1">Продукция</a></span>
            </div>
            <div id="wb_Image1" style="position:absolute;left:409px;top:0px;width:143px;height:103px;z-index:62;">
                <a href="/#Layer2"><img src="images/logo.png" id="Image1" alt=""></a></div>
            <div id="wb_Text2"
                 style="position: absolute; left: 655px; top: 10px; border-radius: 5px; z-index: 63; text-align: center; background-color: #fd2d0e; padding: 5px 15px; color: white;">
                <span style="font-size: 13px;"><a href="https://yadi.sk/i/oCnY7zQRzQQb5" class="style1 price-list"
                                                target="_blank"><b>Скачать<br>прайс лист</b></a></span>
            </div>
            <div id="wb_Text7"
                 style="position:absolute;left:100px;top:20px;height:16px;z-index:64;text-align:left;">
                <span><a href="/#Layer26" class="style1">Производство</a></span>
            </div>
            <div id="wb_Text6"
                 style="position:absolute;left:775px;top:17px;height:22px;text-align:center;z-index:65;">
                <span style="color:#000000;font-size:21px;"><strong>+7 (938) 515-61-61</strong></span>
            </div>
            <!--
                        <div id="wb_Shape3" style="position:absolute;left:770px;top:30px;width:184px;height:29px;z-index:66;">
                            <a href="javascript:displaylightbox('./callback.php',{width:480,height:400,centerOnScroll:true,overlayOpacity:0.5,overlayColor:'#000'})"
                               target="_self"><img class="hover" src="images/img0079_hover.png" alt=""
                                                   style="border-width:0;width:184px;height:29px;"><span><img
                                            src="images/img0079.png" id="Shape3" alt="" style="width:184px;height:29px;"></span></a>
                        </div>
            -->
            <div id="wb_Text9"
                 style="position:absolute;left:310px;top:20px;height:16px;z-index:67;text-align:left;">
                <span><a href="buy.php" class="style1" target="_blank">Мы закупаем</a></span>
            </div>
            <div id="wb_Text1"
                 style="position:absolute;left:205px;top:20px;height:16px;z-index:68;text-align:left;">
                <span><a href="/#Layer19" class="style1">Сертификаты</a></span>
            </div>
            <div id="wb_Text26"
                 style="position:absolute;left:575px;top:20px;height:16px;z-index:69;text-align:left;">
                <span><a href="/#Layer20" class="style1">Контакты</a></span>
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


<div id="Layer24" style="position:relative;height:203px;">
    <div id="Layer24_Container"
         style="width:960px;position:relative;margin-left:auto;margin-right:auto;text-align:left;">

        <div id="wb_Text30"
             style="position:absolute;left:400px;top:179px;width:245px;height:16px;z-index:47;text-align:left;">
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

<script src="jquery-1.11.1.min.js"></script>
<script src="jquery.ui.core.min.js" async></script>
<script src="jquery.ui.widget.min.js" async></script>
<script src="jquery.ui.mouse.min.js" async></script>
<script src="jquery.ui.sortable.min.js" async></script>
<script src="fancybox/jquery.easing-1.3.pack.js" async></script>
<script src="fancybox/jquery.fancybox-1.3.0.pack.js" async></script>
<script src="fancybox/jquery.mousewheel-3.0.2.pack.js" async></script>
<script src="wwb10.min.js" async></script>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/js/swiper.min.js"></script>
<script>
    var galleryThumbs = new Swiper('.gallery-thumbs', {
        spaceBetween: 5,
        slidesPerView: 6,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var galleryTop = new Swiper('.gallery-top', {
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        effect: 'fade',
        spaceBetween: 5,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: galleryThumbs,
        },
    });
</script>

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
<!--
<link rel="stylesheet" href="https://cdn.callbackkiller.com/widget/cbk.css">
<script type="text/javascript" src="https://cdn.callbackkiller.com/widget/cbk.js?cbk_code=ba5241ac3b4c373718ec82bef53b6ba6" charset="UTF-8" async></script>
-->
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
