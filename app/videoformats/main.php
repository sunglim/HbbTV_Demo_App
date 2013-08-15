<?php
ob_start();
$ROOTDIR='..';
require("$ROOTDIR/base.php");
sendContentType();
openDocument();
?>
<script type="text/javascript">
//<![CDATA[
var req = false;

window.onload = function() {
  registerKeyEventListener();
  initApp();
};
function handleKeyCode(kc) {
  if (kc==VK_RED) {	
	document.location.href = './menu.html';
    return true;
  }
  return false;
};

//]]>
</script>

</head>

<body>
<?php echo appmgrObject(); ?>
<div style="left: 0px; top: 0px; width: 1280px; height: 720px;">
	<img src="redbutton.gif" style="right:40px;bottom:20px;position:absolute;width:200px"/>
</div>

</body>
</html>
