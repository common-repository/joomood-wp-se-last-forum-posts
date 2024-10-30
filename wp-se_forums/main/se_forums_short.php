<?php

// ----------------------------------------------------------------------------------------------------------------------------------------------------------
//					JOOMOOD START PLAYING
// ----------------------------------------------------------------------------------------------------------------------------------------------------------

// SHOW LAST SE X FORUM POSTS

    include(ABSPATH.'wp-content/plugins/giggi_functions/giggi_database.php');
    require_once(ABSPATH.'wp-content/plugins/giggi_functions/giggi_functions.php');

	$here=$_SERVER['REQUEST_URI'];


// Check some data...

if($nametype=="1" OR $nametype=="2") {
$nametypez=$nametype;
} else {
$nametypez="2";
}

		// See if there are only particular forum/category to show

		$categorid=$catid;
		
		// Show the User choice

		if(isset($_POST['theF']) && $user_can_choose !=="no") { 
		$theforum=$_POST['theF'];	
		$forumid=$theforum;	
		} else {
		$theforum="";
		$forumid=$forumid;
		}

		if(isset($_POST['theC']) && $user_can_choose !=="no") { 
		$thecategory=$_POST['theC'];	
		$categorid=$thecategory;	
		} else {
		$thecategory="";
		$categorid=$categorid;
		}

		
		// Show all posts
		
		if($forumid =="" && $categorid=="") {
		$clause="";
		$casetext="Browsing ALL the Forum posts";
		}
		
		// Show all posts from forum(s)
		
		else if($forumid !=="" && $categorid=="") {
		$clause="AND b.instance_id='".$forumid."'";
		$casetext="Browsing ONLY the posts of Forum ".$forumid;
		}

		// Show all posts from category(ies)

		else if($forumid =="" && $categorid==!"") {
		$clause="AND b.id IN (".$categorid.")";
		$casetext="Browsing ONLY the posts of the Category ".$categorid;
		}

		// Show all posts from forum(s) and category(ies)

		else {
		$clause="AND b.instance_id IN (".$forumid.") AND b.id IN ('".$categorid."')";
		$casetext="Browsing ONLY the posts of the Category ".$categorid." of the Forum ".$forumid;
		}



		// Check for hidden description
		
		$hiddesc=strtolower($hide_desc);
		if($hiddesc=="yes") {
		$hide_desc="yes";
		} else {
		$hide_desc="no";
		}

		// Check the group description cut-off point
		
        if (!$cut_off=="") {
        $cut="1";
        } else {
        $cut="0";  // vuol dire che l'utente non ha inserito un numero!
        }

		// Check for Splitted Stats
		
		$split_stat=strtolower($split_stat);
		if($split_stat=="yes") {
		$split="1";
		} else {
		$split="0";
		}
		
		// Check if Stats are Showed
		
		$show_stat=strtolower($show_stat);
		if($show_stat=="yes") {
		$shows="1";
		} else {
		$shows="0";
		}
		
		// Check personal width & height...

        if (preg_match ("/^([0-9.,-]+)$/", $pic_dim_width)) {
        $my_w="1";
        } else {
        $my_w="0";  // vuol dire che l'utente non ha inserito un numero!
        }
        if (preg_match ("/^([0-9.,-]+)$/", $pic_dim_height)) {
        $my_h="1";
        } else {
        $my_h="0";  // vuol dire che l'utente non ha inserito un numero!
        }

        if($pic_dim_width=="0" OR $pic_dim_height=="0" OR $pic_dim_width=="" OR $pic_dim_height=="" OR $my_w=="0" OR $my_h=="0") {
        $pic_dimensions="0";
        } else {
        $pic_dimensions="1";
        }

        if($pic_dimensions =="1") {
		
		$mywidth=$pic_dim_width;
		$myheight=$pic_dim_height;
		
		} else {
		$mywidth="60";
		$myheight="60";
		
		}

		// Check Num of Groups...

		if($numOfGroup<0) {
		$numOfGroup=1;
		}

		if($how_many_groups>$numOfGroup) {
		$how_many_groups=$numOfGroup;
		}
		
