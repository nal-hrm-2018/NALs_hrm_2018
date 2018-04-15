<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
		}
		html, body, .container{
			height: 100%;
		}
		body{
			font-family: verdana;
			font-size: 10px;
		}
		.container{
			background: #f6f6f6;
		}
		.context-menu{
			width: 200px;
			height: auto;
			box-shadow: 0 0 20px 0 #ccc;
			position: absolute;
			display: none;
		}
		.context-menu ul{
			list-style: none;
			padding: 5px 0px 5px 0px;
		}
		.context-menu ul li{
			padding: 10px 5px 10px 5px;
			border-left: 4px solid transparent;
			cursor: pointer;
		}
		.context-menu ul li:hover{
			background: #eee;
			border-left: 4px solid;
		}
		
	</style>
</head>
<body>
	<div class="container" oncontextmenu="return showContextMenu(event);">
		<div id="contextMenu" class="context-menu">
			<ul>
				<li>View</li>
				<li>Edit</li>
				<li>Export</li>
				<li>Remove</li>
				<li>CV</li>
			</ul>
		</div>
	</div>
	
	<script type="text/javascript">
		window.onclick = hideContextMenu;
		var contextMenu = document.getElementById('contextMenu');
		function showContextMenu(event){
			contextMenu.style.display = 'block';
			contextMenu.style.left = event.clientX + 'px';
			contextMenu.style.top = event.clientY + 'px';
			return false;
		}
		function hideContextMenu(){
			contextMenu.style.display = 'none';
		}
		function listenKeys(event){
			var keyCode = event.which || event.keyCode;
			if(keyCode == 27){
				hideContextMenu();
			}
		}
	</script>
</body>
</html>