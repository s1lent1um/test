<? /* @var News $news */ ?>
<!doctype html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8"/>
</head>
<body>

<div>
	<form action="" method="post">
		<input name="action" value="edit" type="hidden"/>
		<input type="text" name="title" id="title" value="<?=htmlspecialchars($news->title)?>"/>
		<br/>
		<textarea name="text" id="text" cols="30" rows="10"><?=htmlspecialchars($news->text)?></textarea>
		<br/>
		<input type="submit" value="submit"/>
		<input type="submit" name="delete" value="delete"/>
	</form>
</div>


</body>
</html>