// ---------------------------------------------------------

		// Check Main Box border style
		
		if ($mainbox_border_style=="0" OR $mainbox_border_style=="1" OR $mainbox_border_style=="2") {
		$mainbox_border_res="1";
		} else {
		$mainbox_border_res="0";
		}

		// Check Main Box border color
		
		if ($mainbox_border_color!=='') {
		$mainbox_bordercol_res="1";
		} else {
		$mainbox_bordercol_res="0";
		}

		// Substitute empty or wrong fields
		
		if ($mainbox_border_res=="0") {
		$mainboxbord="0px solid";
		} 
		
		if ($mainbox_border_style=="1") {
		$mainboxbord="{$mainbox_border_dim}px dotted";
		} 
		
		if ($mainbox_border_style=="2") {
		$mainboxbord="{$mainbox_border_dim}px solid";
		} 
		

		if ($mainbox_bordercol_res=="0") {
		$mainboxbordcol="#ffffff";
		} else {
		$mainboxbordcol=$mainbox_border_color;
		}
		
		$mainboxbgcol=$mainbox_bg_color;

		$mbx=$mainbox_width;
		
		if($mainbox_width=="" || $mainbox_width=="%") {
		$mainbox_width="100";
		}

		$mainbox_width=$mainbox_width."%";


// ---------------------------------------------------------

		
		// Check Inner Box border style
		
		if ($box_border_style=="0" OR $box_border_style=="1" OR $box_border_style=="2") {
		$box_border_res="1";
		} else {
		$box_border_res="0";
		}

		// Check box border color
		
		if ($box_border_color!=='') {
		$box_bordercol_res="1";
		} else {
		$box_bordercol_res="0";
		}
		
		
		// Substitute empty or wrong fields
		
		if ($box_border_res=="0") {
		$boxbord="0px solid";
		} 
		
		if ($box_border_style=="1") {
		$boxbord="{$box_border_dim}px dotted";
		} 
		
		if ($box_border_style=="2") {
		$boxbord="{$box_border_dim}px solid";
		} 
		

		if ($box_bordercol_res=="0") {
		$boxbordcol="#ffffff";
		} else {
		$boxbordcol=$box_border_color;
		}
		
		$boxbgcol=$box_bg_color;
		$boxbgcol1=$box_bg_color1;
		

		// Build Full Style Variables
		
		$mystyle="style=\"border:".$boxbord." ".$boxbordcol."; background-color: ".$boxbgcol.";\"";
		$mystyle0="style=\"border:".$boxbord." ".$boxbordcol."; background-color: ".$boxbgcol.";\"";
		$mystyle1="style=\"border:".$boxbord." ".$boxbordcol."; background-color: ".$boxbgcol1.";\"";
		$mymainstyle="style=\"border:".$mainboxbord." ".$mainboxbordcol."; background-color: ".$mainboxbgcol.";\"";
		$titlestyle="padding: 0px 2px 2px 0px; border-bottom: 1px solid #CCCCCC; margin-bottom: 4px;";
		$bodystyle="margin-bottom: 0px;";
		$statstyle="font-size: 7pt; color: #777777; font-weight: normal;";



		



// ----------------------------------------------------------------------------------------------------------------------------------------------------------
//					LET'S START QUERY TO RETRIEVE OUR DATA
// ----------------------------------------------------------------------------------------------------------------------------------------------------------


$query="SELECT a.*, c.user_photo as PHOTO, b.title as titleX 
FROM se_forum_posts a LEFT JOIN se_users c ON (a.cache_last_post_user_id=c.user_id)
JOIN se_forum_categories b ON (a.category_id=b.id) 
WHERE a.title<>'' {$clause}
ORDER by a.cache_last_post_created DESC LIMIT ".$numOfGroup."";

$result = mysql_query($query);

$i = 0;
$kk=0;
$zz=0;
$gg=0;

while($row = mysql_fetch_array($result, MYSQL_ASSOC))

