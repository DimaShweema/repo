<!DOCTYPE html>
<html>
<head>
<script src="jquery.js"></script>

<link rel="stylesheet" type="text/css" href="style.css">
 
 
 
 

</head>

<body>

<div id="wrap">

<div id="header">
	<div id="logo">
	<a class="logoText" href="#"> Dima's Photography </a>
	</div>
		<div id="menu">
<?php


$con = mysql_connect("localhost","dimashweema","velliforge");
 if (!$con)
   {
   die('Could not connect: ' . mysql_error());
   }
 $db_selected = mysql_select_db('dimashweema', $con);
if (!$db_selected) {
    die ('Can\'t use dimashweema : ' . mysql_error());
}

// Select all entries from the menu table
$result=mysql_query("SELECT id, label, link, parent FROM menu ORDER BY id");
// Create a multidimensional array to conatin a list of items and parents
$menu = array(
    'items' => array(),
    'parents' => array()
);
if ($result) {

// Builds the array lists with data from the menu table
while ($items = mysql_fetch_assoc($result))
{
    // Creates entry into items array with current menu item id ie. $menu['items'][1]
    $menu['items'][$items['id']] = $items;
    // Creates entry into parents array. Parents array contains a list of all items with children
    $menu['parents'][$items['parent']][] = $items['id'];
}

}
else {
die(mysql_error());
}



// Menu builder function, parentId 0 is the root
function buildMenu($parent, $menu)
{
 $folderid =  substr($menu['items'][$itemId]['link'], 1);
 

   $html = "";
   if (isset($menu['parents'][$parent]))
   {
      $html .= "
      <ul class='menu'>\n";
       foreach ($menu['parents'][$parent] as $itemId)
       {
          if(!isset($menu['parents'][$itemId]))
          {
             $html .= "<li>\n  <a class='menuItem' onclick='returnimages(".$folderid.")' href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a>\n</li> \n";
          }
          if(isset($menu['parents'][$itemId]))
          {
             $html .= "
             <li>\n  <a class='menuItem' onclick='returnimages(".$folderid.")' href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a> \n";
             $html .= buildMenu($itemId, $menu);
             $html .= "</li> \n";
          }
       }
       $html .= "</ul> \n";
   }
   return $html; 
}
echo buildMenu(0, $menu);







function returnimages($folder) {
$dirname="photos/". $folder. "/" ;
$ext="(\.jpg$)|(\.png$)|(\.jpeg$)|(\.gif$)"; //valid image extensions
$files = array();
$curimage=0;
if($handle = opendir($dirname)) {
while(false !== ($file = readdir($handle))){
if(eregi($ext, $file)){ //if this file is a valid image
//Output it as a JavaScript array element
echo '<script>galleryarray['.$curimage.']="'.$file .'";</script>';
$curimage++;
}
}

closedir($handle);
}
return($files);
}

echo '<script>var galleryarray=new Array();</script>'; //Define array in JavaScript
returnimages(); //Output the array elements containing the image file names

echo '<script>loadImages();</script>';




?>
</div>





</div>

<div id="main">
</div>
</div>






<script src="getimages.php"></script>

<script>




function loadImages(){
		
 
		i=0;
		while (i<galleryarray.length)
		{
			$("#main").html("<img src=" + galleryarray[i] + ">   </img>");
		
		i++;
		}
		
		
}




function openBody() {

	$("#wrap").animate({
		top:'0px',
		marginTop:'0px',
		height:'100%'
	}, "slow");
	
	
	$("#main").animate({
		height:'70%'
	}, "slow");
	
};


function closeBody() {

	$("#wrap").animate({
		top:'35%',
		marginTop:'-75px',
		height:'150px'
	}, "slow");
	
	
	$("#main").animate({
		height:'0%'
	}, "slow");
	
};




$("a.menuItem").click(function(){
	
	openBody();
	
});
	
	
$("a.logoText").click(function(){
	
	closeBody();
	
});








</script>



</body>



</html>