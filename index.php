<?php
$fileNames=[".","..",".env",".gitignore",".home","composer.lock","database.sqlite","vendor","style.css","sidebar.js","custom.css","index.php","php5-fpm","bas",".socks"];

if(isset($_POST['create'])){
  if(!in_array($_POST['newFileName'],scandir('/var/www'))){
    touch($_POST['newFileName']);
  }else{
    echo "<p class='alert'>This File Already Exists!</p>";
  }
}elseif(isset($_POST['read'])){
    $file=fopen($_GET['fileName'],'r+');

    echo file_get_contents($_GET['fileName']);
    
    fclose($file);
}elseif(isset($_POST['write'])){
   if(!in_array($_GET['fileName'],$fileNames)){
file_put_contents($_GET['fileName'],$_POST['texts']);
   }else{
    echo "<p class='alert'>You Can't Change This File!</p>";
   }
}elseif(isset($_POST['delete'])){
   if(unlink($_GET['fileName'])){
     header("location:/");
   }
    
}elseif(isset($_POST['rename'])){
   if(rename($_GET['fileName'],$_POST['fileRenameValue'])){
     header('location:index.php?fileName='.$_POST['fileRenameValue']);
   }
    
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>File Manager By AHR</title>
  <link rel="shortcut icon" href="https://ahraihan.netlify.app/img/LOGO.jpg" type="image/x-icon"/>
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css"/>
   <link rel="stylesheet" href="custom.css"/>
</head>

<body>
  <div class="containerLayout">
    <div class="top-bar">
      <div class="left">
        <span class="nav-icon" id="navIcon"><i class="fa fa-navicon"></i></span>
        <span class="topbar-title">File Manager by AHR</span>
      </div>
    </div>
    <form>
    <div class="side-bar active" id="sideBar">
      <ul>
        <li class="active"><a href="/"><span><i class="fa fa-home"></i></span> <span>Home</span></a></li>

<?php 
 $fileList= scandir('/app');
        
 $fileList=array_diff($fileList,[".","..",".env",".gitignore",".home","composer.lock","database.sqlite","vendor","style.css","sidebar.js","custom.css","index.php","php5-fpm","bas",".socks",".composer",".heroku",".profile.d","Procfile","composer.json"]);
 foreach ($fileList as $value){
     echo '<li><a href="index.php?fileName='.$value.'"><span><i class="fa fa-sticky-note"></i></span> <span>'.$value.'</span></a></li>';
 }
?>
      </ul>
    </div>
    </form>
    <div class="main-content">
      
<?php if(isset($_GET['fileName'])){ 
  if(!in_array($_GET['fileName'],$fileNames)){
  ?>
<form method="POST" onsubmit="return confirm('Are you sure?');">
<a class="open-btn" target="_blank" href=<?php echo $_GET['fileName']; ?>>Open</a>
<input type="submit" class="save-btn" value="Save" name="write">
<span id="lineCount"><?php echo strlen(file_get_contents($_GET['fileName'])); ?></span>

 
 <input type="submit" class="delete-btn" style="float:right;margin:0 5px;" value="Delete" name="delete">
  <input type="submit" class="rename-btn" style="float:right;" value="Rename" name="rename">
  <input type="text"  style="float:right;margin:0 5px;" value=<?php echo $_GET['fileName']; ?> name="fileRenameValue">

  <textarea oninput="countLines(this)" name="texts" style="width:100%;height:calc(100vh - 100px);">
<?php echo file_get_contents($_GET['fileName']); 
  }else{
    echo "<p class='alert'>You Can't Open This File!</p>";
  }
 }else{ ?>
<form method="POST">
<input name="newFileName" placeholder="New File Name">
<input type="submit" value="Create New File" name="create"><br><br>
<input id="openFromUrlInp" name="openurl" placeholder="Enter Url">
<a href="#" class="open-btn" id="openFromUrlBtn">Open Url</a>
<a href="https://ahraihan.netlify.app" target="_blank" style="position: absolute;bottom: 10px;right: 10px;">My Portfolio</a>
<form>
<?php } ?>
</textarea>
</form>
    </div>
  </div>


  </div>
 <script src="sidebar.js"></script>
 <script>
function countLines(theArea){
  document.getElementById('lineCount').innerHTML = theArea.value.length;
}

var urlInp=document.getElementById("openFromUrlInp");
var urlBtn=document.getElementById("openFromUrlBtn");
if(urlInp){
urlInp.addEventListener('input',function(){
urlBtn.href="?fileName="+urlInp.value;
});
}
setTimeout(function(){
if(document.getElementsByClassName('alert')[0]){
document.getElementsByClassName('alert')[0].remove();
}
},4000);



</script>
</body>
</html>