{
	
$miovalorea=strtotime($row['created']);
$miovaloreb=strtotime($row['cache_last_post_created']);

$miovalore= giggitime2($miovalorea, $num_times=1).' ago';
$miovalore1= giggitime2($miovaloreb, $num_times=1).' ago';


// Choose a name...

if ($nametypez=="2") {
$mynome=$row['cache_last_post_display_name'];
$mynome2=$row['cache_display_name'];
} else {
$mynome=$row['cache_last_post_user_name'];
$mynome2=$row['cache_user_name'];
}


// Cut a little bit the post title...

$mydesc = $row['title'];

if($cut=="0" OR $cut_off=="0" OR $cut_off=="") {
$shortdesc=$mydesc;
} else {
$shortdesc = substr($mydesc,0,$cut_off)."...";
}




$mydir=$wpdir."/wp-content/plugins/wp-se_forums";
$subdir = $row['cache_last_post_user_id']+999-(($row['cache_last_post_user_id']-1)%1000);

if($use_resize !=="no") { // RESIZING SCRIPT

if ($row['PHOTO']!='') {
// Creates a thumbnail based on your personal dims (width/height), without stretching the original pic
$mypic="<img src=\"{$mydir}/image.php/{$row['PHOTO']}?width={$mywidth}&amp;height={$myheight}&amp;cropratio=1:1&amp;quality=100&amp;image={$socialdir}/uploads_user/{$subdir}/{$row['cache_last_post_user_id']}/{$row['PHOTO']}\" style=\"border:".$image_border."px solid ".$image_bordercolor."\" alt=\"".$mynome."\" />";
} else {
$mypic="<img src=\"{$mydir}/image.php/nophoto.gif?width={$mywidth}&amp;height={$myheight}&amp;cropratio=1:1&amp;quality=100&amp;image={$socialdir}/{$empty_image_url}\" style=\"border:".$image_border."px ".$image_bordercolor." solid\" alt=\"".$mynome."\" />";
}

} else { // NO RESIZING SCRIPT

if ($row['PHOTO']!='') {
// Creates a thumbnail based on your personal dims (width/height)
$myp=str_replace(".", "_thumb.", $row['PHOTO']);
$mypfile=$socialdir."/uploads_user/{$subdir}/{$row['cache_last_post_user_id']}/{$myp}";

if (@fopen($mypfile, "r")) {
$myps=str_replace(".", "_thumb.", $row['PHOTO']);
$mypfile=$socialdir."/uploads_user/{$subdir}/{$row['cache_last_post_user_id']}/{$myps}";
} else {
$mypfile=$socialdir."/uploads_user/{$subdir}/{$row['cache_last_post_user_id']}/{$row['PHOTO']}";
}

$mypic="<img src=\"{$mypfile}\" width=\"{$mywidth}\" height=\"{$myheight}\" style=\"border:".$image_border."px solid ".$image_bordercolor."\" alt=\"".$myn."\" />";
} else {
$mypic="<img src=\"{$socialdir}/{$empty_image_url}\" width=\"{$mywidth}\" height=\"{$myheight}\" style=\"border:".$image_border."px ".$image_bordercolor." solid\" alt=\"".$myn."\" />";
}

}


// Create a link to the post

$mylink="<a href=\"".$socialdir."/forum.php?iid={$row['instance_id']}&amp;c=topic&amp;op=index&amp;cid={$row['category_id']}&amp;tid={$row['id']}&page=LP#{$row['cache_last_post_id']}\" title=\"".$go_profile_text1." {$row['title']}\">";
$mylink2="<a href=\"".$socialdir."/forum.php?iid={$row['instance_id']}&amp;c=category&amp;op=index&amp;cid={$row['category_id']}\" title=\"".$go_profile_text2." {$row['titleX']}\">";


// Create a link to the group leader

$mylink1="<a href=\"".$socialdir."/profile.php?user=".$row['cache_last_post_user_name']."\" title=\"{$go_profile_text} {$mynome}\">";
$mylink3="<a href=\"".$socialdir."/profile.php?user=".$row['cache_user_name']."\" title=\"{$go_profile_text} {$mynome2}\">";


// Alternate Posts

if ($i%2 !==0) {
$mystyle=$mystyle1;
} else {
$mystyle=$mystyle0;
}


// If no-post/post

if($mynome=="") {
$right_text="No Post";
$mylink="<a href=\"".$socialdir."/forum.php?iid={$row['instance_id']}&amp;c=topic&amp;op=index&amp;cid={$row['category_id']}&amp;tid={$row['id']}\" title=\"".$go_profile_text1." {$row['title']}\">";
$mylink1="";
$btext="";
} else {
$btext="</a>";
$right_text="Last post by {$mylink1}{$mynome}</a><br />About {$miovalore1}";
}


// Rank of posts

$stellegrigie=5-($row['cache_rating']+1);

if($i<$how_many_groups) {

$rows .= "
<td align=\"left\" valign=\"top\">
<table width=\"100%\" cellspacing=\"{$inner_cellspacing}\" cellpadding=\"{$inner_cellpadding}\" ".$mystyle.">
<tr>
<td width=\"{$mywidth}\" align=\"left\" valign=\"top\">{$mylink1}{$mypic}{$btext}</td>
<td align=\"left\"><div style=\"{$titlestyle}\">{$mylink}{$shortdesc}</a><br />";

for ($kk = 1; $kk <= $row['cache_rating']+1; $kk++) {
$rows .="<img src=\"{$socialdir}/images/forum/rating_small.gif\" width=\"8\" height=\"8\" alt=\"\" />";
}

if ($stellegrigie !==5) {
for ($zz = 1; $zz <= $stellegrigie; $zz++) {
$rows .="<img src=\"{$socialdir}/images/forum/rating_blank_small.gif\" width=\"8\" height=\"8\" alt=\"\" />";
}
}

$rows .="</div>{$right_text}</td>
</tr>
</table>
</td>
";

} else {

$rows .= "
</tr><tr><td align=\"left\" valign=\"top\">
<table width=\"100%\" cellspacing=\"{$inner_cellspacing}\" cellpadding=\"{$inner_cellpadding}\" ".$mystyle.">
<tr>
<td width=\"{$mywidth}\" align=\"left\" valign=\"top\">{$mylink1}{$mypic}{$btext}</td>
<td align=\"left\"><div style=\"{$titlestyle}\">{$mylink}{$shortdesc}</a><br />";

for ($kk = 1; $kk <= $row['cache_rating']+1; $kk++) {
$rows .="<img src=\"{$socialdir}/images/forum/rating_small.gif\" width=\"8\" height=\"8\" alt=\"\" />";
}

if ($stellegrigie !==5) {
for ($zz = 1; $zz <= $stellegrigie; $zz++) {
$rows .="<img src=\"{$socialdir}/images/forum/rating_blank_small.gif\" width=\"8\" height=\"8\" alt=\"\" />";
}
}

$rows .="</div>{$right_text}</td>
</tr>
</table>
</td>
";

}

$i++;
$gg++;

}

