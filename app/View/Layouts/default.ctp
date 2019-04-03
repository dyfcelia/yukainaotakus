<?php
/** @var $baseUrl string 网站艮目 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<?php echo $this->Html->charset();
	?>
	<title>monster |-|

		<?php echo $this->fetch('title'); ?>
	</title>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-127217278-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}

		gtag('js', new Date());

		gtag('config', 'UA-127217278-1');
	</script>

	<?php
	echo $this->Html->meta('icon');
	//cake.generic
	echo $this->Html->script('jquery-3.3.1.js');
	echo $this->Html->script('bootstrap.js');
	echo $this->Html->css('bootstrap');

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>
</head>
<body>
<?php
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="<?= $baseUrl ?>">
		<?php echo $this->Html->image('logo.png', [
			'alt' => 'blabla',
			'class' => 'd-inline-block align-top',
			'width' => '60',
		]) ?>
		愉快なオタクs
	</a>
	<span style="font-size:0.5em;color:white;">全球最大的没卵用社区</span>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">

			<li class="nav-item">
				<?php
				echo $this->Html->link('新增游戏信息', [
					'controller' => 'GameInfo',
					'action' => 'add'
					//修改新增的地址
				], [
					'class' => 'nav-link',
				]);
				?>
			</li>
			<li class="nav-item">
				<?php
				echo $this->Html->link('Game:【さとしの飼い方】', "/さとしの飼い方", [
					'class' => 'nav-link',
					'target' => '_blank'
				]);
				?>
			</li>
		</ul>


		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<?php
				if (!empty($this->Session->read('Auth.User.username'))) {
					// echo "";

				} else {
					echo $this->Html->link("登录", [
						'controller' => 'Users',
						'action' => 'login'
					], [
						'class' => 'nav-link',

					]);
				}

				?>


            </li>
            <li class="nav-item" style="margin-right:10px;">
				<?php
				echo $this->Form->create('Search', array(
					'url' => array(
						'controller' => 'GameInfo',
						'action' => 'index'
					),
					'type' => "get",
					'inputDefaults' => array(
						'label' => false,
						'div' => 'false',
						'class' => 'form-control'
					),
					'class'=>'form-inline my-2 my-lg-0'
				));

				echo $this->Form->input('寻找游戏',[
                    'class'=>'form-control mr-sm-2',
                    'placeholder'=>"查找游戏，例如：动作"
                ]);
				echo $this->Form->input('查找',[
					'label'=>false,
					'div'=>false,
					'type'=>'submit',
					'class'=>'btn btn-outline-success my-2 my-sm-0'
				]);

				echo $this->Form->end();
				?>
            </li>

			<li class="nav-item">
				<?php if (!empty($this->Session->read('Auth.User.username'))) {
				} else {
					echo $this->Html->link('注册', [
						'controller' => 'Users',
						'action' => 'add'
					], [
						'class' => 'nav-link',

					]);
				} ?>

			</li>


			<li>
				<?php if (!empty($this->Session->read('Auth.User.username'))) {
					echo "<div class='btn-group'>
		 			 <button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>" . "您好" . $this->Session->read('Auth.User.username') . "</button>
						  <div class='dropdown-menu'>
						<a class='dropdown-item'>" . $this->Html->link('我的主页', [
							'controller' => 'Users',
							'action' => 'index',
							$this->Session->read('Auth.User.id')
						], array('class' => 'dropdown-item')) . "</a>" . "<div class='dropdown-divider'></div>" . $this->Html->link('修改个人信息', [
							'controller' => 'Users',
							'action' => 'edit',
							$this->Session->read('Auth.User.id')
						], array('class' => 'dropdown-item')) . "</a>" . "<div class='dropdown-divider'></div>" . $this->Html->link('退出登录', [
							'controller' => 'Users',
							'action' => 'logout'
						], array('class' => 'dropdown-item'));
				}


				?>
			</li>


		</ul>
	</div>
</nav>


<?php echo $this->element('common/header'); ?>
<div class="container-fluid">
	<?php echo $this->Flash->render(); ?>
	<?php echo $this->fetch('content'); ?>
</div>

</body>
</html>
