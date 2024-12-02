<!DOCTYPE html>
<html lang="ja">

<head>
	<!-- meta tag -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="このサイトはibitの個人サイトです。" />
	<link rel="canonical" href="ibit.dev" />
	<link rel="shortcut icon" href="faviconのURL" />

	<!-- OGP tag -->
	<!-- <meta property="og:url" content="ページのURL" />
	<meta property="og:type" content="ページの種類" />
	<meta property="og:title" content="ページのタイトル" />
	<meta property="og:description" content="ページの説明文" />
	<meta property="og:site_name" content="サイト名" />
	<meta property="og:image" content="サムネイル画像のURL" /> -->

	<!-- title -->
	<title>ibit</title>

	<!-- resource -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

	<!-- カスタムスタイル -->
	<style>
		div#main {
			padding: 30px;
			background-color: #efefef;
		}
	</style>

	<!-- 外部スタイルシート -->
	<link rel="stylesheet" type="text/css" href="css/4-1-3.css">
</head>


<body>
<!-- ロゴアニメーション -->
<div id="splash">
<div id="splash_text"></div>
<div class="loader_cover loader_cover-up"></div><!--上に上がるエリア-->
<div class="loader_cover loader_cover-down"></div><!--下に下がるエリア-->
<!--/splash--></div>
<div id="container">
<p>Hello World</p>
<!--/container--></div>
<!-- ロゴアニメーション -->
	
	<div class="container">
		<div id="main">
			<?php																		
			// データベースに接続する
			$pdo = new PDO("mysql:host=127.0.0.1;dbname=kagiko_db;charset=utf8", "kagiko_db", "Tsota1025");
			// print_r($_POST);

			// 受け取ったidのレコードの削除
			if (isset($_POST["delete_id"])) {
				$delete_id = $_POST["delete_id"];
				$sql  = "DELETE FROM bbs WHERE id = :delete_id;";
				$stmt = $pdo->prepare($sql);
				$stmt -> bindValue(":delete_id", $delete_id, PDO::PARAM_INT);
				$stmt -> execute();
			}

			// 受け取ったデータを書き込む
			if (isset($_POST["content"]) && isset($_POST["user_name"])) {
				$content   = $_POST["content"];
				$user_name = $_POST["user_name"];
				$sql  = "INSERT INTO bbs (content, user_name, updated_at) VALUES (:content, :user_name, NOW());";
				$stmt = $pdo->prepare($sql);
				$stmt -> bindValue(":content", $content, PDO::PARAM_STR);
				$stmt -> bindValue(":user_name", $user_name, PDO::PARAM_STR);
				$stmt -> execute();
			} ?>

			<h1>paiza掲示板</h1>

			<h2>投稿フォーム</h2>
			<form class="form" action="index.php" method="post">
				<div class="form-group">
					<label class="control-label">投稿内容</label>
					<input class="form-control" type="text" name="content">
				</div>
				<div class="form-group">
					<label class="control-label">投稿者</label>
					<input class="form-control" type="text" name="user_name">
				</div>
				<button class="btn btn-primary" type="submit">送信</button>
			</form>

			<h2>発言リスト</h2>
			<?php
			// データベースからデータを取得する
			$sql = "SELECT * FROM bbs ORDER BY updated_at;";
			$stmt = $pdo->prepare($sql);
			$stmt -> execute();
			?>
			<table class="table table-striped">
				<tr>
					<th>id</th>
					<th>日時</th>
					<th>投稿内容</th>
					<th>投稿者</th>
					<th></th>
				</tr>
				<?php
				// 取得したデータを表示する
				while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { ?>
					<tr>
						<td><?= $row["id"] ?></td>
						<td><?= $row["updated_at"] ?></td>
						<td><?= $row["content"] ?></td>
						<td><?= $row["user_name"] ?></td>
						<td>
							<form action="index.php" method="post">
								<input type="hidden" name="delete_id" value=<?= $row["id"] ?>>
								<button class="btn btn-danger" type="submit">削除</button>
							</form>
						</td>
					</tr>
				<?php } ?>
			</table>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://rawgit.com/kimmobrunfeldt/progressbar.js/master/dist/progressbar.min.js"></script>
	<!--IE11用※対応しなければ削除してください-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script><!--不必要なら削除-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/6.26.0/polyfill.min.js"></script><!--不必要なら削除-->
	<!--自作のJS-->
	<script src="js/4-1-3.js"></script>
</body>

</html>