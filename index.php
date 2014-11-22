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
		<div class="panel panel-primary">
			<div class="panel-heading">auto test</div>
			<div class="panel-body" id="testarea" style="height:300px;overflow-x:hidden;overflow-y:auto;">
			Panel content
			</div>
		</div>
    </div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script>
var newest_no = '';
$(document).ready(function()
{
	var cond = 1;
	var queryData = {newest_no:newest_no,
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
				$('#testarea').html(data['html']);
				newest_no = data['refresh_no'];
				alert(newest_no);
			}
			return false;
		}
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
				$('#testarea').prepend(data['html']);
				newest_no = data['refresh_no'];
			}
			return false;
		}
	});
}
</script>
</body> 
</html>