<?php 
	include 'inc/header.php';
	$sql0 = "select * from menu where id={$_GET['up_id']}";
	if ($_GET['up_id'] == "") {
		$sql0 = "select * from menu where id={$_GET['id']}";
	}
	$info = $mysqlObj->fetchOne($sql0);
	$sql = "select * from menu_cont where up_id={$_GET['id']}";
	$data = $mysqlObj->fetchOne($sql);

?>
	</div>
	<!-- 主体内容区 -->
	<div class="con_wrap">
	<div class="content">
		<!-- 侧边栏 -->
		<div class="navside">
			<dl>
				<dt><?php echo $info['name']?></dt>
				<dd>
					<ul>
						<?php 
							$sql1 = "select * from menu where up_id={$_GET['up_id']}";
							$row = $mysqlObj->fetchAll($sql1);
							foreach ($row as $key => $value) {
								switch ($value['type']) {
									case '1':
										$url = "content.php?id=".$value['id']."&up_id=".$value['up_id'];
										break;
									case '2':
										$url = "list.php?id=".$value['id']."&up_id=".$value['up_id'];
										break;
								}
						?>
						<li class="<?php if ($value['id']==$_GET['id']) echo "active"?>">
							<a href="<?php echo $url;?>"><?php echo $value['name']?></a>
						</li>
						<?php 
							}
						?>
					</ul>
				</dd>
			</dl>
		</div>
		<!-- 主体 -->
		<div class="box">
			<!-- 新闻列表 -->
			<ul class="tp">
				<?php 
					$sql = "select count(*) as num from menu_cont where up_id={$_GET['id']}";
					$row = $mysqlObj->fetchOne($sql);
					$num = $row['num'];
					$listRows = 15;
					$page = new Page($num, $listRows, $args);
					$page->set('head', '条数据');
					$index = $num;
					$sql = "select * from menu_cont where up_id={$_GET['id']} order by created_at desc,id desc {$page->limit}";
					$row = $mysqlObj->fetchAll($sql);
					foreach ($row as $key => $value) {
						if ($value['addr'] != "") {
							$url = $value['addr'];
						}else{
							$url = "content2.php?id={$value['id']}&up_id={$value['up_id']}";
						}
				?>
				<li><a href="<?php echo $url; ?>" <?php if ($value['addr'] != '') echo "target='_blank'"?>><img src="uploads/<?php echo $value['img'] ?>" width='70px'>
				<br><span><?php echo $value['title']?></span>
				</a>
				</li>
				<?php 
					}
				?>
			</ul>
			<!-- 分页 -->
			<div class="page">
				<ul class="pagination pagination-sm">
					<?php 
						echo $page->fpage(0, 4, 5, 6);
					?>
				</ul>
			</div>
		</div>
	</div>
	</div>
	<?php include 'inc/footer.php';?>