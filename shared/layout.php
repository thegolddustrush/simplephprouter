<!DOCTYPE html>
<html>
<head><title>Test router <?php echo  $title; ?></title>
<link href="/_css/bootstrap.min.css" rel="stylesheet">
<link href="/_css/bootstrap-theme.min.css" rel="stylesheet">
<style>

th {font-weight : bold;}

.syllabus td{
border : 1px solid #000000;
padding : 3px;
}
</style>

<script src="/_js/jquery-3.6.0.min.js" ></script>
<script type="text/javascript">

</script>

</head>
<body>
<nav class="navbar navbar-inverse ">
<div class="container">
<div class="navbar-header">
<a class="navbar-brand" href="#">Simple router</a>
</div>
</div>
</nav>

<div class="container" style="margin-top : 50px;">

<?php 

if ($isAuthenticated ){
?>

<h3>Welcome <?php echo $sess->GetUserName();  ?></h3>

<p><a href="?logout" class="btn btn-default btn-xs">Logout</a>

<?php 

}

?>

<div>

<?php 

if ($toInclude != ""){
  include($toInclude); 
}else if($data!= ""){
  echo $data;
}
?>

</div>

<script src="/_js/bootstrap.min.js"></script>

</body>
</html>
