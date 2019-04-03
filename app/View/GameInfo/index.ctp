<?php $this->Html->css('pages/GameInfo/index', ['inline' => false]); ?>
<?php
// TODO 不要再这里做import动作，放到控制器里
App::import('Vendor', 'util');
App::import('Vendor', 'platform');
/** @var $userInfo array 用户信息 */
?>



<script>
	// 当点击带有“data-ajax=link”的标签时，触发ajax事件
	$(function () {
		$("[data-ajax=link]").click(function () {
			var url = $(this).attr("href");
			var po = $(this)
			// 执行 ajax
			$.ajax({
				"url": url,
				"dataType": "json",
				"type": "get",
				"success": function (response) {
					if (response.result === true) {
						//alert("收藏成功");
						$('.alert').html('收藏成功！').addClass('alert-success').show().delay(2000).fadeOut();
						po.html('♥');
					} else {
						//alert(response.msg);
						$('.alert').html(response.msg).addClass('alert-warning').show().delay(2000).fadeOut();
						po.html('♡');
					}
				},
				"error": function () {
					//alert("通信失败");
					$('.alert').html('通信失败').addClass('alert-danger').show().delay(1500).fadeOut();
				}
			});
			return false;

		});
	});

	$(document).ready(function () {

		// 点击弹出条件查询的表单
		$(".btn2").click(function () {
			$("#pa").slideToggle();
		});
	});


	// 当like被点击的时候
	$(function () {
		$("[data-ajaxLike=link]").click(function () {
			var url = $(this).attr("href");
			$.ajax({
				"url": url,
				"dataType": "json",
				"type": "get",
				"success": function (response) {
					if (response.result === true) {
						$('.alert').html('操作成功！').addClass('alert-success').show().delay(2000).fadeOut();
					} else {
						$('.alert').html(response.msg).addClass('alert-success').show().delay(2000).fadeOut();
					}
				},
				"error": function () {
					alert("通信失败");
				}
			});
			return false;
		});
	});

	$(function () {
		$("[data-ajaxdontlike=link]").click(function () {
			var url = $(this).attr("href");
			$.ajax({
				"url": url,
				"dataType": "json",
				"type": "get",
				"success": function (response) {
					if (response.result === true) {
						alert("点踩成功");

					} else {
						alert(response.msg)
					}
				},
				"error": function () {
					alert("通信失败");
				}

			});
			return false;
		});
	});
</script>

