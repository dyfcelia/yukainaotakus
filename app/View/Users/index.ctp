
<script>
	$(function () {
		$("#start").click(function () {
			var url = $(this).find('a').attr("href");
			//alert(url);
			var search = $("input").val();
			$.ajax({
				"url": url,
				data: {search: search},
				"dataType": "html",
				"type": "get",
				"success": function (response) {
					if (response == false) {
						alert("没有查到符合条件的用户");
						console.log(false);
						$("#find").html(" ");
					} else {
						$("#find").html(response);
						console.log("有数据");
					}
				},
				"error": function () {
					alert("通信失败");
				}
			});
			return false;
		});

		$("body").on('click', '.doLevelUp', function () {
			var id = $(this).attr("id");

			$.ajax({
				"url": "../doLevelUp",
				data: {id: id},
				"dataType": "json",
				"type": "get",
				"success": function (response) {
					if (response.result === true) {
						$('#find').html(response.msg);

					} else {
						$('#find').html(response.msg);

					}
				},
				"error": function () {
					alert("通信失败");
				}

			});
			return false;
		});
	})


</script>
<div class="container-fluid">

    <h1>个人主页</h1>

    <p>
		<?php
		//debug($_SESSION);

		echo "您好" . $this->Session->read('Auth.User.username') . "!!!您是本站的第" . $this->Session->read('Auth.User.id') . "位用户，希望您在这里尽情享受【没卵用系列】给您带来的极致用户体验！have a nice day !";
		$role = $this->Session->read('Auth.User.role');
		?>
    </p>

    <p>以下是您收藏过的游戏:</p>
    <table class="table table-bordered">
        <tr>
            <th>游戏名</th>
        </tr>

		<?php
		foreach ($list as $MyList):?>
            <tr>
                <td><?php echo $MyList['GameInfo']['game_name']; ?></td>
            </tr>
		<?php endforeach; ?>
    </table>

    <div>收藏栏 以上です</div>


    <br>
    <p>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
                aria-controls="collapseExample">
            只有ssr才知道的世界
        </button>
    </p>

    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            这里可以把u级角色免费升级为sr!

            <div class="row">
                <div class="col-6">
                    <input type="text" class="form-control" placeholder="请输入用户名或id进行搜索">
                </div>
            </div>
            <br>
            <div class="form-group row">
                <div class="col-sm-10">
                    <button id="start" type="button" class="btn btn-warning"><?php echo $this->Html->link('点我搜索', array(
							'controller' => 'Users',
							'action' => 'levelUp'
						), [
								'data-ajax' => 'link',
							]

						); ?> </button>
                </div>
            </div>
            <p id="find">
            </p>

        </div>
    </div>
</div>