if($gg<1) {
$end_message="(There's nothing to see...)";
} else {
$end_message="(".$gg." posts so far...)";
}


$content .="<table width=\"{$mainbox_width}\" cellspacing=\"{$outer_cellspacing}\" cellpadding=\"{$outer_cellpadding}\" {$mymainstyle}><tr>";
$content .="{$rows}";
$content .="</tr></table>";

$content .=" <table width=\"{$mainbox_width}\" cellspacing=\"{$outer_cellspacing}\" cellpadding=\"{$outer_cellpadding}\" bgcolor=\"{$mainbox_bg_color}\">
			 <tr>
			 <td align=\"left\" valign=\"top\">
			 
			 <table width=\"100%\" cellspacing=\"{$inner_cellspacing}\" cellpadding=\"{$inner_cellpadding}\" ".$mystyle.">
			 <tr>
			 <td align=\"center\" style=\"{$statstyle}\">{$casetext} {$end_message}</td>
			 </tr>
			 </table>
			 
			 </td>
			 </tr>
			 </table>";
//}



if($user_can_choose=="yes") {

$halftable=floor($mbx/2);

$content .="
<table width=\"{$mainbox_width}\" cellspacing=\"{$outer_cellspacing}\" cellpadding=\"{$outer_cellpadding}\" {$mymainstyle}>
<form action=\"{$here}\" method=\"post\">
  <tr>
    <td width=\"{$halftable}%\" align=\"right\">
      <select name=\"theF\" id=\"theF\">
	<option value=\"\" selected>Forum Selector</option>";

$query3="SELECT id, name FROM se_forum_instances ORDER by created ASC";
$result3 = mysql_query($query3);
while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC))
{
$content .="
<option value=\"{$row3['id']}\">{$row3['id']}: {$row3['name']}</option>";
}


$content .="
      </select></td>
      <td width=\"{$halftable}%\" align=\"left\">
      <select name=\"theC\" id=\"theC\">
	<option value=\"\" selected>Category Selector</option>";

$query2="SELECT id, title FROM se_forum_categories WHERE parent_id<>'NULL' ORDER by created ASC";
$result2 = mysql_query($query2);
while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
{
$content .="
<option value=\"{$row2['id']}\">{$row2['id']}: {$row2['title']}</option>";
}

$content .="      
      </select>
    </td>
   </tr>
   </table>
<table width=\"{$mainbox_width}\" cellspacing=\"{$outer_cellspacing}\" cellpadding=\"{$outer_cellpadding}\" {$mymainstyle}>
  <tr>
    <td align=\"center\"><label>
      <input type=\"submit\" name=\"button\" id=\"button\" value=\"Send\" />
    </label></td>
    </tr>
  </form>
</table>";

}

echo $content;


// ----------------------------------------------------------------------------------------------------------------------------------------------------------
//					END OF JOOMOOD FUNNY TOY
// ----------------------------------------------------------------------------------------------------------------------------------------------------------

?>