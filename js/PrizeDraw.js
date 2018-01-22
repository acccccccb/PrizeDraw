/**
 * Created by Administrator on 2018/1/11 0011.
 */

var result = "";
var n = 0 ;
var s=0;
var c;// 每隔一段时间出现一个名字
var v;
var t=200;//名单的动画速度
var m=800;//名单出现的速度
var stat_time; 
// 获取所有名单做滚动效果
var ScrollList=[];

$(document).ready(function(){
    var bodyHeight = $(document.body).height();
    $('body').css({height:bodyHeight});

    //播放音乐
    var PlayStartMusic = function(MusicName,loop){
        var StartMusic = '<audio id="BgSound" src = "music/' + MusicName + '" autoplay ' + loop + ' ></audio>';//音乐
        $('#AudioPlayer').html(StartMusic);
    };
    //停止音乐
    var StopMusic = function(){
        $('#AudioPlayer').html("");
    };

    // 敲鼓
    var playdrum = function(){
        $(".scroll-left-1,.scroll-left-3").addClass("playdrum-1");
        $(".scroll-left-2,.scroll-left-4").addClass("playdrum-2");
        $(".scroll-right-1,.scroll-right-3").addClass("playdrum-1");
        $(".scroll-right-2,.scroll-right-4").addClass("playdrum-2");
    };
    // 停止敲鼓
    var stopdrum = function(){
        $(".scroll-left-1,.scroll-left-3").removeClass("playdrum-1");
        $(".scroll-left-2,.scroll-left-4").removeClass("playdrum-2");
        $(".scroll-right-1,.scroll-right-3").removeClass("playdrum-1");
        $(".scroll-right-2,.scroll-right-4").removeClass("playdrum-2");
    };

    console.log('抽奖开始');
    // 开始动画
    var ShowAnimate = function(AnimateText){
        $("#Animate").html(AnimateText).animate({
            opacity:"1",
            top:"50%"
        },300,function(){
            $("#Animate").delay(500).animate({
                opacity:"0",
                top:"-500px"
            });
        });
    }
    // 依次显示结果
    var ShowList = function(){
        var nameLength = $('.namebox>.namelist').length;
        $(".namebox-hidescroll").addClass("duang");
        $("#total").html(nameLength);
        if(n < nameLength ) {
            $(".namelist").eq(''+n+'').fadeIn(400);
            n++;
            $("#namenum").html(n);
        } else {
            n=0;
            $(".namelist").eq(''+n+'').fadeIn(t);
            $(".namebox-hidescroll").removeClass("duang");
            clearInterval(c);// 停止显示名单
            clearInterval(v);// 停止滚动名单
            $("#ScrollBox").hide(true);
            ShowAnimate("抽奖完毕");
            StopMusic();
            PlayStartMusic("goal2.mp3","");
            //stopdrum();
        }
    };

    // 开始抽奖
    var PostValue = function(prize){
        $.ajax({
            url:"toupiao.php",
            type:"GET",
            contentType: "application/json;charset=utf-8",
            async: false,//异步
            data:{
                "prize":prize
            },
            success:function(res){
                if(prize != "restart") {
                    $('.namebox').prepend(res);
                    c = setInterval(ShowList,m);
                    showScroll();
                }
            },
            error:function(e){
                alert("网络错误");
            }
        });
    };
    //滚动名字

    // 获取名单
    $.ajax({  
        url : "json/nm.json",  
        datatype: "json",        
        async : false,  
        success : function(result) {  
            // ScrollList.push(result);
            // ScrollList.push(result.key);
            for (var key in result){
                ScrollList.push(result.key);
                console.log(key);
            }
            console.log(ScrollList);
        }
    });

    var ScrollName = function(){

        console.log(JSON.stringify(ScrollList));
        var ListLength = ScrollList.length;

        console.log("开始滚动");
        if(s<ListLength){
            s++;
            $("#ScrollBox").html(ScrollList[s]);
        } else {
            s=0;
            $("#ScrollBox").html(ScrollList[s]);
        }
    };
    // 显示/隐藏滚动动画
    var showScroll = function(){
        v = setInterval(ScrollName,100);//滚动名单
    };

    // 显示当前抽奖产品
    var ShowPrizeDrawInfo = function(PrizeDrawInfo){
        $("#lucky").html(PrizeDrawInfo);
    };
    // 开始抽奖时初始化参数
    var ready = function(buttom,text){
        clearInterval(c);
        n=0;
        $('.namebox').html('<div id="ScrollBox"></div><div style="clear:both;"></div>');
        $("#namenum").html("");
        $("#total").html("");
        ShowAnimate("开始抽奖");
        $(".info").show();
        ShowPrizeDrawInfo(text);
        buttom.attr('disabled',"true").css({cursor:"default"}).animate({opacity:"0.2"});
        $(".giftbox>.giftbox-list").eq(buttom.index()).fadeIn(200).siblings(".giftbox-list").hide();
        PlayStartMusic("start5.wav","loop");
        //playdrum();
        
    };
    // 重置所有抽奖
    var restart = function(){
        PostValue("restart");
        clearInterval(c);
        n=0;
        $(".info,#ScrollBox").hide();
        $("#taideng,#yehuangsu,#lipumei,#jieshouru").removeAttr("disabled").css({cursor:"pointer"}).animate({
            opacity:"1"
        });
        $('#BgSound').remove();
        //stopdrum();
        $('.namebox').html('<div id="ScrollBox"></div><div style="clear:both;"></div>');
        $('#ScrollBox').hide();
        $('.namebox-hidescroll').removeClass('duang');
        console.log("复位" + n);
    };
    
    // 判断当前抽奖产品并开始抽奖
    var start = function() {
        $("#taideng").click(function(){
            ready($(this),"正在抽取台灯获奖人员");
            PostValue("taideng");
        });
        $("#yehuangsu").click(function(){
            ready($(this),"叶黄素获奖人员");
            PostValue("yehuangsu");
        });
        $("#lipumei").click(function(){
            ready($(this),"立普美获奖人员");
            PostValue("lipumei");
        });
        $("#jieshouru").click(function(){
            ready($(this),"洁手乳获奖人员");
            PostValue("jieshouru");
        });
        $("#restart").click(function(){
            ShowPrizeDrawInfo("准备抽奖");
            var r=confirm("确定要清空所有中奖名单重新抽奖吗？")
            if (r==true){
                restart();
            } else {
                return false;
              }
            
        });
        // 显示奖品图片
        $(".btn-group>.btn").on("mouseenter",function(){
            var BtnIndex = $(this).index();
            $(".giftbox>.giftbox-list").eq(BtnIndex).fadeIn(500).siblings(".giftbox-list").hide();
        });
        
        // 监听键盘事件
        $(document).keyup(function(event){ 
            console.log(event.keyCode);
            if(event.altKey && event.keyCode === 49){
                $("#taideng").click();
            }
            if(event.altKey && event.keyCode === 50){
                $("#yehuangsu").click();
            }
            if(event.altKey && event.keyCode === 51){
                $("#lipumei").click();
            }
            if(event.altKey && event.keyCode === 52){
                $("#jieshouru").click();
            }
            if(event.altKey && event.keyCode === 48){
                $("#restart").click();
            }
        });
    };

    restart();
    start();    
});



























//var NameList = {
//    "zongbu":["柳菁","潘伟洪","刘雪莲","陈志兵","张杨","冯丽娜","刘小薇","张雁允","沙芸冬","李霞","李丽娜","罗菁妍","朱玫婕","梁婉婷","邓穗娟","陈志建","布巧燕","刘艳群","卫美欣"],
//    "tianhe":["杨欢","毕志萍","王国玲","王桂香","张绮华","王镇金","梁杏桃","杨敏","梁海燕","温志华","孔令俊","王海琳"]
//};
//
//var zongbu = NameList.zongbu;//总部
//var tianhe = NameList.tianhe;//天河
//
//
//var GetList = function(arr,count){
//    var total = arr.length;//候选人总数
//    var result = [];
//    for (var i = 0; i < count; i++) {
//        var index = ~~(Math.random() * total) + i;
//        result[i] = arr[index];
//        arr[index] = arr[i];
//        total--;
//    }
//    return result;
//};
//
//
//document.write(GetList(zongbu,12) + ',' + GetList(tianhe,6));