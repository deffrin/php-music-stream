<html>
<head>
	<title>Music App</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Raleway:200,300,400" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>

	<script type="text/javascript" src="js/jPlayer/dist/jplayer/jquery.jplayer.min.js"></script>
	<script type="text/javascript" src="js/jplayer/dist/add-on/jplayer.playlist.js"></script>
	<script type="text/javascript" src="js/jquery.form.js" ></script>
	<script type="text/javascript">
		base_url = '<?php echo base_url(); ?>index.php/';
	</script>
	<style type="text/css">
	.now-playing{
		display: none;
	}
	#upload_single_song{
		display: none;
	}
	.file-list{
		padding-bottom: 100px;
	}
	#upload_form{
		display: none;
	}
	</style>
</head>
<body>

<header>
<ul>
	<li class="logo"><small style="font-size:16px;">by</small><a href="">Appunitz</a></li>
	<li id="browse"><a href="">Home</a></li>
	<li id="playlist"><a href="">Playlist</a></li>

	
	<li id="upload_song" class="pull-right"><a href="">Upload Song</a></li>
	
</ul>
<form name="frm" id="upload_form"  method="POST" action="<?php echo site_url('welcome/upload') ?>" enctype="multipart/form-data">
	<input type="file" name="file" id="upload_click" />
	<input type="hidden" name="path" id="folder" />
</form>
</header>

<div class="container">
		
 <div id="jquery_jplayer"></div>
<h2>Browse</h2>
<div class="sub-nav"> 
	<span class="button">Back</span> 
</div>
	<div class="file-list">
		<?php echo $browse ?>
	</div>

</div>


<div class="now-playing">
	
		<div class="nav"  id="jp_container_1">
			<div class="prev"><i class="fa fa-step-backward"></i></div>
			<div class="play-control"><i id="play" class="fa fa-play"></i></div>
			<div class="next"><i class="fa fa-step-forward"></i></div>
			<div class="jp-playlist" style="display:none;">
				<ul>
					<li>&nbsp;</li>
				</ul>
			</div>

		</div>
		<div class="song-info">
		<div class="song-name">
			Nenjukkul peidhidum
		</div>

		<div class="seek-bar">
			<div class="seek-progress">

			</div>
		</div>


		</div>

		<div class="time">
			<span class="elapsed"> 1:24 </span> /
			<span class="total"> 4:30 </span>
		</div>

		<div class="volume">
			<i class="fa fa-volume-down"></i>
			<div class="bar">
				<div class="value">
				</div>
			</div>
		</div>

		
	
</div>
<script type="text/javascript">

Array.prototype.contains = function(obj) {
    var i = this.length;
    while (i--) {
        if (this[i].title === obj) {
            return (i+1);
        }
    }
    return false;
}


