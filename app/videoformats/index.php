<?php
$ROOTDIR='..';
require("$ROOTDIR/base.php");
sendContentType();
openDocument();
?>
	 
<script type="text/javascript">
//<![CDATA[
var req = false;

window.onload = function() {
  menuInit();
  registerKeyEventListener();
  initApp();
  setInstr('Please play all audios / videos. Navigate using up/down, then press OK to start the test.');
};
function handleKeyCode(kc) {
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
function runStep(name) {
  setInstr('Retrieving URL...');
  showStatus(true, '');
  if (req) {
    req.abort();
  }
  stopVideo();
  if (name=='queue') {
    try {
      playVideo('video/mp4', 'http://itv.ard.de/video/trailer.php', false);
      var videlem = document.getElementById('video');
      videlem.queue('http://bilder.rtl.de/tt_hd/trailer_hotelinspektor.mp4');
      videlem.queue(null); // remove previous element from queue
      videlem.queue('http://bilder.rtl.de/tt_hd/090902_hdtt_f1_monza_streckenanimation_.mp4');
      showStatus(true, 'First Das Erste trailer should be played, followed by a queued formula 1 video clip. An Hotelinspektor trailer should not be played.');
    } catch (e) {
      showStatus(false, 'Queuing video failed.');
    }
    return;
  }
  req = new XMLHttpRequest();
  req.onreadystatechange = function() {
    if (req.readyState!=4 || req.status!=200) return;
    var s = req.responseText.split('#');
    playVideo(s[0], s[1], true);
    req.onreadystatechange = null;
    req = null;
  };
  req.open('GET', 'videourl.php?id='+name);
  req.send(null);
}
function stopVideo() {
  var elem = document.getElementById('vidcontainer');
  var oldvid = document.getElementById('video');
  if (oldvid) {
    oldvid.onPlayStateChange = null;
    try {
      oldvid.stop();
    } catch (e) {
      // ignore
    }
    try {
      oldvid.release();
    } catch (e) {
      // ignore
    }
  }
  elem.innerHTML = '';
}
function playVideo(mtype, murl, registerlistener) {
  setInstr('Playing '+murl+' ('+mtype+')...');
  var elem = document.getElementById('vidcontainer');
  var ihtml = '<object id="video" type="'+mtype+'" style="position: absolute; left: 700px; top: 180px; width: 520px; height: 310px;"><'+'/object>';
  elem.innerHTML = ihtml;
  try {
    var videlem = document.getElementById('video');
    if (registerlistener) {
      videlem.onPlayStateChange = function() {
        if (1==videlem.playState) {
          videlem.onPlayStateChange = null;
          showStatus(true, mtype+' and \n' + murl + '\n should be playing now.');
        } else if (6==videlem.playState) {
          videlem.onPlayStateChange = null;
          showStatus(false, mtype+' playback failed (error event).');
        }
      };
    }
    videlem.data = murl;
    videlem.play(1);
  } catch (e) {
    showStatus(false, 'Setting the video object '+mtype+' failed.');
  }
  
}

//]]>
</script>

</head><body>

<div style="left: 0px; top: 0px; width: 1280px; height: 720px; background-color: #132d48;" />

<div id="vidcontainer" style="left: 0px; top: 0px; width: 1280px; height: 720px;"></div>
<?php echo appmgrObject(); ?>

<div class="txtdiv txtlg" style="left: 110px; top: 60px; height: 30px;"><a href="../addurl/setup.php">Insert URL(http://10.177.41.56/HbbTV-Testsuite/addurl/setup.php)</a></div>
<div id="instr" class="txtdiv" style="left: 700px; top: 110px; width: 400px; height: 360px;"></div>
<ul id="menu" class="menu" style="left: 100px; top: 100px;">
 <? 
     $link = mysql_connect("localhost", "readonly", "abcd1234")  
          or die("Could not connect<br>");
 
 $select = mysql_select_db ("media_framework"); 

 if (!$select) {
    die('Not connected : ' . mysql_error());
	}

	$query = "select * from media_main"; 
     $result = mysql_query($query); 
     if (!$result) { 
          echo "error query"; 
          exit; 
     } 
      
     $rows  = mysql_num_rows($result); 

     $i = 0; 

     while ($i<$rows) { 
          $row = mysql_fetch_row($result);
		echo "<li name=\"".$row[0]."\">".$row[3]."</li>";
		$i++;
     } 
	     mysql_close($link); 

     ?> 
  
</ul>
<div id="status" style="left: 700px; top: 480px; width: 400px; height: 200px;"></div>
</body>
</html>
