<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

// class AppController extends Controller {
//     public $components = array('DebugKit.Toolbar');

// }

class AppController extends Controller {
    //...

    public $components = array(
        'Flash',
        'Auth' => array(
            'loginRedirect' => array(
                'controller' => 'Users',
                'action' => 'login'
            ),
            'logoutRedirect' => array(
                'controller' => 'pages',
                'action' => 'display',
                'home'
            ),
            'authenticate' => array(
                'Form' => array(
                    'passwordHasher' => 'Blowfish'
                )
            ),
			'authError' =>'ログインしてください'
        )
    );
    public function isAuthorized($user) {
        // Admin 可以访问每个动作
        if (isset($user['role']) && ($user['role'] === 'admin' || $user['role']=='ssr')) {
            return true;
        }
    
        // 默认不允许访问
        return false;
    }

    public function beforeFilter() {
//        $this->Auth->allow( 'view');
		$this->userInfo=$this->Auth->user();
		$this->set('userInfo',$this->userInfo);

//		echo $this->userInfo = $this->Auth->user("id");
    }
    //...
}