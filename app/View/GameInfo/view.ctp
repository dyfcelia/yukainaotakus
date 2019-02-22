<!-- File: /app/View/Monsters/view.ctp -->
<?php 

App::import('Vendor','util');
App::import('Vendor','platform');
?>

<div class="row">
    <div class="col-12" style="margin-top:20px;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/GameInfo/?page=<?= $page ?>">游戏一览</a></li>
                <li class="breadcrumb-item active" aria-current="page">Library</li>
            </ol>
        </nav>
    </div>
  <div class="col-3">

  <!-- <?php 
   // echo $this->Html->image("gameInfo/game_img_{$gameinfo['GameInfo']['id']}_1.jpg",[
        //'style'=>'max-height:240px;max-width:240px;'
    //]);
  ?> -->
  <!-- 画廊的div -->
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div align="center" class="carousel-inner" style="height:200px" >
            <div class="carousel-item active">
            <img class='d-block w-100'>  
            <?php echo $this->Html->image("gameInfo/game_img_{$gameinfo['GameInfo']['id']}_1.jpg",['style'=>'max-height:200px;max-width:200px;']);?> 
            </div>
            <div class="carousel-item">
            <img class="d-block w-100"> <?php echo $this->Html->image("gameInfo/game_img_{$gameinfo['GameInfo']['id']}_2.jpg",['style'=>'max-height:200px;max-width:200px;']);?>
            </div>
            <div class="carousel-item">
            <img class="d-block w-100"><?php echo $this->Html->image("gameInfo/game_img_{$gameinfo['GameInfo']['id']}_3.jpg",['style'=>'max-height:200px;max-width:200px;']);?>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>
  
  </div>
  <div class="col-6">
  
   <h1><?php echo  h($gameinfo['GameInfo']['game_name']); ?></h1>

        <div class="row">
            <div class="col-6">
            <p><?php echo "游戏类型：  ".h($gameinfo['GameInfo']['type']); ?></p>
            <p><?php echo "发售时间： ". h($gameinfo['GameInfo']['release_date']); ?></p>
            <p><?php echo "发行商： ". h($gameinfo['GameInfo']['publisher']); ?></p>
            </div>
            <div class="col-6">
            <p><?php echo "定价： ". h($gameinfo['GameInfo']['price']); ?></p>
            <p><?php $decNum=h($gameinfo['GameInfo']['platform']); 
            $platArray=(bin2dec($decNum)) ;

            $myPlatform=showPlatform($platArray);
            echo "运行平台：";
            foreach ($myPlatform as $key => $value) {
            echo $key." ";
            }; 
            ?></p>
            </div>
        </div> 
     <p><?php echo " 游戏简介： ". $gameinfo['GameInfo']['introduction']; ?></p>

  </div>
  <div class="col-1.5">
        <!-- 显示游戏环形图评分 -->     
        <canvas id="pie1" width="75px" height="75px"></canvas>
        <?php echo $this->Html->script("Charts.js");?>
        <script type="text/javascript">
            new Chart("pie1").ratePie(95),{animation:false};

        </script>
<h1>这是郑的天下</h1>
    
    <p>
        <font size="4">yutaku好评度</font> 
         &nbsp;&nbsp;&nbsp;&nbsp;
        

    </p>
  </div>
  <div class="col-1.5">
        <!-- 显示游戏环形图评分 -->     
        
        <canvas id="pie2" width="75px" height="75px"></canvas>
        
       
        <script type="text/javascript">
            new Chart("pie2").ratePie(95),{animation:false};
        </script>

    
    <p>
        <font size="4">用户好评度</font>

    </p>
  </div>
</div>

<div class="row">
  <div class="col-9">
        

        <!-- 用户评论的位置 -->
    <style>
    .yonghupinglun{
        border-top:1px solid #000;
        border-color: #FFFAF0;

    }
    .diyitiao{
        border-bottom:1px dashed #000;
        
    }
    .qitatiao{
        border-bottom:1px  dashed #000;
        
    }
    h4{

        background-color: #FFFAF0;
    }
    h5{
        border-bottom:1px solid #000;
        border-color: #DB7093;
    }
    h6{
        border-bottom:1px solid#000;
        border-color: #DB7093;
    }
    .huifu{
        float:right;
    }
    .moreyonghu{
        text-align:center;

    }  
    </style>
    <div class="yonghupinglun">
    <h4>热门用户评论</h4>
      
    <div class="diyitiao">
        <div class="yonghu">用户头像</div>
        <dl style="padding-left:60px">
            
            <dt>
                <span><?php echo "用户名"?></span> 
                <span><?php echo  "你大爷";//$use['platform']?></span>
                <span><?php echo "好评度";?></span>
            </dt>
            <dd><?php echo "真xiang";?></dd>
            <dd>发表于8102年13月32日
                <style>.huifu{
                     float:right;
                }</style>
            <span class="huifu">
            
                <em>点赞</em>
                <em>回复</em>
            </span>
            </dd>


              
        </dl>
        

    </div>
    <div class="qitatiao">
        <div>用户头像</div>
        <dl style="padding-left:60px">
            
            <dt>
                <span><?php echo "用户名"?></span> 
                <span><?php echo  "你大爷";//$use['platform']?></span>
                <span><?php echo "好评度";?></span>
            </dt>
            <dd><?php echo "真xiang";?></dd>
            <dd>发表于8102年13月32日
                <style>.huifu{
                     float:right;
                }</style>
            <span class="huifu">
            
                <em>点赞</em>
                <em>回复</em>
            </span>
            </dd>


              
        </dl>
        

    </div>
    <div class="qitatiao">
        <div>用户头像</div>
        <dl style="padding-left:60px">
            
            <dt>
                <span><?php echo "用户名"?></span> 
                <span><?php echo "你大爷";//$use['platform']?></span>
                <span><?php echo "好评度";?></span>
            </dt>
            <dd><?php echo "真xiang";?></dd>
            <dd>发表于8102年13月32日
                <style>.huifu{
                     float:right;
                }</style>
            <span class="huifu">
            
                <em>点赞</em>
                <em>回复</em>
            </span>
            </dd>


              
        </dl>
        

    </div>


    </div>
    <div class="moreyonghu"> 
    
    <a href="
    ">查看更多用户</a>
    
    </div>
    

  </div>
 <div class="col-3">
    <div>相关游戏
    <dl>
    <dt>1</dt>
    <dt>1</dt>
    <dt>1</dt>
    <dt>1</dt>
    <dt>1</dt>
    <dt>1</dt>
    </dl>
    </div>
    
    <div>游戏热度排行耪
    <dl>
    <dt>1</dt>
    <dt>1</dt>
    <dt>1</dt>
    <dt>1</dt>
    <dt>1</dt>
    <dt>1</dt>
    </dl>
    
    </div>
      
    </div> 
</div>
<br>
<br>
<br>
<div class="row">
  <div class="col-9">
<h5>游戏评测</h5>
<p>masdf</p>
<br><br><br><br><br>
<h6>最新攻略</h6>
<p>sdaasd</p>
<br><br><br><br><br>

</div>
</div>


<?php echo $this->Html->link(
    '返回列表',
    array( 'action' => 'index')
); ?>