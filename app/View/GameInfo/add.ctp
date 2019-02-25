
<div class="container-fluid">
    <h1>新增游戏情报</h1>

    <?php
	echo $this->Form->create('GameInfo', array(
		'inputDefaults' => array(
			'label' => [
				'class' => 'default-label-class'
			],
			'div' => 'form-group',
			'class' => 'form-control',
			'escape' => false
		)
	));
    ?>
    <div class="row">
        <div class="col-sm-6">
			<?php
			echo $this->Form->input('game_name', [
				'label' => '游戏名',
			]);
			echo $this->Form->input('type', [
				'label' => '游戏类型',
			]);
			echo $this->Form->input('release_date', [
				'label' => '发行日期<br>',
				'type' => 'date',
				'div' => false,
				'class' => false,
			]);
			echo $this->Form->input('publisher', [
				'label' => '发行商',
			]);
			echo $this->Form->input('introduction', [
				'label' => '简介',
			]);

			echo $this->Form->input('price',[
				'label' => '发售价格',
			]);

			echo $this->Form->input('score',[
				'type' => 'hidden',
			]);
			?>
        </div>
        <div class="col-sm-6">
			<?php
			$options = array(
				1 => 'ps2',
				2 => 'ps3',
				4 => 'ps4',
				8 => 'psp',
				16 => 'steam',
				32 => 'psv',
				64 => '3DS',
				128 => 'switch',
				256 => 'WiiU',
				512 => 'Xbox1/Xbox360',
				1024 => 'PC'
			);
			//$selected = array(1, 3);
			echo $this->Form->input('platform', array(
				'multiple' => 'checkbox',
				'label' => '平台',
				'options' => $options,
				'div' => false,
				'class' => false
			));
			?>


        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <input type="submit" class="btn btn-primary"/>

        </div>
    </div>

	<?php
	echo $this->Form->end();
	?>





</div>

