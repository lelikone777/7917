<?php
require_once __DIR__ . '/../../_helpers/vendor/autoload.php';
require_once __DIR__ . '/app.php';

use Service_landing\Helpers\Http;
use Service_landing\Helpers\Url;
use Service_landing\Helpers\SMS;
use Service_landing\Helpers\Log;

const SHORT = 81181;
const LOG_FOLDER = __DIR__ . '/logs';

$error = $script = $sms_body = '';

$wb_id = $_GET['ext_id'] ?? '';
$text = $_GET['text'] ?? '';


/**
 * @return string
 * @throws Exception
 */
function pumaInit(): string
{
    $data = Http::pumaInit('host=frsms.easy-fitness.online&country=fr&operator=sms_wifi&custom=8', LOG_FOLDER);
    $url = $data['url'] ?? '';

    if (!$url) {
        throw new Exception($data['reason'] ?? 'Init error occurred');
    }

    return $url;
}

try {
    if (!$wb_id) {
        $url = pumaInit();
        Http::redirect($url);
    }

    if (!$text) {
        throw new Exception("SMS text has not been received");
    }

    $app = new App();
    $app->wb_id = $wb_id;

    if (isset($_POST['agree'])) {

        if ($app->antifraudCheck()) {
            $sms_body = Sms::createSMSLink(SHORT, $text);
            Http::redirect($sms_body);

        } else {
            Http::redirect('http://inspigate.com/echovox/france/fail_url', [
                'ext_id' => $app->wb_id,
                'status' => 'fraud',
            ], LOG_FOLDER);
        }

    } else {
        $script = $app->antifraudGet();
    }

} catch (Exception $e) {
    $error = $e->getMessage();
}


