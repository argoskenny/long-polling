<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
	<title>auto test</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
</head>

<body ontouchstart="">
	<div class="container">
		<br><br><br>
		<form role="form" >
			<div class="form-group">
				<label for="title">標題</label>
				<input type="text" class="form-control" id="title" placeholder="標題">
			</div>
			<div class="form-group">
				<label for="content">內容</label>
				<textarea class="form-control" id="content" ></textarea>
			</div>
			<button type="button" class="btn btn-default" id="content_submit">送出</button>
		</form>
		<br><br><br>
		<div class="panel panel-primary">
			<div class="panel-heading">聊天室</div>
			<div class="panel-body" id="testarea" style="height:300px;overflow-x:hidden;overflow-y:auto;">
			</div>
		</div>
    </div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script>
var newest_no = '';
$(document).ready(function()
{
	var queryData = {newest_no:newest_no,
					cond:1};
	$.ajax({
		type: "POST",
		url: 'auto_ajax.php',
		data: queryData,
		dataType: 'json',
		success: function(data)
		{
			if( data['status'] == 'success' )
			{
				$('#testarea').html(data['html']);
				newest_no = data['refresh_no'];
			}
			return false;
		}
	});

	$('#content_submit').click(function(){
		var title = $('#title').val();
		var content = $('#content').val();
		var cond = 3;
		if (title == '' || content == '') {
			alert('請輸入標題及內容');
			return false;
		};

		var queryData = {title:title,
						content:content,
						cond:cond,
						newest_no:newest_no};
		$.ajax({
			type: "POST",
			url: 'auto_ajax.php',
			data: queryData,
			dataType: 'json',
			success: function(data)
			{
				if( data['status'] == 'success' )
				{
					if (data['html'] != '')
					{
						$('#testarea').html(data['html']);
					};

					$('#title').val('');
					$('#content').val('');
				}
				return false;
			}
		});
	});

	setInterval("get_data()",5000);
});

function get_data()
{
	var cond = 2;
	var second_no = newest_no;
	var queryData = {newest_no:second_no,
					cond:cond};
	$.ajax({
		type: "POST",
		url: 'auto_ajax.php',
		data: queryData,
		dataType: 'json',
		success: function(data)
		{
			if( data['status'] == 'success' )
			{
				if (data['html'] != '')
				{
					$('#testarea').html(data['html']);
				};
			}
			return false;
		}
	});
}
</script>
</body> 
</html>