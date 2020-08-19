<?php
function ValidateEmail($email)
{
   $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
   return preg_match($pattern, $email);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['formid'] == 'form1')
{
   $mailto = 'bsv10k@yandex.ru';
   $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
   $mailbcc = 'andrei-presser@yandex.ru';
   $subject = 'Заявка с сайта DIN-MEL.RU - ЗЕРНО - ОБРАТНЫЙ ЗВОНОК';
   $message = 'Посетитель сайта заказал обратный звонок (страница "Покупка зерна")';
   $success_url = './thankyou.html';
   $error_url = '';
   $error = '';
   $eol = "\n";
   $max_filesize = isset($_POST['filesize']) ? $_POST['filesize'] * 1024 : 1024000;
   $boundary = md5(uniqid(time()));

   $header  = 'From: '.$mailfrom.$eol;
   $header .= 'Reply-To: '.$mailfrom.$eol;
   $header .= 'Bcc: '.$mailbcc.$eol;
   $header .= 'MIME-Version: 1.0'.$eol;
   $header .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'.$eol;
   $header .= 'X-Mailer: PHP v'.phpversion().$eol;
   if (!ValidateEmail($mailfrom))
   {
      $error .= "The specified email address is invalid!\n<br>";
   }

   if (!empty($error))
   {
      $errorcode = file_get_contents($error_url);
      $replace = "##error##";
      $errorcode = str_replace($replace, $error, $errorcode);
      echo $errorcode;
      exit;
   }

   $internalfields = array ("submit", "reset", "send", "filesize", "formid", "captcha_code", "recaptcha_challenge_field", "recaptcha_response_field", "g-recaptcha-response");
   $message .= $eol;
   foreach ($_POST as $key => $value)
   {
      if (!in_array(strtolower($key), $internalfields))
      {
         if (!is_array($value))
         {
            $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
         }
         else
         {
            $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
         }
      }
   }
   $body  = 'This is a multi-part message in MIME format.'.$eol.$eol;
   $body .= '--'.$boundary.$eol;
   $body .= 'Content-Type: text/plain; charset=UTF-8'.$eol;
   $body .= 'Content-Transfer-Encoding: 8bit'.$eol;
   $body .= $eol.stripslashes($message).$eol;
   if (!empty($_FILES))
   {
       foreach ($_FILES as $key => $value)
       {
          if ($_FILES[$key]['error'] == 0 && $_FILES[$key]['size'] <= $max_filesize)
          {
             $body .= '--'.$boundary.$eol;
             $body .= 'Content-Type: '.$_FILES[$key]['type'].'; name='.$_FILES[$key]['name'].$eol;
             $body .= 'Content-Transfer-Encoding: base64'.$eol;
             $body .= 'Content-Disposition: attachment; filename='.$_FILES[$key]['name'].$eol;
             $body .= $eol.chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))).$eol;
          }
      }
   }
   $body .= '--'.$boundary.'--'.$eol;
   if ($mailto != '')
   {
      mail($mailto, $subject, $body, $header);
   }
   header('Location: '.$success_url);
   exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Безымянная страница</title>
<link href="favicon.png" rel="shortcut icon" type="image/x-icon">
<link href="lp.css" rel="stylesheet">
<link href="callbackbuy.css" rel="stylesheet">
  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-129269798-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-129269798-1');
</script>
</head>
<body>
<div id="container">
<div id="wb_Form1" style="position:absolute;left:10px;top:15px;width:460px;height:330px;z-index:4;">
<form name="Form1" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" accept-charset="UTF-8" target="_top" id="Form1">
<input type="hidden" name="formid" value="form1">
<div id="wb_Text6" style="position:absolute;left:0px;top:47px;width:460px;height:45px;text-align:center;z-index:0;">
<span style="color:#4A3D3B;font-weidht:bold;font-size:32px;">Заказать звонок</span></div>
<input type="text" id="Editbox1" style="position:absolute;left:65px;top:118px;width:308px;height:38px;line-height:38px;z-index:1;" name="Имя" value="" required placeholder="&#1042;&#1072;&#1096;&#1077; &#1080;&#1084;&#1103;*">
<input type="text" id="Editbox2" style="position:absolute;left:65px;top:183px;width:308px;height:38px;line-height:38px;z-index:2;" name="Телефон" value="" required placeholder="&#1042;&#1072;&#1096; &#1090;&#1077;&#1083;&#1077;&#1092;&#1086;&#1085;*">
<input type="submit" id="Button3" name="" value="Перезвоните мне!" style="position:absolute;left:65px;top:249px;width:330px;height:67px;z-index:3;cursor:pointer;">
</form>
</div>
</div>
  <!-- Yandex.Metrika counter --> <script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter41390209 = new Ya.Metrika({ id:41390209, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/41390209" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
</body>
</html>