if ($error) {
    Log::errorLog(LOG_FOLDER, "wb_id=$wb_id, text=$text, error_message=$error");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>2877</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <style type="text/css">
        html {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 100%
        }

        *,
        :before,
        :after {
            -webkit-box-sizing: inherit;
            box-sizing: inherit;
            -moz-box-sizing: inherit
        }

        * {
            max-height: 1000000px;
            outline: none
        }

        input {
            border: none;
            outline: none;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p {
            font-size: inherit;
            font-weight: 400;
            margin: 0
        }

        img {
            vertical-align: top;
            max-width: 100%;
            height: auto;
            border-style: none
        }

        a {
            display: inline-block;
            text-decoration: none;
            outline: none;
            color: inherit
        }

        body {
            -ms-text-size-adjust: none;
            -moz-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 400;
            background: #fff;
            height: 97%;
            direction: ltr;
            text-align: center;
            background: linear-gradient(180deg, #37BEDC 0%, #FFFFFF 28.76%);
        }

        .wrapper {
            max-width: 1080px;
            margin: auto;
            height: 100%;
        }


        .logo {
            max-width: 160px;
            width: 100%;
            margin: 0 auto;
        }

        .container {
            height: 100%;
        }

        .content {
            padding: 0 4.5em;
        }

        /*.input {*/
        /*    text-align: center;*/
        /*    font-weight: 600;*/
        /*    color: #686868;*/
        /*    font-size: 30px;*/
        /*    border-bottom: 1px solid #adadad;*/
        /*    margin: 2vh auto;*/
        /*    padding: 12px;*/
        /*    width: 60%;*/
        /*    max-width: 590px;*/
        /*    background: url(../img/flag.png) no-repeat 8% center;*/
        /*    background-size: auto 65%;*/
        /*    padding-left: 7vh !important;*/
        /*}*/

        .agree-btn {
            background-color: #ff5300;
            color: #fff;
            border-radius: 16px;
            font-size: 24px;
            padding: 16px;
            cursor: pointer;
            width: 60%;
            border: none;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .orange {
            color: #ff5300 !important;
            font-size: 2.2em;
            text-align: center;
            margin: 1em 0;
            /*color: #747474;*/
            line-height: 1.4em;
        }

        /*.green {*/
        /*    color: #00b58a !important;*/
        /*    font-size: 2.2em;*/
        /*    text-align: center;*/
        /*    margin: 1em 0;*/
        /*    color: #747474;*/
        /*    line-height: 1.4em;*/
        /*    margin-bottom: 0;*/
        /*}*/

        /*.bottom {*/
        /*    position: absolute;*/
        /*    bottom: 10px;*/
        /*    left: 0;*/
        /*    width: 100%;*/
        /*}*/

        /*.hide {*/
        /*    display: none;*/
        /*}*/

        .footer {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 3px;
            /*color: #a2a2a2;*/
            /*font-size: 12px;*/

            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 16px;
            text-align: center;
            padding: 0 10px;
            color: #4F4F4F;
        }

        .m {
            margin: 3px 0;
        }

        .b-img {
            margin-bottom: 6px;
        }

        .list {
            max-width: 340px;
            margin: 5px auto 16px;
        }


        .footer a {
            text-decoration: underline;
        }

        /*.terms {*/
        /*    display: block;*/
        /*    font-weight: bold;*/
        /*}*/

        /*.loader_box {*/
        /*    display: block;*/
        /*    position: absolute;*/
        /*    top: 0;*/
        /*    left: 0;*/
        /*    right: 0;*/
        /*    bottom: 0;*/
        /*    background: rgba(0, 0, 0, 0.65);*/
        /*    z-index: 50;*/
        /*}*/

        /*.loader {*/
        /*    position: absolute;*/
        /*    top: 50%;*/
        /*    left: 50%;*/
        /*    -webkit-transform: translate(-50%, -50%);*/
        /*    -ms-transform: translate(-50%, -50%);*/
        /*    transform: translate(-50%, -50%);*/
        /*    width: 75px;*/
        /*    height: 75px;*/
        /*    z-index: 51;*/
        /*}*/

        @media screen and (max-width: 500px) and (max-height: 900px) {
            .header {
                padding: 4vh 0;
            }

            .logo {
                max-width: 120px;
            }

            /*.input {*/
            /*    width: 90%;*/
            /*    font-size: 18px;*/
            /*    background-size: auto 65%;*/
            /*}*/

            .agree-btn {
                font-size: 20px;
                padding: 25px;
                width: 90%;
                border: none;
            }

            .orange,
            .green {
                font-size: 16px;
            }
        }

        /*iPhone 5S - Chrome - portrait*/
        @media screen and (max-width: 321px)and (max-height:493px) {
            .header {
                padding: 2vh 0;
            }

            .logo {
                max-width: 90px;
            }

            .orange,
            .green {
                font-size: 16px;
            }
        }

        @media (orientation: landscape) and (max-width: 900px) and (max-height: 500px) {
            .header {
                padding: 6px 0;
            }

            .logo {
                max-width: 11%;
            }

            .orange {
                font-size: 18px;
                margin: 5px 0;
            }

            /*.bottom {*/
            /*    position: relative;*/
            /*}*/

            /*.input {*/
            /*    font-size: 15px;*/
            /*}*/

            .agree-btn {
                font-size: 18px;
                padding: 10px;
            }

            /*.green {*/
            /*    font-size: 17px;*/
            /*    margin-top: 3px;*/
            /*}*/
        }

        @media screen and (max-width: 778px) and (max-height: 311px) {
            .logo {
                max-width: 8%;
            }

            .input,
            .agree-btn {
                font-size: 14px;
                padding: 8px;
            }

            .orange,
            .green {
                font-size: 15px;
            }
        }

        @media screen and (max-width: 725px)and (max-height:315px) {
            .logo {
                max-width: 10%;
            }

            .orange,
            .green {
                font-size: 15px;
            }
        }

        @media screen and (max-width: 460px) {
            .content {
                padding: 0 1em;
            }
        }

        /*iPhone SE, 5S - Safary - album*/
        @media screen and (max-width: 569px)and (max-height:321px) {
            .logo {
                max-width: 10%;
            }

            .orange,
            .green {
                font-size: 15px;
            }

            .input,
            .agree-btn {
                padding: 6px;
            }
        }

        /*iPhone SE - Safary - portrait*/
        @media screen and (max-width: 321px)and (max-height:569px) {
            /*.input {*/
            /*    background: url(../img/flag.png) no-repeat 3% center;*/
            /*    background-size: auto 65%;*/
            /*}*/
        }

        @media (max-width: 389px),
        (max-height: 700px) {
            .footer {
                font-size: 12px;
                line-height: 12px;
            }

            .list {
                margin: 5px auto 6px;
                max-width: 290px;
            }
        }

        @media (max-width: 340px),
        (max-height: 487px) {

            .b-img {
                margin: 0;
            }

            .list {
                margin: 0 auto;
                max-width: 245px;
            }

            .footer {
                font-size: 10px;
                line-height: 10px;
            }

            .agree-btn {
                height: 60px;
                font-size: 28px;
                padding: 16px;
            }


        }

        @media (orientation: landscape) and (max-height: 420px) {
            .logo img {
                display: none;
            }
        }

        @media (orientation: landscape) and (max-height: 420px) {
            .content {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -75%);
                padding: 0;
                width: 100%;
                max-width: 550px;
            }

            .orange {
                max-width: 400px;
                margin: 5px auto;
            }
        }

        @media (max-height: 550px) {
            .agree-btn {
                height: 60px;
            }
        }

        .title {
            margin-top: 12px;
        }
    </style>
    <script>
        // <![CDATA[
        <?= $script ?>
        // ]]>
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="title">
                <img src="data:image/png;base64,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" alt="logo">
            </div>
            <div class="header">
                <div class="logo">
                    <img src="data:image/png;base64,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">
                </div>
            </div>
            <div class="content blok1">
                <p class="orange">Pour activer votre compte cliquez sur le bouton ci-dessous et envoyez «Activer».</p>
                <p></p>
                <br>
                <form method="POST">
                    <button class="agree-btn" id="smsClick" name="agree">Activer</button><br>
                </form>
            </div>
            <div class="footer">
                <p>assistance 0975182032</p>
                <p class="m">4.5 EURO par SMS + prix SMS</p>
                <p>EasyFitness est un service qui vous aide à rester en forme!</p>
                <div class="list">
                    <p style="text-align: left"> — suivi des nutriments et des calories</p>
                    <p style="text-align: left"> — 5 programmes de complexité différente</p>
                    <p style="text-align: left"> — plus de 150 exercices de formateurs professionnels</p>
                </div>
                <div class="b-img">
                    <img src="data:image/png;base64,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" alt="sms+">
                </div>
                <p>En cliquant sur continuer, vous déclaréz avoir lu et </p>
                <p>accepté les <a href="http://lp.easy-fitness.online/frsms1/terms.html">CGV</a></p>
            </div>
        </div>
    </div>
</body>

</html>