$(function(){


	    var myPlaylist = new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer",
		cssSelectorAncestor: ".now-playing"
          }, [
           // {
           //    title: 'Thee Illai',
           //    artist:'Harris Jayaraj',
           //    mp3:'http://localhost/my_projects/music/uploads/149820611402_Thee_Illai.mp3'
           // }           
          ], {
            playlistOptions: {
              enableRemoveControls: true
            },
            swfPath: "http://localhost/my_projects/music/assets/jplayer/dist/jplayer",
            supplied: "mp3",
            wmode: "window",
            useStateClassSkin: true,
            autoBlur: false,
            smoothPlayBar: true,
            keyEnabled: true,
            remainingDuration: true,
            toggleDuration: true,
			cssSelector: { // * denotes properties that should only be required when video media type required. _cssSelector() would require changes to enable splitting these into Audio and Video defaults.
				play: ".play-control",
				pause: ".jp-pause",
				stop: ".jp-stop",
				seekBar: ".seek-bar",
				playBar: ".seek-progress",
				mute: ".mute",
				unmute: ".un-mute",
				volumeBar: ".bar",
				volumeBarValue: ".value",
				//volumeMax: ".bar",
				playbackRateBar: ".jp-playback-rate-bar",
				playbackRateBarValue: ".jp-playback-rate-bar-value",
				currentTime: ".elapsed",
				duration: ".total",
				title: ".song-name",
				fullScreen: ".jp-full-screen", // *
				restoreScreen: ".jp-restore-screen", // *
				repeat: ".jp-repeat",
				repeatOff: ".jp-repeat-off",
				gui: ".jp-gui", // The interface used with autohide feature.
				noSolution: ".jp-no-solution" // For error feedback when jPlayer cannot find a solution.
			}
        });
		
		
		
		console.log(myPlaylist);
		folder=[];
		folder.push('songs');
	function open()
	{
		open_folder =folder.join("/");
		$.post(base_url+'open',{open:open_folder},function(resp){
			$('.file-list').html(resp);
		});
	}
	$(document).on('click','.open:not(.disabled)',function(){

			$('.open').addClass("disabled");
			folder_name = $(this).text().trim();
			folder.push(folder_name);
			
			open();
		
	});

	$('#browse').on('click',function(e){
		e.preventDefault();
		$('h2').html('Browse');
		$('.sub-nav span').show();
		delete folder;
		folder = [];
		folder.push('songs');

		open();
	});


	$('.button').on('click',function(){
		if(folder.length>1)
		{
		folder.pop();
		console.log(folder);
		open();
		}
	});	

	$.post(base_url+'welcome/get_playlist',function(resp){

		$.each(resp,function(i,value){
			 item = {
		              title: value.title,
		              mp3: value.mp3
		           };           

		           myPlaylist.add(item);
		           
		           $('.now-playing').show();
		});

	          	
		

	},'json');

	$(document).on('click','.play',function(){
		
		file = $(this).find('span').text();
		path = (folder.join("/"))+"/"+file;

		console.log(myPlaylist);
		 item = {
	              title: file,
	              mp3: path
	           };           
	           a = myPlaylist.playlist.contains(file);

	           
	           if(!$(this).hasClass("from-playlist"))
	           {
			console.log('1');
		 	if(a == false)
	           	{         	
	           		console.log('2');
	           	// if not contains
	           		myPlaylist.add(item);
	           		$.post(base_url+'welcome/add_to_play_list',{title:file, mp3:path },function(resp)
				{

				});	           	
		 	
			}

			if(a)
			{
				console.log('3');
				console.log('a');
				console.log('index '+a);
				myPlaylist.play(a-1);
			}
			else if(myPlaylist.playlist.length && a==false )
			{
				console.log('4');
				myPlaylist.play(myPlaylist.playlist.length-1);
			}
			else
			{
				console.log('5');
				myPlaylist.play();
			}
		}
		else
		{
			console.log('6');
			num = $(this).index();

			myPlaylist.current=num;
			//play at thisposition
			myPlaylist.play(myPlaylist.current);
		}
		
		console.log(myPlaylist);

		$('.now-playing').show();
	});	

	$(document).on('',function(e){
		alert("sdds");
	});

	$('body').keyup(function(e){
	   if(e.keyCode == 8){
	       // user has pressed backspace
	       $('.button').click();
	   }
	   if(e.keyCode == 32){
	       // user has pressed space
	       $('.play-control').click();
	   }
	});

	$('#playlist').on('click',function(e){

		e.preventDefault();
		$('h2').text("View Playlist");
		$('.button').hide();

		html  = "<ul>";
		
		$.each(myPlaylist.original,function(i, value){
			console.log(value);
			
			html += "<li class='play from-playlist'>" + value.title + "</li>";
		});

		html += "</ul>";
		$('.file-list').html(html);

	});

	$('#upload_song a').on('click',function(e){
		e.preventDefault();
	});


	$('#upload_song').on('click',function(){
					path = folder.join("/");
			console.log(path);
			
			$('#folder').val(path);	


		$('#upload_click').click();
	});
	$('form').ajaxForm({
		success:function(){
			alert('ss');
			open();
		}

	});

	$('#upload_click').on('change',function(){

		$('#upload_form').submit();
		
	});




});




</script>

</body>
</html>