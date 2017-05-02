<?php
return [
    'adminEmail' => '18611348367@163.com',
    'supportEmail' => '18611348367@163.com',
    'user.passwordResetTokenExpire' => 3600,
    'site-keywords'=>'e油网',
    'site-desc'=>'e油网管理后台',
    'appkey'=>'23437908',//淘宝APPKEY
    'secretKey'=>'02c128a923720e3adea4af39b3e9a44c',//淘宝secretkey
    'photoUrl'=>'http://images.51eu.cc/photo/',
    'uploadUrl'=>'http://images.51eu.cc/',
    'baiduMapAK'=>'UbIBo7mo9wDuDz20VoEiAe8G',//百度地图ak
    'wxpayNotifyUrl'=>'http://api.51eu.cc/site/wxpay-notify',//微信支付异步通知
    'alipayNotifyUrl'=>'http://api.51eu.cc/site/alipay-notify',//微信支付异步通知
    'alipayConfig'=>[
        //应用ID,您的APPID。
        'app_id' => "2016121704374618",//正式账号
        'pid'=>'2088421965382161',
//         'app_id' => '2016072900115783',//沙箱账号
        
        //商户私钥，您的原始格式RSA私钥
        'merchant_private_key' => "MIICXQIBAAKBgQDywd7bW5pYULxlIndIOsRNBrumosRcXQy71fImn096XrVMTp3t1+pvBy6xgbvZjw8HdyUGnxsFEXRvjlqxae6Ugq+R+b+mLsZmux2IJbn1ccmI/AzDDLVIZmOBA6gHgfUzXCnLNFzqNaUjzoWxeeoZj7TdFIXaiF2EUNpQP5cLwQIDAQABAoGAHtr5gpQwGA2bBJfO5YVisg+rBlEl+D9zgOR+tN4G8hzbmmlbtYF+MMKO8sz0nYCLfn1sXV0XyBsh25QSfv5h7osVyC81JTD9/l1wmYbecqejOJAwiHSZKWjQjX8oNCp8aoBJffmRkJNino5ZwKjFAevzWstz4QT1UfwjS/23T+ECQQD7m/wQ+vBewjr1xiOmNfr8WdXel/eEdWnNCv5cThY/LtegPKsK5hr8/tUO86hwF/M4GSn1vOVUdWqwsSnDhVQlAkEA9v5XXo4eDWIMEpKdXoKEkSkh1LW+SFaMuploS1kaTEixw01fAfTeb3B3aHc0qYQhRc5DG2I8ahuj0I4xs5fYbQJBAPdyl7sHX8CBmsS9oa/EJNtramdo4zd01aGe7ztOXJi088EWCU1FskMgR99ViFD9bOi97sNLi+q9MzkkcyNkC7UCQGEYPPpTveae64YFks2LW1fBJqZ6x5GiTHIySjiMj3T7gr321WlsfGCsgpRTgCU/ZuENI35JUNyZfv1GWK1z/MUCQQDJEnr688t4yvJfsu+RURVGn3GPoBkzFXHlvDxE6D30RDaIevAIcHkIkJ9GDO7jWdCkGXIKlo6ilvPBmS+0LYqv",
//         'merchant_private_key'=>'MIICWwIBAAKBgQDFtmFr9hsfvz0vXAFbN9JyugPQ85T5pazvwqcWcOe1KuXGMo7L
// LEbXz6qntaoooR3FHMccwD28TzUNU6xXsB/jSORCJO/fWj+dXW3I1YxXvo6tWz0n
// YRvlG5NnKmGOPIJQgP8VzjUhK5hYdJoMbGGnl6qnX2SZooTO/4ZTwdvivwIDAQAB
// AoGAJzi0AN/Up6qfb6q31imvxPSj1yrLLe8w7GtYDDqfrK/y3yueai3BbASVXSnL
// tL2pkzXPRiPY22d3JcqokMiuumVrEyovEJEOG1xtI/D7tck2reykNO3JmwlyhrXP
// p2O9Ev5+1koIkaunSZe2Rcna0jv1hkmdYJyud1rGiABcvRkCQQDznWSH63kOHFIR
// Yla83zzmBfucTbKsnHgoum7TiOn1p2XlQvz/au2i0u3bhA2x/dRsafRiHdlbPZOZ
// z2SDCstrAkEAz8OTX7wjqVI1hzmxLun5QT2NMYN12OVACGrlO4coQaXLwucvQgDj
// coqEMi86kN6nf8U2npwRG6RUUjQI2HMO/QJADWDUV35/7F1zyE6dMswTnRIxChle
// OYpyMtJiKa24I2xo9Rkjqacmm613sHllAyRMWRPMfuLiv9b21xiDjYq3NwJAEcTT
// RNvNXPzX8SHBApcmJytBeRuaJ5urt0yVIFs12S951sh45Tc4PKKWHcimRJ+WSbov
// Kq+EUw3h3Enw+7oTbQJAciatfEGITEWQQuDN26T8KiAbyOGPg4TmFsjXe6Qrgm1x
// KyCrxuQdz2nxKlxgtf+AXJRIJFXrFhtBexWgGxbajw==',
        //异步通知地址
        'notify_url' => "http://api.51eu.cc/site/alipay-notify",
//         'notify_url' => "http://api.eoil.mi2you.com/site/alipay-notify",
        //同步跳转
        'return_url' => "http://api.51eu.cc/site/alipay-return",
        'base_path'=>"http://api.51eu.cc",
        //编码格式
        'charset' => "UTF-8",
        
        //支付宝网关
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",//正式地址
//         'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",//沙箱地址
        
        //支付宝公钥
        'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB",
        
    ]
];
