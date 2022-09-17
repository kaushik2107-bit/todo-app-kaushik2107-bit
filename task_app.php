<!DOCTYPE html>
<?php
include 'connection.php';
session_start();
// $_SESSION["user"] = "";
// $_SESSION["email"] = "";



?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Tasks</title>
    <link rel="stylesheet" href="css/task_app.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Pacifico&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <?php
  // $uuname;
  // $eemail;
    if(isset($_POST['login'])) {
      $username1 = $_POST['uuname'];
      $password1 = $_POST['upsswd'];
      $password1 = hash("sha256", $password1);
      // $uuname = $username;


      $query1 = "create database if not exists user_database";
      mysqli_query($conn, $query1);
      $query2 = "use user_database";
      mysqli_query($conn, $query2);

      $query3 = "create table if not exists user_info (
        id int auto_increment,
        username varchar(100),
        email varchar(255),
        password varchar(255),
        primary key (id)
        );";
      mysqli_query($conn, $query3);

      $query4 = "select * from user_info where username = '$username1' and password = '$password1'";
      // echo $query4;
      $s = mysqli_query($conn, $query4);
      $row = mysqli_fetch_assoc($s);
      if (mysqli_num_rows($s) == 1) {
        $_SESSION["user"] = $username1;
        $_SESSION["email"] = $row['email'];
        $email1 = $_SESSION['email'];

      } else {
        echo "<script> alert('Invalid username or password')</script>";
      }

    } else if (isset($_POST['register'])) {
      $username = $_POST['uname'];
      $email = $_POST['email'];
      $password = $_POST['psswd'];
      $password = hash("sha256", $password);

      $query1 = "create database if not exists user_database";
      mysqli_query($conn, $query1);
      $query2 = "use user_database";
      mysqli_query($conn, $query2);

      $query3 = "create table if not exists user_info (
        id int auto_increment,
        username varchar(100),
        email varchar(255),
        password varchar(255),
        primary key (id)
        );";
      mysqli_query($conn, $query3);

      $query4 = "select * from user_info where email = '$email'";
      $res1 = mysqli_query($conn, $query4);
      if (mysqli_num_rows($res1) == 0) {
        $query5 = "insert into user_info (username, email, password) values ('$username','$email', '$password')";
        $s = mysqli_query($conn, $query5);
        if (!$s) {
          echo "<script> alert('There is some issue');</script>";
        } else {
          echo "<script> alert('User registered successfully ');</script>";
        }
      } else {
        $row = mysqli_fetch_assoc($res1);
        if ($username == $row['username']) {
          echo "<script>alert('The username already exists')</script>";
        } else {
          echo "<script> alert('The email already exists')</script>";
          // echo "<script> alert(' ". $row['username']. "')</script>";
        }
      }
    }
    // echo $_SESSION['user'];

    // echo $_SESSION['user'];
    // echo $username1;

    ?>
    <?php
    if (isset($_POST['task_submit'])) {
      $task_user = $_SESSION['user'];
      $task_title = $_POST['task_title'];
      $task_date = $_POST['task_date'];
      $task_time = $_POST['task_time'];


      $query1 = "create database if not exists user_database";
      mysqli_query($conn, $query1);
      $query2 = "use user_database";
      mysqli_query($conn, $query2);
      // echo $task_title;
      $q1 = "create table if not exists task_info (
        id int(11) AUTO_INCREMENT,
        user_name varchar(255),
        task_title varchar(200),
        task_date varchar(200),
        task_time varchar(200),
        PRIMARY KEY(id)
        );";

      mysqli_query($conn, $q1);

      $q2 = "insert into task_info (user_name, task_title, task_date, task_time) values ('$task_user', '$task_title', '$task_date', '$task_time');";
      $qq = mysqli_query($conn, $q2);
      if ($qq) {
        echo "<script>alert('New task added')</script>";
      } else {
        echo "<script>alert('Try again some time later') </script>";
        echo mysqli_error($conn);
      }
    }

    ?>

    <script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }
    </script>

  <body>

    <div class="sky">
      <div class="sun moon">

      </div>
      <div class="sun">

      </div>
      <div class="form" id="form">
        <div class="toggle">
          <div class="login">
            Login
          </div>
          <div class="register">
            Register
          </div>
        </div>
        <div id="login_form">
          <form class="login_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="msg">

            </div>
            <label for="username">Username</label><br>
            <input type="text" id="username" name="uuname" value=""><br>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="upsswd" value=""><br>
            <input type="submit" name="login" value="Login">
          </form>
        </div>
        <div id="register_form">
          <form class="register_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="msg">

            </div>
            <label for="username">Username</label><br>
            <input type="text" id="username" name="uname" value=""><br>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" value=""><br>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="psswd" value=""><br>
            <input type="submit" name="register" value="Register">
          </form>
        </div>
      </div>
      <?php
      if(isset($_GET['logout'])) {
        header('location: task_app.php');
        session_destroy();
      }
      ?>

      <div class="body" id="body">
        <p class="msg">Hello <?php if (isset($_SESSION['user'])) {echo $_SESSION['user'];} ?> <a href="task_app.php?logout">logout</a> </p>
        <form class="tools" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <!-- <div class="tools"> -->
            <input type="text" name="task_title" value="" placeholder="What's the task?">
            <input type="date" name="task_date" value="">
            <input type="time" name="task_time" value="">
            <input type="submit" name="task_submit" value="Add Task">
          <!-- </div> -->
        </form>

        <div class="tasks">
          <?php
          function delete($id) {
            // echo $id;
          }

          if (isset($_SESSION['user'])) {
            $query2 = "use user_database";
            mysqli_query($conn, $query2);
            $qqq1 = "select * from task_info where user_name = '" .$_SESSION['user']."' ORDER BY task_date, task_time";
            $qq1 = mysqli_query($conn, $qqq1);
            // $ress = mysqli_fetch_assoc($qq1);
            while ($row = mysqli_fetch_assoc($qq1)) {
              // echo $ress['user_name'];
              echo "<div class='cards'>
                <div class='task_name'>
                  ". $row['task_title']."
                </div>
                <div class='task_due'>
                  <div class='task_date'>
                    ".$row['task_date']."
                  </div>
                  <div class='task_time'>
                    ".$row['task_time']."
                  </div>
                </div>
                <div class='options'>
                <!---<a class='fa fa-pencil'></a>--->
                <a class='fa fa-check-circle' href='completed.php?id=".$row['id']."'></a>
                <a class='fa fa-times-circle' href='delete.php?id=".$row['id']."'></a>
                
                </div>
              </div>";
            }
            if (mysqli_num_rows($qq1) ==  0) {echo "<p class='notask msg' style='width: 200px;margin-left: calc(50% - 80px); margin-top: 200px; background: transparent; color: white; font-size: 20px'>No tasks added</p>";}
          }
          ?>
          <!-- <div class='cards'>
            <div class='task_name'>

            </div>
            <div class='task_date'>

            </div>
            <div class='task_time'>

            </div>
          </div> -->
        </div>
      </div>
      <?php
      if (isset($_SESSION['user'])) {
        echo "<script> document.getElementById('body').style.display = 'block'; </script>";
      } else {
        echo "<script> document.getElementById('body').style.display = 'none'; </script>";
      }


      ?>
    </div>
    <div class="land">

    </div>


    <?php
    if ($_SESSION['user'] == '') {
      echo "<script>
        let x = document.getElementById('form');
        x.style.display = 'block';
      </script>";
    } else {
      echo "<script>
        let x = document.getElementById('form');
        x.style.display = 'none';
      </script>";
    }
    ?>

    <script type="text/javascript">
    let l = document.getElementById("login_form");
    let s = document.getElementById("register_form");
    let reg = document.getElementsByClassName('register');
    let log =document.getElementsByClassName('login');
    console.log(l);
    reg[0].addEventListener('click', function(){
      l.style.display = "none";
      s.style.display = "block";
      reg[0].style.color = "black";
      log[0].style.color = "white";
      reg[0].style.backgroundColor = "rgb(252,84,73)";
      log[0].style.backgroundColor = "transparent";
    });
    log[0].addEventListener('click', function() {
      l.style.display = "block";
      s.style.display = "none";
      log[0].style.color = "black";
      reg[0].style.color = "white";
      log[0].style.backgroundColor = "rgb(252,84,73)";
      reg[0].style.backgroundColor = "transparent";
    });

    </script>

  </body>
</html>
