<?php
$this->Html->css('pages/login', ['inline'=>false]);
?>

<div style="height:110px;"></div>

<div class="wrapper fadeInDown zero-raduis">
    <div id="formContent">
        <!-- Tabs Titles -->

        <!-- Icon -->
        <div class="fadeIn first">
            <!-- <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" /> -->
            <h2 class="my-5">Sign In</h2>
        </div>

        <!-- Login Form -->
		<?php  echo $this->Form->create('User'); ?>
            <?php
                echo $this->Form->input('username',[
                        'label'=>false,
                    'class'=>'fadeIn second zero-raduis',
                    'placeholder'=>'请输入账号'
                ]);
			echo $this->Form->input('password',[
				'label'=>false,
//				'type'=>"password",
				'class'=>'fadeIn second zero-raduis',
				'placeholder'=>'请输入密码'
			]);
        ?>

        <?php

			echo $this->Form->input('role', array(
                'label'=>false,
				'options' => array('u' => '正式用户'),
				'class'=>'fadeIn second zero-raduis',
                'hidden'=>'hidden'
			));
            ?>
            <div id="formFooter">
                <a class="underlineHover" href="#">别的?</a>
            </div>
		<?php echo $this->Form->end(__('提交')); ?>


        <h2>别的！</h2>

    </div>
</div>

