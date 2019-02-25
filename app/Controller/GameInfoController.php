<?php
class GameInfoController extends AppController {
    public $helpers = array('Html', 'Form','Flash');
    public $components = array('Auth','Session','Paginator');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow( 'view','index');
	}
    public function isAuthorized($user) {
        // 所有注册的用户都能够添加文章
        if ($this->action === 'add') {
            return true;
        }

        // 文章的所有者能够编辑和删除它
        if (in_array($this->action, array('edit', 'delete'))) {
            $id = (int) $this->request->params['pass'][0];
        }

        return parent::isAuthorized($user);
    }


	/**
	 * 执行 点赞
	 */
    public function doLike(){

    	$this->autoRender = false;

    	// 接收参数 game id
		$gameId = $this->request->query("gameInfo");

		// 从session中获取用户的信息
		$userInfo = $this->Auth->user();
		$userId = $userInfo['id'];

//		debug($gameId);
//		debug($userId);

		echo true;

		// 执行数据操作
	}

    public function index(){

        if ($this->request->is('GET')){
        $page=isset($_GET['page'])?$_GET['page']:1;
        $this->loadModel("GameInfo");
        $itemCount=$this->GameInfo->find('count'); //数据总数
        function getPage($page,$itemCount){
                //if判断如果当前是首页了的话
                $itemPerPage=8;
                //计算总页数=总数/每页显示数
                //需要一个数据库长度的count
                $total= ceil($itemCount/$itemPerPage); // ceil() 函数向上舍入为最接近的整数。
                if($page>$total){
                	$page=$total-1;
                }

                $maxPageCount=10; //开始一共有10行
                $buffCount=5; //能看到5行
                $pageBegin=1; //开始页面1行
                $pageEnd="";
                if ($page< $buffCount){ //如果页数要比页小
                $pageBegin=1;
                }else if($page>=$buffCount and $page<=$total ){ //当页数大于5页 而且 页数小于等于 总页数-10
                $pageBegin=$page-$buffCount+1; //就让开始页面=第几页-5+1
                }else{
                $pageBegin=$total-$maxPageCount+1; //否则开始页面就等于=总页面-10+1
                }
                $pageEnd=$pageBegin+$maxPageCount-1;
                $pageEnd=$pageEnd>$total?$total:$pageEnd;

                $Pagenation=[
					'page'=>$page,
					'pageBegin'=>$pageBegin,
					'pageEnd'=>$pageEnd,
					'itemCount'=>$itemCount,
					'itemPerPage'=>$itemPerPage //每页数据的个数
                ];

                return $Pagenation;
                }
        }

		$this->set('pagenation', $pagenation = getPage($page,$itemCount));
		$this->set('gameinfo', $this->GameInfo->find('all', array('limit' => $pagenation['itemPerPage'],  'page' =>$page)));


            $this->loadModel("Collection");
            $a=$this->Collection->find('list',array(
                'fields'=>array('id','game_id'),
                'conditions'=>array('user_id'=>$this->Auth->user("id"))));

            $this->set('show', $a);

//		$this->set("page",$page);
		$this->Session->write("page",$page);

        $this->loadModel("Like");



        $l=$this->Like->find('all');
     // debug($l);

     //计数 点赞 计数 点赞计数 点赞计数 点赞计数 点赞计数 点赞计数 点赞计数 点赞计数 点赞计数 点赞
        $b=$this->Like->find('all',array(
         'fields' =>array('Like.game_id',
         'count(user_iine) as like_count'
         )
        ,
            'conditions'=>array(


                'user_iine'=>'1'


            ),
            'group' => 'game_id'
        ));
$gllist=[];
        foreach ($b as $v) {

 // debug($v);
$gameId=$v['Like']['game_id'];
//debug($gameId);
$likeCount = $v[0]['like_count'];
//debug($likeCount);

$gllist[$gameId]=$likeCount;
//debug($gllist);
        }
        $this->set('uplike', $gllist);





//bad like 计数点踩 计数点踩 计数点踩 计数点踩 计数点踩 计数点踩 计数点踩 计数点踩 计数点踩 计数点踩 计数点踩 计数点踩

$badlike=$this->Like->find('all',array(
    'fields' =>array('Like.game_id',
    'count(user_noiine) as nolike_count '
    )
   ,
       'conditions'=>array(


           'user_noiine'=>'1'


       ),
       'group' => 'game_id'
   ));
//debug($badlike);
$badlist=[];
   foreach ($badlike as $badval) {

// debug($$badval);
$badgameId=$badval['Like']['game_id'];
//debug($badgameId);
$badlikeCount = $badval[0]['nolike_count'];
//debug($badlikeCount);

$badlist[$badgameId]=$badlikeCount;

   }
   $this->set('dislike', $badlist);







     $c=$this->Like->find('count',array(
        'conditions'=>array( 'user_noiine'=>'1'

     ),

    ));
    //debug($c);

    $this->set('downlike', $c);
        // $c=$this->Like->find('all');
        //         debug($c);


        //拿到数据资源 这是个空的
//  $db = $this->getDataSource();
// //debug($db);
//  //取到所有

// //  App::uses('ConnectionManager', 'Like');
// // $db = ConnectionManager::getDataSource("index");
// debug($db);
// //debug($db->query('Get', array('test')));
// $db->fetchAll(
//     'SELECT * from `like` where user_iine=:user_iine',
//     array('user_iine' => '1')
// );
// debug($db);
        }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid gameinfo'));
        }

        $gameinfo = $this->GameInfo->findByid($id);
        if (!$gameinfo) {
            throw new NotFoundException(__('Invalid gameinfo'));
        }

		$page = $this->Session->read('page');
        $this->set('gameinfo', $gameinfo);
		$this->set('page', $page);

    }

    public function add() {
        if ($this->request->is('post')) {
            //create模型
            $this->GameInfo->create();
            //遍历平台的数组
            foreach($_POST['data']['GameInfo']['platform'] as $i){
            $platDecArray[]= $i;
            }
            //得到十进制的数字
            $decNum=array_sum($platDecArray);

            //debug($this->request->data);
            //$result = $this->request->data;
            //把post的数据set给模型 平台的数值用刚才求出来的数
            $result=$this->GameInfo->set(array(
               'game_name' =>$_POST['data']['GameInfo']['game_name'],
               'type' => $_POST['data']['GameInfo']['type'],
               'release_date' => $_POST['data']['GameInfo']['release_date'],
               'publisher' => $_POST['data']['GameInfo']['publisher'],
//               'score' => $_POST['data']['GameInfo']['score'],
               'introduction' => $_POST['data']['GameInfo']['introduction'],
               'platform' => $decNum,
               'price' => $_POST['data']['GameInfo']['price'],
                ));

            if ($this->GameInfo->save($result)) {
                $this->Flash->success(__('成功.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('错误了.'));
            //debug($this->GameInfo->validationErrors);
        }
    }

    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('I木有ID可不行哟'));
        }

        $GameInfo = $this->GameInfo->findById($id);
        $this->set('a', $GameInfo);
        if (!$GameInfo) {
            throw new NotFoundException(__('并不致命的错误'));
        }

        if ($this->request->is(array('Post', 'put'))) {
            $this->GameInfo->id = $id;
            foreach($_POST['data']['GameInfo']['platform'] as $i){
                $platDecArray[]= $i;
                }
                //得到十进制的数字
                $decNum=array_sum($platDecArray);

                //debug($this->request->data);
                //$result = $this->request->data;
                //把post的数据set给模型 平台的数值用刚才求出来的数
                $result=$this->GameInfo->set(array(
                   'game_name' =>$_POST['data']['GameInfo']['game_name'],
                   'type' => $_POST['data']['GameInfo']['type'],
                   'release_date' => $_POST['data']['GameInfo']['release_date'],
                   'publisher' => $_POST['data']['GameInfo']['publisher'],
                   'score' => $_POST['data']['GameInfo']['score'],
                   'introduction' => $_POST['data']['GameInfo']['introduction'],
                   'platform' => $decNum,
                   'price' => $_POST['data']['GameInfo']['price'],
                    ));
           //$this->request->data
            //$this->GameInfo->platform
            if ($this->GameInfo->save($result)) {
                $this->Flash->success(__('ok改好了'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('失败了'));
        }

        if (!$this->request->data) {
            $this->request->data = $GameInfo;
        }
    }



    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        if ($this->GameInfo->delete($id)) {
            $this->Flash->success(
                __('你删除了一个编号为: %s 号的数据', h($id))
            );
        } else {
            $this->Flash->error(
                __('你想删除编号为: %s 号的数据却失败了.', h($id))
            );
        }

        return $this->redirect(array('action' => 'index'));
    }

    public function doUploadFile(){
        //禁止自动跳转
        $this->autoRender = false;
        $id = $this->request->data["uploadfile"]["game_info_id"];
        debug($this->request->data);
        debug($id);
       $radio= $this->request->data["uploadfile"]["dijizhang"];
       //debug($id);
        //debug($this->request->data);
        if($radio==null){
            $this->Flash->error(__('请选择第几张图片'));
            return $this->redirect(array('action' => 'uploadfile'));
        }
        //设置文件名字为空
        $filename = '';
        //path 路径
        $uploadData = $this->data['uploadfile']['pdf_path'];
        debug($uploadData);
        $houzhui="";
        if($uploadData['type']=='image/jpeg'){
            $houzhui="jpg";
        }
        else if($uploadData['type']=='image/png'){
            $filePath = $uploadData['tmp_name'];
            debug($filePath);

            $image = imagecreatefrompng($filePath);
                    $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
                    imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                    imagealphablending($bg, TRUE);
                    imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                    imagedestroy($image);
                    $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file
                    $filename = 'game_img_'.$id.'_'.$radio.'.jpg';
                    imagejpeg($bg,WWW_ROOT."img/gameInfo/".$filename, $quality);
                    debug(WWW_ROOT."/img/gameInfo");
                    imagedestroy($bg);
               //$houzhui="jpg";

        }
        else if($uploadData['type']=='image/jpg'){
            $houzhui="jpg";
        }
        else{
            $this->Flash->error(__('请输入正确的图片格式'));
            return $this->redirect(array('action' => 'uploadfile'));
        }






        //如果他的size是0 而且没有报错信息 返回一个
        if ($uploadData['size'] == 0 || $uploadData['error'] !== 0) {
           return false;
        }               //显示带有文件扩展名的文件名
        $filename = basename($uploadData['name']);
        //文件夹名
        $uploadFolder = WWW_ROOT . 'img/gameInfo';
        //文件名 时间戳  下划线加原来的名字
        //  $filename = time() . '_' . $filename;
          $filename = 'game_img_'.$id.'_'.$radio.'.'.$houzhui;
         //下载路径   WWW_ROOT -- webrootディレクトリ絶対パス DS -- PHPのDIRECTORY_SEPARATORの短縮系。Windowsの場合は\ (バックスラッシュ)、 Linuxの場合は/ (フォーワードスラッシュ)
        $uploadPath = $uploadFolder . DS . $filename;
        // file_exists 检查文件夹是否存在
        if (!file_exists($uploadFolder)) {
            //mkdir() 函数创建目录。
           mkdir($uploadFolder);
        }
        //move_uploaded_file()将上传的文件移动到新位置。 tmp_name 临时文件夹的文件名
        if (!move_uploaded_file($uploadData['tmp_name'], $uploadPath)) {
           return false;
        }

        $this->set('image', $filename);
            $this->Flash->success(__('增加了一张新图片'));
             return $this->redirect(array('action' => 'index'));




     }

     public function uploadfile(){
         //接受到了ganme_info_id存到了game_id
        $game_info_id=$this->request->query('game_info_id');
        //我存到的给了前台画面 试图
        $this->set('game_info_id',$game_info_id);



     }
// //imagecreatefrompng() 返回一图像标识符，代表了从给定的文件名取得的图像。
// $image = imagecreatefrompng($filePath);
// //imagecreatetruecolor — 新建一个真彩色图像 imagesx — 取得图像宽度 imagesy — 取得图像高度
// $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
// //imagefill — 区域填充 imagecolorallocate — 为一幅图像分配颜色
// imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
// //imagealphablending — 设定图像的混色模式
// imagealphablending($bg, TRUE);
// //imagecopy — 拷贝图像的一部分
// imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
// //imagedestroy — 销毁一图像
// imagedestroy($image);
// $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file
// //imagejpeg — 输出图象到浏览器或文件。
// imagejpeg($bg, $filePath . ".jpg", $quality);
// //imagedestroy — 销毁一图像
// imagedestroy($bg);



// $image=""
// function createThumbnail($imageDirectory, $imageName, $thumbDirectory, $thumbWidth) {
//     $explode = explode(".", $imageName);
//     $filetype = $explode[1];

//     if ($filetype == 'jpg') {
//         $srcImg = imagecreatefromjpeg("$imageDirectory/$imageName");
//     } else
//     if ($filetype == 'jpeg') {
//         $srcImg = imagecreatefromjpeg("$imageDirectory/$imageName");
//     } else
//     if ($filetype == 'png') {
//         $srcImg = imagecreatefrompng("$imageDirectory/$imageName");
//     } else
//     if ($filetype == 'gif') {
//         $srcImg = imagecreatefromgif("$imageDirectory/$imageName");
//     }

//     $origWidth = imagesx($srcImg);
//     $origHeight = imagesy($srcImg);

//     $ratio = $origWidth / $thumbWidth;
//     $thumbHeight = $origHeight / $ratio;

//     $thumbImg = imagecreatetruecolor($thumbWidth, $thumbHeight);
//     imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $origWidth, $origHeight);

//     if ($filetype == 'jpg') {
//         imagejpeg($thumbImg, "$thumbDirectory/$imageName");
//     } else
//     if ($filetype == 'jpeg') {
//         imagejpeg($thumbImg, "$thumbDirectory/$imageName");
//     } else
//     if ($filetype == 'png') {
//         imagepng($thumbImg, "$thumbDirectory/$imageName");
//     } else
//     if ($filetype == 'gif') {
//         imagegif($thumbImg, "$thumbDirectory/$imageName");
//     }
}





?>
