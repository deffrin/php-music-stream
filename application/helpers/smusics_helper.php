<?php


function listFolderFiles($dir){
		    $ffs = scandir($dir);

		    unset($ffs[array_search('.', $ffs, true)]);
		    unset($ffs[array_search('..', $ffs, true)]);

		    // prevent empty ordered elements
		    if (count($ffs) < 1)
		        return;

		    //echo '<ol>';
		    foreach($ffs as $ff){
		        echo '<li>'.$dir.'/'.$ff;
		        //$ci =& get_instance();

		    	//$ci->db->insert('songs',array( 'file' => $dir."/".$ff ) );
		        if(is_dir($dir.'/'.$ff)){
		        	listFolderFiles($dir.'/'.$ff);
		       // 	$current_directory = $dir.'/'.$ff;
		        } 
		        echo '</li>';
		    }
		   // echo '</ol>';
		}


function browse($folder)
{
	$folder_items = scandir($folder);
	$i = 1;
	$html="<ul>";
	foreach ($folder_items as $key => $item) {
		
		if($item!="." && $item!=".." )
		{	
			if( is_dir($folder."/".$item) )
				$html.= "<li class='open'><i class='fa fa-folder'></i> ".$item."</li>";
			else {
				$pathinfo = pathinfo($item);
				if( $pathinfo['extension'] == 'mp3' ) 
				{
					$html.= "<li class='play'>#$i <span>".$item."</span></li>";
					$i++;
				}
			}
				
			
		}
		
	}
	$html.="</ul>";
	return $html;
	//print_r($folder);
}