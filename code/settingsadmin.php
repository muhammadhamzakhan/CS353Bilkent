<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Settings Admin</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body style="padding-top: 70px">
<div class="container-fluid">
	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#topFixedNavbar1" aria-expanded="false"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
          <a class="navbar-brand" href="#">Servo</a></div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="topFixedNavbar1">
          <ul class="nav navbar-nav">
            <li class="active"></li>
            <li></li>
            <li class="dropdown">
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="home.php" title="Home Page Link">Home</a></li>
            <li><a href="#">Messages</a></li>
            <li><a href="#">Notifications</a></li>
            <li><a href="settingsadmin.php">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li class="dropdown">
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
    </nav>
	
	<div class="row">
	  <div class="col-xs-6">
	  	<form class="form-inline">
  			<input type="password" class="form-control mb-2 mr-sm-2 mb-sm-0" id="password" placeholder="New Password">
			<button type="submit" class="btn btn-primary">Change Password</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">
	  	
      </div>
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
	  	<form class="form-inline">
  			<input type="email" class="form-control mb-2 mr-sm-2 mb-sm-0" id="email" placeholder="New Email">
			<button type="submit" class="btn btn-primary">Change Email</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">
	  	
      </div>
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
	  	<form class="form-inline">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="blockuser" placeholder="Username">
			<button type="submit" class="btn btn-primary">Block User</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">
	  	
      </div>
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
	  	<form class="form-inline">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="banuser" placeholder="Username">
			<button type="submit" class="btn btn-primary">Ban User</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">
	  	
      </div>
  	</div>
	
	<div class="row" style="margin-top:20px;">
	  <div class="col-xs-6">
	  	<form class="form-inline">
  			<input type="input" class="form-control mb-2 mr-sm-2 mb-sm-0" id="addcategory" placeholder="Category Name">
			<button type="submit" class="btn btn-primary">Add Category</button>
		</form>
      </div>
	  
	  <div class="col-xs-6">
	  	
      </div>
  	</div>
	
	
	
	
</div>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>