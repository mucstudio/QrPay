<?php
/**
 * 全能收款码（四码合一收款）QrPay
 */
if (@$_GET['a'] == 'qrcode') {
    if (@$_GET['text']) {
        include "class/phpqrcode.php";
        QRcode::png($_GET['text'], false, 'L', '10', '1');
        die;
    }
}
$url   = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$urlqr = $url . '?a=qrcode&text=';
$ua    = $_SERVER['HTTP_USER_AGENT'];
if (strpos($ua, 'Alipay')) {
    //支付宝
    $config = array(
        "url" => "TTPS://QR.ALIPAY.COM/FKX01872C33BXLCRU5XQF7",
        "new" => 0,
    );
} elseif (strpos($ua, 'MicroMessenger')) {
    //微信
    $config = array(
        "url"  => "wxp://f2f01fRtjGM205iRZPH2WYx4xZPAWXdIZSt2",
        "text" => "长按二维码付款",
        "col"  => "#44b549",
        "new"  => 1,
    );
} elseif (strpos($ua, 'QQ/')) {
    //QQ
    $config = array(
        "url"  => "https://i.qianbao.qq.com/wallet/sqrcode.htm?m=tenpay&a=1&u=86254741&ac=1C7289CD21E0E4A38511E2DCF22F0EF3BD0F53356FA7D63F36A601AF5608B420&n=%E6%9A%AE%E5%9F%8E&f=wallet",
        "text" => "长按二维码付款",
        "col"  => "#0099de",
        "new"  => 1,
    );
} elseif (strpos($ua, 'JDJR')) {
    //京东金融
    $config = array(
        "url"  => "https://h5pay.jd.com/c2cIndex?t=8140ddd0955eecc4c8d87abc2c6796651ba192843ae68b0042c9fb0848439bd4",
        "new"  => 0,
    );
} else {
    //普通打开页面
    $config = array(
        "url"  => $url,
        "text" => "支付宝、微信、QQ、京东金融<br>扫码付款",
        "col"  => "#2d2d2d",
        "new"  => 1,
    );
}
if (!$config['new']) header("Location:" . $config['url']);
$config['img'] = @$config['img'] ? $config['img'] : $urlqr . urlencode($config['url']);
?>
<!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <title>全能收款码</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="stylesheet" href="//cdn.bootcss.com/amazeui/2.7.2/css/amazeui.min.css">
</head>
<body>
    <style type="text/css">
        body{background:#fff;}
        .box{width:100%;height:100%;overflow:hidden;position:fixed;top:0;left:0;}
        .bg-f4{background-color:#f4f4f4;}
        .img{max-width:100%;max-height:100%;}
        ._title{height:80px;padding:10px 0;}
        ._qr{height:100%;background:<?php echo $config['col'] ?>;}
        ._qr img{width:80%;margin-top:50px;border-radius:10px;}
        ._bot{width:80%;background:#fff;margin:10px auto;padding:10px 5px;}
        ._copy{position:fixed;width:100%;bottom:0;left:0;color:#fff;padding:10px 0;font-size:10pt;}
    </style>
    <div class="am-g box">
        <div class="am-u-sm-12 am-u-md-6 am-u-lg-3 am-u-sm-centered bg-f4 am-text-center _title">
            <img src="payment/1.png" class="img" alt="支付宝">
            <img src="payment/2.png" class="img" alt="微信">
            <img src="payment/3.png" class="img" alt="QQ">
            <img src="payment/4.png" class="img" alt="京东金融">
        </div>
        <div class="am-u-sm-12 am-u-md-6 am-u-lg-3 am-u-sm-centered am-text-center _qr">
            <img src="<?php echo $config['img'] ?>" class="img">
            <div class="am-text-center _bot">
                <?php echo $config['text'] ?>
            </div>
        </div>
        <div class="am-text-center _copy">由暮城提供技术支持</div>
    </div>
</body>
</html>
