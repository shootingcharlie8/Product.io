<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Product.io</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/offcanvas.css" rel="stylesheet">
    </head>
    <body>
        <div id="main">
            <?php
                if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
                {
                     ?>
            <?php 
                $servername = "localhost";
                $username = "productio";
                $password = "suSx6HQKQPaMOMGA";
                $dbname = "productio";
                
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 
                if (isset($_GET['id'])){
                $sql = "SELECT * FROM Entries WHERE `ID` LIKE '" . $_GET['id'] . "'";
                $result = $conn->query($sql);
                }
                
                /*
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "Title: " . $row["Title"]. " " . $row["Task"]. "<br>";
                    }
                } else {
                    echo "0 results";
                }
                $conn->close();
                */
                ?>
            <nav class="navbar navbar-fixed-top navbar-inverse">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Product.io</a>
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Home</a></li>
                            <li><a href="entry.php">Add Note</a></li>
                            <li><a href="note.php">Notes</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                    <!-- /.nav-collapse -->
                </div>
                <!-- /.container -->
            </nav>
            <!-- /.navbar -->
            <div class="container">
                <div class="row row-offcanvas row-offcanvas-right">
                    <div class="col-xs-12 col-sm-9">
                        <p class="pull-right visible-xs">
                            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
                        </p>
                        <div class="jumbotron">
                            <h1>Product.io</h1>
                            <p>This is Product.io, a simple, minimalistic note taking application.</p>
                        </div>
                        <div class="row">
                            <?php
                                if (isset($_GET['id'])){
                                  while($row = $result->fetch_assoc()) {
                                      echo "<h2>" . $row["Title"]. "</h2><p>" . substr($row["Task"], 0, 230). "</p>";
                                  }
                                }
                                else{
                                $sql = "SELECT * FROM Entries WHERE `BelongsTo` LIKE '" . $_SESSION['Username'] . "' ORDER BY ID DESC";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                  
                                while($row = $result->fetch_assoc()) {
                                      echo "<div class='col-xs-6 col-lg-4'><h2>" . $row["Title"]. "</h2><p>" . substr($row["Task"], 0, 230). "</p><p><a class='btn btn-default' href='note.php?id=" . $row["ID"] . "' role='button'>View details »</a></p></div>";
                                }
                                
                                }
                                  else {
                                echo "No Entries!";
                                }
                                }
                                  ?>
                        </div>
                        <!--/row-->
                    </div>
                    <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
                        <div class="list-group">
                            <a href="entry.php" class="list-group-item active">Add Note</a>
                        </div>
                    </div>
                    <!--/.col-xs-12.col-sm-9-->
                </div>
                
                <!--/.sidebar-offcanvas-->
                <hr>
                
                <footer>
                    <p>© 2015 Charlie Melidosian, Inc.</p>
                </footer>
            </div>
            <!--/row-->
        </div>
        <!--/.container-->
        <!-- Bootstrap core JavaScript
            ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
        <script src="offcanvas.js"></script>
        <!--<h1>Member Area</h1>
            <pThanks for logging in! You are <code><?=$_SESSION['Username']?></code> and your email address is <code><?=$_SESSION['EmailAddress']?></code>.</p>
             -->
        <?php
            }
            elseif(!empty($_POST['username']) && !empty($_POST['password']))
            {
            $username = mysql_real_escape_string($_POST['username']);
            $password = md5(mysql_real_escape_string($_POST['password']));
            
            $checklogin = mysql_query("SELECT * FROM users WHERE Username = '".$username."' AND Password = '".$password."'");
            
            if(mysql_num_rows($checklogin) == 1)
            {
               $row = mysql_fetch_array($checklogin);
               $email = $row['EmailAddress'];
                
               $_SESSION['Username'] = $username;
               $_SESSION['EmailAddress'] = $email;
               $_SESSION['LoggedIn'] = 1;
                
               echo "<h1>Success</h1>";
               echo "<p>We are now redirecting you to the member area.</p>";
               echo "<meta http-equiv='refresh' content='0;index.php' />";
            }
            else
            {
               echo "<h1>Error</h1>";
               echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
            }
            }
            else
            {
            ?>
        <div class="container">
            <div class="form-signin">
                <h2 class="form-signin-heading">Please sign in</h2>
                <form method="post" action="index.php" name="loginform" id="loginform">
                    <fieldset>
                        <label for="username">Username:</label><input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus/><br />
                        <label for="password">Password:</label><input type="password" name="password" id="password" class="form-control" placeholder="Password" required/><br />
                        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login" id="login" value="Login"  >Sign in</button>
                    </fieldset>
                </form>
            </div>
        </div>
        <!-- /container -->
        <!--
            <h1>Member Login</h1>
              
            <p>Thanks for visiting! Please either login below, or <a href="register.php">click here to register</a>.</p>
              
             <form method="post" action="index.php" name="loginform" id="loginform">
             <fieldset>
                 <label for="username">Username:</label><input type="text" name="username" id="username" /><br />
                 <label for="password">Password:</label><input type="password" name="password" id="password" /><br />
                 <input type="submit" name="login" id="login" value="Login" />
             </fieldset>
             </form>
              -->
        <?php
            }
            ?>
        </div>
    </body>
</html>