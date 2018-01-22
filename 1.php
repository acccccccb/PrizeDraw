<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="js/jquery_2.1.4_jquery.min.js"></script>
    <title>抽奖结果</title>
</head>
<body>
    <?php
        // 从文件获取名单
        function GetJson($file,$giftname){
            $getjson = file_get_contents($file);
            $getjson = stripslashes($getjson);
            print_r($giftname.":<pre>".$getjson."</pre>");
        }
    ?>
    <div id="taiden">
        <div class="tianhe">
            <div class="namelist-group">
                <?php GetJson("savelist/taiden.json","台灯"); ?>
            </div>
            <div class="namelist-group">
                <?php GetJson("savelist/yehuangsu.json","叶黄素"); ?>
            </div>
            <div class="namelist-group">
                <?php GetJson("savelist/lipumei.json","立普美"); ?>
            </div>
            <div class="namelist-group">
                <?php GetJson("savelist/jieshouru.json","洁手乳"); ?>
            </div>
        </div>
    </div>
    <style>
        .title {
            font-weight:bold;
        }
        .namelist {
            padding:3px 5px;
        }
    </style>
</body>
</html>