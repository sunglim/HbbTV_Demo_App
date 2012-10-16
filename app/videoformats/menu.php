<?php
$ROOTDIR='..';
require("$ROOTDIR/base.php");
sendContentType();
openDocument();
?>
<style>
li{
	display:inline;
}
</style> 
<script type="text/javascript">
//<![CDATA[
var isVisible = true;
window.onload = function() {
  menuInit();
  menuSelect(0);
  registerKeyEventListener();
  initApp();
};
function handleKeyCode(kc) {
	if(kc==VK_RED) {
		toggleAppVisible();
		return true;
	}
	if(!isVisible){
		return false;
	}
	if (kc==VK_UP) {
    menuSelect(selected-1);
    return true;
  } else if (kc==VK_DOWN) {
    menuSelect(selected+1);
    return true;
  } else if (kc==VK_ENTER) {
    var liid = opts[selected].getAttribute('name');
    if (liid=='exit') {
      document.location.href = '../index.php';
    } else {
      runStep(liid);
    }
    return true;
  }
  return false;
}

function runStep(name){
	if(name=='dash_vod'){
		document.location.href = 'dash.php';
	}else if(name=='dash_live'){
		document.location.href = 'dash-live.php';
	};
};

function toggleAppVisible(){
	var curAppMgr = document.getElementById('appmgr').getOwnerApplication(document);
	if(isVisible){
		curAppMgr.hide();
		isVisible = false;
	}else{
		curAppMgr.show();
		isVisible = true;
	}
};

//]]>
</script>

</head>

<body>

<div style="left: 0px; top: 0px; width: 1280px; height: 720px; background-image: url('gradient+texture-1.jpg');" />

<?php echo appmgrObject(); ?>

<ul id="menu" class="menu" style="left: 250px; top: 120px;width:300px">
	<li name='dash_live' style="display:inline;margin:30px;" onclick="runStep('dash_live');"><img src="dashlive.gif" style="width:500px" onclick="runStep('dash_live');"/></li>
	<li name='dash_vod' style="display:inline;margin:30px;" onclick="runStep('dash_vod');"><img src="dashvod.gif" style="width:500px" onclick="runStep('dash_vod');"/></li>
</ul>
</body>
</html>