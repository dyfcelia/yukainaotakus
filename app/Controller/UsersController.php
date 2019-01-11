<?php
App::uses('AppController', 'Controller');
App::import('Vendor', 'Objects/BasicResult');
class UsersController extends AppController {

    public $helpers = array('Html', 'Form','Flash');
    public $components = array('Flash');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout','login','edit');
    }

     public function levelUp(){
        $this->autoRender = false ;
        // $this->Auth->user('role')==ssr ;
        //debug($this->Auth->user());
     $search=$this->request->query('search');

    $find=$this->User->findAllByIdOrUsername($search, $search);

    //验证是否为空 为空报错
    if(empty($find)){
       $result = false ;
       return $result;
        }
    //有用户 验证用户数量 + 权限
    //当有一个用户(第二个是空) 且权限不是u时报错 没有查到对应用户
        if(empty($find[1]['User'])){
             if($find[0]['User']['role']!=='u'){
                $result = false;
                return $result;

             }else{
                $data =[$find[0]['User']['id'],$find[0]['User']['username']];

            }

         }else{   //数组不为空 且第二个也不是空 ==搜出了两个用户

             if($find[0]['User']['role']=='u' && $find[1]['User']['role']=='u'){ // 1&2合法
                $data=[$find[0]['User']['id'],$find[0]['User']['username'],$find[1]['User']['id'],$find[1]['User']['username']];
               // debug($data);

                $result="<table border=\"1\"  class=\"col-6\" ><tr><td>"."用户ID:"."$data[0]"."</td><td>"."用户名:"."$data[1]"."</td>
                <td><button class='doLevelUp' id=\"$data[0]\">升级</button></td></tr>
                <tr><td>"."用户ID:"."$data[2]"."</td><td>"."用户名:"."$data[3]"."</td>
                <td><button class='doLevelUp' id=\"$data[2]\">升级</button></td></tr></table>";
		        return $result;

                }elseif($find[0]['User']['role']!='u'&& $find[1]['User']['role']=='u'){      //1不行 2合法
                     $data=[$find[1]['User']['id'],$find[1]['User']['username']];

                    }elseif($find[0]['User']['role']=='u'&& $find[1]['User']['role']!='u'){     //1合法 2不行
                        $data=[$find[0]['User']['id'],$find[0]['User']['username']];

                 }else{
                $result = false ;
                return $result;
                    }
            }
            $result="<table border=\"1\"  class=\"col-6\" ><tr><td>"."用户ID:"."$data[0]"."</td><td>"."用户名:"."$data[1]"."</td>
               <td><button class='doLevelUp' id=\"$data[0]\">升级</button></td></tr></table>";
               return $result;

            }



    public function doLevelUp(){     //这里的id想要变更对象的id
        $this->autoRender = false ;
        if($this->Auth->user('role')!='ssr'){
            $result =  new BasicResult(false, "你没有操作权限");
            return json_encode($result);
        }else{
            $id=$this->request->query('id');
            $find=$this->User->findById($id);

            $find['User']= array('id' => $id, 'role' => 'sr');
            if($this->User->save($find)) {
                $result =  new BasicResult(true, "权限已变更为sr");
                return json_encode($result);
             }
             $result =  new BasicResult(false, "迷之错误");
		     return json_encode($result);

        }
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->Flash->success('登陆成功');
                return $this->redirect(array('controller' => 'Users','action' => 'index',$this->Auth->user('id')));

                //return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('用户名或者密码有误，请重新输入'));
        }
    }

    public function logout() {
         return $this->redirect($this->Auth->logout());
    }

    public function index($id = null) {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
        $id=$this->Auth->user('id');
       if(isset($id)){
            $this->loadModel('Collection');
            $tmp = $this->Collection->find('list',array('fields'=>'game_id',
             'conditions' => array('user_id'=>$id)));

        foreach($tmp as $value){
            $my[]=$value;
        }
        $this->loadModel('GameInfo');
        $aaa = $this->GameInfo->find('all',array('conditions'=>array('id'=>$tmp)));

      //$my=
        $this->set("list",$aaa);
       }else{}





        // $list = $this->Collection->find('all');
		// $this->set("list", $list);
    }






    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('无效数据'));
        }
        $this->set('user', $this->User->findById($id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('注册成功'));
                $this->loadModel('UserInfo');
                $newinfo=$this->UserInfo->create(array('nickname'=>'肥大','user_id'=>$this->User->getLastInsertID()));
                $this->UserInfo->save($newinfo);
                $this->Auth->login();
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('失败，请重试')
            );
        }
    }
//这里的编辑其实是user_info的内容
    public function edit($id = null) {
        $this->User->id = $id;
        $this->loadModel('UserInfo');

        if (!$this->User->exists()) {
            throw new NotFoundException(__('无效数据'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $now=$this->UserInfo->findByUserId($id);
                $sex=array_sum($_POST['data']['UserInfo']['sex_div']);
                //$find=$this->request->data;
                $data=[
                    'id'=>$now['UserInfo']['id'],
                    'user_id'=>$id,
                    'nickname'=>$_POST['data']['UserInfo']['nickname'],
                    'email'=>$_POST['data']['UserInfo']['email'],
                    'sex_div'=>$sex,
                    'birthday'=>$_POST['data']['UserInfo']['birthday']
                    ];

            if ($this->UserInfo->save($data)) {
                $this->Flash->success(__('编辑成功'));
                //debug($find);
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(
                __('失败，请重试')
            );
        } else {
            $this->request->data = $this->UserInfo->findByUserId($id);
            //unset($this->request->data['UserInfo']['id']);
        }
    }

    public function delete($id = null) {
        $this->request->allowMethod('post');

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Flash->success(__('账号删除'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Flash->error(__('账号删除失败'));
        return $this->redirect(array('action' => 'index'));
    }


    function upload()
{
    if($this->request->data){
        if($this->User->saveAll($this->request->data)){
            echo 'ok';
        }
    }
}

}

?>