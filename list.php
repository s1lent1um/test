<? /* @var News[] $news */ ?>
<!doctype html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8"/>
</head>
<body>

<div>
	<form action="" method="post">
		<input name="action" value="add" type="hidden"/>
		<input type="text" name="title" id="title"/>
		<br/>
		<textarea name="text" id="text" cols="30" rows="10"></textarea>
		<input type="submit" value="submit"/>
	</form>
</div>


<? foreach($news as $n): ?>
	<div>
		<div class="title">
			<a href="?action=edit&id=<?=$n->id?>"><?=$n->title?></a>
		</div>
		<div class="date">
			<span class="date-created"><?=$n->date_created?></span>
			<span class="date-edited"><?=$n->date_edited?></span>
		</div>
		<p><?=$n->text?></p>
	</div>
<? endforeach; ?>
</body>
</html>