<div class="container-fluid">
    <h1>2019游戏最佳排行 <span style="color:red;"> *HOT</span></h1>
    <div class="alert"></div>


    <div>
        <!-- 分页查询 --><!-- 分页查询 --><!-- 分页查询 --><!-- 分页查询 --><!-- 分页查询 --><!-- 分页查询 -->


    </div>
    <!--最外层框架-->
    <div class="row">

        <!--左边部分，信息介绍-->
        <div class="col-lg-9">
			<?php
			foreach ($gameinfo as $GameInfo):
				//拿到id
				$gameid = $GameInfo['GameInfo']['id'];
				?>
                <div class="row">
                    <div class="col-sm-3 col-6">
						<?php
						echo $this->Html->image("gameInfo/game_{$GameInfo['GameInfo']['outer_key']}_main.jpg", [
							'style' => 'width:100%'
						]);
						// 只在用户登录的情况下显示
                        if ($userInfo){
                            echo $this->Html->link('上传图片', array(
                                'controller' => 'GameInfo',
                                'action' => 'uploadfile',
                                '?' => ['game_info_id' => $GameInfo['GameInfo']['id']]
                            ));
						}
						?>

                        <br>
						<?php
						echo $this->Html->link('查看', array(
							'action' => 'view',
							$GameInfo['GameInfo']['id']
						));
						?>

						<?php
						echo $this->Html->link('编辑', array(
							'action' => 'edit',
							$GameInfo['GameInfo']['id']
						));
						?>

						<?php
						echo $this->Form->postLink('Delete', array(
							'action' => 'delete',
							$GameInfo['GameInfo']['id']
						), array('confirm' => 'Are you sure?'));
						?>

                        <br>

                    </div>
                    <div class="col-sm-5 col-6">
						<?php
						echo $this->Html->link($GameInfo['GameInfo']['game_name'], array(
							'action' => 'view',
							$GameInfo['GameInfo']['id']
						));
						?>
                        <br>
                        游戏类型:<?php echo $GameInfo['GameInfo']['type']; ?><br>
                        发行时间:<?php echo $GameInfo['GameInfo']['release_date']; ?><br>
                        发行商:<?php echo $GameInfo['GameInfo']['publisher']; ?><br>
                        游戏平台:<?php
						$decNum = $GameInfo['GameInfo']['platform'];
						$platArray = (bin2dec($decNum));
						if ($platArray) {
							$myPlatform = @showPlatform($platArray);
							foreach ($myPlatform as $key => $value) {
								echo $key . " ";
							}
						}
						?><br>
                        <br>
                        评分:<?php echo $GameInfo['GameInfo']['score']; ?><br>
                    </div>

                    <div class="col-sm-3 col-10">
                        <!-- 游戏价格: <?php echo $GameInfo['GameInfo']['price']; ?><br> -->

                        <br>

                        游戏介绍:
						<div style="max-height:200px; overflow-y:hidden">
							<?php echo $GameInfo['GameInfo']['introduction']; ?><br>
						</div>
						<?php
						if (in_array($GameInfo['GameInfo']['id'], $show)) {
							$mark = "♥";

						} else {
							$mark = "♡";
						}

						echo $this->Html->link($mark, array(
							'controller' => 'Collection',
							'action' => 'ajaxCollection',
							'?' => ['game_info_id' => $GameInfo['GameInfo']['id']],
						), [
								'data-ajax' => 'link',
								'style' => 'font-size:2em;color:red;text-decoration:none;'
							]

						);


						?>
                    </div>


                    <div class="col-sm-1 col-2">
						<?php
						// echo $this->Html->link('赞', array(
						// 	'controller' => 'Likes',
						// 	'action' => 'ajaxLike',
						// 	'?' => ['game_info_id' => $GameInfo['GameInfo']['id']],
						// ), [
						// 	'data-ajaxLike' => 'link'
						// ]

						//);
						echo $this->Html->link($this->Html->image("good.png", [
							'width' => '60',
							'height' => '60'
						]), // "<img src='/img/iine.png' >",
							array(
								'controller' => 'Likes',
								'action' => 'ajaxLike',
								'?' => [
									'game_info_id' => $GameInfo['GameInfo']['id'],
									'like' => 1
								],

							), [
								'data-ajaxLike' => 'link',
								'escape' => false
							]

						);

						echo isset($uplike[$gameid]) ? $uplike[$gameid] : 0;
						//debug($uplike);

						?>


                        <br>
                        <br>
						<?php

						echo $this->Html->link($this->Html->image("bad.png", [
							'width' => '60',
							'height' => '60'
						]), // "<img src='/img/iine.png' >",
							array(
								'controller' => 'Likes',
								'action' => 'ajaxLike',
								'?' => [
									'game_info_id' => $GameInfo['GameInfo']['id'],
									'like' => -1
								],
							), [
								'data-ajaxLike' => 'link',
								'escape' => false
							]);

						echo isset($dislike[$gameid]) ? $dislike[$gameid] : 0;

						?>

                    </div>
                </div>


                <hr>
			<?php endforeach; ?>
        </div>

		<!--右边部分，筛选器-->
		<div class="col-lg-3">
			<button class="btn2 btn btn-secondary w-100">高级搜索</button>
			<!--真的过滤器-->
			<div id="pa" style="display:none">
				<?php
				echo $this->Form->create('allSearch', array(
					'url' => array(
						'controller' => 'GameInfo',
						'action' => 'index'
					),
					'type' => "get",
					'inputDefaults' => array(
						'label' => ['class' => 'default-label-class'],
						'div' => 'form-group',
						'class' => 'form-control'
					),
				));
				echo $this->Form->input('游戏名字');
				echo $this->Form->input('游戏类型');
				echo $this->Form->input('游戏发行商');
				echo $this->Form->input('游戏发售时间');
				echo $this->Form->input('游戏评分');
				echo $this->Form->input('精确查找',[
					'label'=>false,
					'type'=>'submit',
					'div'=>false,
					'class'=>'btn btn-outline-success my-2 my-sm-0'
				]);
				echo $this->Form->end();
				?>
			</div>

			<!--假的过滤器-->
			<form>
				<h2>按照时间查找</h2>
				<h4>已选择条件</h4>
				<button class="btn btn-info btn-sm">啥都没</button>
				<hr>
				<h4>发售时间</h4>
				<button class="btn btn-info btn-sm">今年</button>
				<button class="btn btn-info btn-sm">明年</button>
				<hr>
				<h4>游戏平台</h4>
				<button class="btn btn-info btn-sm">psp</button>
				<button class="btn btn-info btn-sm">ps1</button>
				<button class="btn btn-info btn-sm">ps2</button>
				<button class="btn btn-info btn-sm">ps3</button>
				<button class="btn btn-info btn-sm">ps4</button>
				<button class="btn btn-danger btn-sm disabled">ps5</button>
				<button class="btn btn-warning btn-sm">nds</button>
				<button class="btn btn-info btn-sm">3ds</button>
				<button class="btn btn-success btn-sm">switch</button>
				<button class="btn btn-danger btn-sm">satosi</button>
				<button class="btn btn-success btn-sm">Android</button>
				<button class="btn btn-link btn-sm">IOS</button>

				<hr>
				<h4>游戏语言</h4>
				<button class="btn btn-link btn-sm">PHP</button>
				<button class="btn btn-link btn-sm">C#</button>
				<button class="btn btn-link btn-sm">Python</button>
				<hr>
				<h4>游戏类型</h4>
				<button class="btn btn-info btn-sm">杀人</button>
				<button class="btn btn-info btn-sm">被杀</button>
				<button class="btn btn-info btn-sm">第1人称</button>
				<button class="btn btn-info btn-sm">第2人称</button>
				<button class="btn btn-info btn-sm">第3人称</button>
				<hr>

			</form>

		</div>
    </div>

    <!--分页-->
	<?php

	$pageBegin = $pagenation['pageBegin'];
	$pageEnd = $pagenation['pageEnd'];
	$page = isset($_GET['page']) ? $_GET['page'] : 1;

	echo '<nav aria-label="...">';
	echo '<ul class="pagination">';
	echo '<li class="page-item disabled">';

	echo "</li>";
	$disabled = $page == 1 ? 'disabled' : '';
	echo "<li class=\"page-item {$disabled}\">";
	echo '<a class=\'page-link\' href="?page=' . ($page - 1) . '">上一页</a></li>';


	for ($a = $pageBegin; $a <= $pageEnd; $a++) {
		$activeClass = $a == $page ? 'active' : '';
		echo "<li class=\"page-item {$activeClass}\">
	<a class='page-link' href=\"?page={$a}\">{$a}</a ></li>";


		// debug($page);
		//  debug($a);
	}

	echo '<span class="sr-only">(current)</span>';
	$disabledlast = $page == $pageEnd ? 'disabled' : '';
	echo "<li class=\"page-item {$disabledlast}\">";

	echo '<a class=\'page-link\' href="?page=' . ($page + 1) . '">下一页</a>';
	echo "</li>";
	echo "</ul>";
	echo "</nav>";


	?>

</div>

