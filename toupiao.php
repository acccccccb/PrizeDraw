<?php

    // 定义全局变量
    $name = array();
    $zongbu = array();
    $tianhe = array();
    $yuexiu = array();
    $haizhu = array();
    $foshan = array();
    $dongguan = array();
    $shenzhen = array();
    $caiwu = array();
    $save = array();
    $FileName = "";
    $ReArray = array();


    // 从文件获取名单
    function GetJson($file){
        $getjson = file_get_contents($file);
        $getjson = json_decode($getjson,true);

        // 从文件赋值
        global $zongbu, $tianhe, $yuexiu, $haizhu, $foshan, $dongguan, $shenzhen, $caiwu, $teshu;

        $zongbu = $getjson["zongbu"];
        $tianhe = $getjson["tianhe"];
        $yuexiu = $getjson["yuexiu"];
        $haizhu = $getjson["haizhu"];
        $foshan = $getjson["foshan"];
        $dongguan = $getjson["dongguan"];
        $shenzhen = $getjson["shenzhen"];
        $caiwu = $getjson["caiwu"];
        $teshu = $getjson["teshu"];

    }

    // 保存中奖名单
    function SaveNamelist($Address,$TempArray,$FileName) {
        global $save;
        $TempSave = array(
            $Address=>$TempArray
        );
        $save = array_merge_recursive($save,$TempSave);
        $JsonSave = json_encode($save,JSON_UNESCAPED_UNICODE);
        file_put_contents('savelist/'.$FileName.'.json',$JsonSave.PHP_EOL);
    }

    // 抽奖 (候选人名单,选出个数)
    function Luckdraw($Address,$array,$count) {
        $TempArray = array(); // 已中奖
        if($count != 0) {
            $RandomKeys=array_rand($array,$count);
            for ($i = 0; $i < $count; $i++) {
                if( $count > 1) {
                    array_push($TempArray, $array[$RandomKeys[$i]]);
                } else {
                    array_push($TempArray, $array[array_rand($array)]);
                }
            }
        }
        $DiffArray = array_merge(array_diff($array,$TempArray)); // 未中奖
            //echo "<br /><b>已中奖：</b>";
            
            // 保存中奖名单
            global $FileName;
            SaveNamelist($Address,$TempArray,$FileName);
            
            //剩余未中奖人数写入json
            global $name;
            $TempName = array(
                $Address=>$DiffArray
            );
            $name = array_merge_recursive($name,$TempName);
            $JsonString = json_encode($name,JSON_UNESCAPED_UNICODE);
            file_put_contents('json/name.json', $JsonString); // 调试好后删除注释

            // 显示中奖名单
            global $ReArray;
            foreach($TempArray as $value){
                array_push($ReArray, $value);
            }
            //print_r($ReArray);
    }

    // 显示中奖名单
    function showList(){
        global $ReArray;
        shuffle($ReArray);
        foreach($ReArray as $value){
            echo '<div class="namelist">'.$value.'</div>';
        }
    }
    //洁手乳
    function jieshouru($zongbu,$tianhe,$yuexiu,$haizhu,$foshan,$dongguan,$shenzhen,$caiwu,$teshu){
        global $FileName;
        $FileName = "jieshouru";
        LuckDraw("zongbu",$zongbu,4);
        LuckDraw("tianhe",$tianhe,5);
        LuckDraw("yuexiu",$yuexiu,5);
        LuckDraw("haizhu",$haizhu,4);
        LuckDraw("foshan",$foshan,4);
        LuckDraw("dongguan",$dongguan,1);
        LuckDraw("shenzhen",$shenzhen,4);
        LuckDraw("caiwu",$caiwu,3);
        LuckDraw("teshu",$teshu,4);
        global $ReArray;
        showList();
    }
    //立普美
    function lipumei($zongbu,$tianhe,$yuexiu,$haizhu,$foshan,$dongguan,$shenzhen,$caiwu,$teshu){
        global $FileName;
        $FileName = "lipumei";
        LuckDraw("zongbu",$zongbu,4);
        LuckDraw("tianhe",$tianhe,3);
        LuckDraw("yuexiu",$yuexiu,3);
        LuckDraw("haizhu",$haizhu,3);
        LuckDraw("foshan",$foshan,3);
        LuckDraw("dongguan",$dongguan,3);
        LuckDraw("shenzhen",$shenzhen,3);
        LuckDraw("caiwu",$caiwu,1);
        LuckDraw("teshu",$teshu,1);
        global $ReArray;
        showList();
    }
    //叶黄素
    function yehuangsu($zongbu,$tianhe,$yuexiu,$haizhu,$foshan,$dongguan,$shenzhen,$caiwu,$teshu){
        global $FileName;
        $FileName = "yehuangsu";
        LuckDraw("zongbu",$zongbu,4);
        LuckDraw("tianhe",$tianhe,3);
        LuckDraw("yuexiu",$yuexiu,3);
        LuckDraw("haizhu",$haizhu,3);
        LuckDraw("foshan",$foshan,3);
        LuckDraw("dongguan",$dongguan,3);
        LuckDraw("shenzhen",$shenzhen,3);
        LuckDraw("caiwu",$caiwu,1);
        LuckDraw("teshu",$teshu,1);
        global $ReArray;
        showList();
    }
    //台灯
    function taideng($zongbu,$tianhe,$yuexiu,$haizhu,$foshan,$dongguan,$shenzhen,$caiwu,$teshu){
        global $FileName;
        $FileName = "taiden";
        LuckDraw("zongbu",$zongbu,1);
        LuckDraw("tianhe",$tianhe,1);
        LuckDraw("yuexiu",$yuexiu,1);
        LuckDraw("haizhu",$haizhu,1);
        LuckDraw("foshan",$foshan,1);
        LuckDraw("dongguan",$dongguan,1);
        LuckDraw("shenzhen",$shenzhen,1);
        LuckDraw("caiwu",$caiwu,1);
        LuckDraw("teshu",$teshu,0);
        global $ReArray;
        showList();
    }

    // 获取待抽奖名单
    GetJson("json/name.json");

    // 判断 post 数据
    $dep = $_GET['prize'];
    if($dep){
        if($dep == "taideng") {
            taideng($zongbu,$tianhe,$yuexiu,$haizhu,$foshan,$dongguan,$shenzhen,$caiwu,$teshu);
        }
        if($dep == "yehuangsu") {
            yehuangsu($zongbu,$tianhe,$yuexiu,$haizhu,$foshan,$dongguan,$shenzhen,$caiwu,$teshu);
        }
        if($dep == "lipumei") {
            lipumei($zongbu,$tianhe,$yuexiu,$haizhu,$foshan,$dongguan,$shenzhen,$caiwu,$teshu);
        }
        if($dep == "jieshouru") {
            jieshouru($zongbu,$tianhe,$yuexiu,$haizhu,$foshan,$dongguan,$shenzhen,$caiwu,$teshu);
        }
        if($dep == "restart") {
            $getallname = file_get_contents("json/nm.json");
            file_put_contents('json/name.json',$getallname);
            echo "";
        }

    }

?>