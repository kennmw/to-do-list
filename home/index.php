<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TO DO-LIST</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <style>
    .hidden{
      opacity: 0;
    }
    .visible{
      opacity: 1;
      transition: opacity 1s ease-out;
    }
    #loader {
      border: 12px solid #f3f3f3;
      border-radius: 50%;
      border-top: 12px solid #444444;
      width: 70px;
      height: 70px;
      animation:spin 1s linear infinite;
    }

    @keyframes spin{
      100%{
        transform: rotate(360deg);
      }
    }
    .center {
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      margin: auto;
    }
  </style>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
<?php session_start();
            if(!$_SESSION['username']){
              header('Location: http://localhost/timo/login/index.php?err=Login to access Your account');
              
            }
          ?>
  <div id="loader" class="center"></div>
  <script>
    document.onreadystatechange = function(){
      if(document.readyState !== "complete"){
        document.querySelector("body").style.visibility = "hidden";
        document.querySelector("#loader").style.visibility = "visible";
      }else{
        document.querySelector("#loader").style.display = "none";
        document.querySelector("body").style.visibility = "visible";
      }
    };

    // document.body.className = 'hidden';
  </script>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
    <div class="container-fluid">

      <div class="row justify-content-center">
        <div class="col-xl-9 d-flex align-items-center justify-content-lg-between">
          <h1 class="logo me-auto me-lg-0"><a href="index.html">TO DO-LIST</a></h1>
          <!-- Uncomment below if you prefer to use an image logo -->
          <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

          <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
              <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
              <li><a class="nav-link scrollto" href="#about">Activities</a></li>
              <!-- <li><a class="nav-link scrollto " href="#portfolio">Portfolio</a></li> -->
              
              <li><a class="nav-link scrollto" href="#contact">Add &#x2795;</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
          </nav><!-- .navbar -->

          <a href="http://localhost/timo/home/logout.php" class="get-started-btn scrollto">LOGOUT</a>
        </div>
      </div>

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex flex-column justify-content-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-8">
          
          <label class="text-center" style="color: red; "><?php 
                if (isset($_GET["err"])) {
                  echo $_GET["err"];
                }?>
              </label>
              <label class="text-center" style="color: red; "><?php 
                if (isset($_GET["msg"])) {
                  echo $_GET["msg"];
                }?>
              </label>
          <h1>Welcome back : <?php echo $_SESSION['first_name']; ?> </h1>
          <h2>Enjoy the interface</h2>
          <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="glightbox play-btn mb-4"></a>
        </div>
      </div>
    </div>
  </section><!-- End Hero -->

  <main id="main">


     <!-- ======= Activities supposed to do ======= -->
     <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>List of activities to do</h2>
          <p>Below are the activities that you need to do.</p>
        </div>
        <div class="table-responsive">
                    <table class="table table-striped  table-dark">
                        
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Event</th>
                            <th scope="col">Deadline [Date]</th>
                            <th scope="col">Deadline [Time]</th>

                            <th scope="col">Mark complete</th>
                            <th scope="col">Remove</th>

                        </thead>
                        <tbody>
                        <?php
                          $pdo = new PDO('mysql:host=localhost;port=3306;dbname=timo', 'root', '');
                          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                          $username = $_SESSION['username'];
                          $active_p_s = $pdo->prepare("SELECT * from activities where username = :username");
                          $active_p_s->bindValue(':username', $username);
                          $active_p_s->execute();
                          $active_p = $active_p_s->fetchAll(PDO::FETCH_ASSOC);

                          if($active_p){
                              foreach ($active_p as $i => $activity) { ?>
                                  <tr>
                                      <td><?php echo $i + 1 ?></td>
                                      <td><?php echo $activity['date']; ?></td>
                                      <td><?php echo $activity['activity']; ?></td>
                                      <td><?php echo $activity['deadline']; ?></td>
                                      <td><?php echo $activity['time']; ?></td>
                                      <td>
                                        <?php if($activity['complete']==0){
                                          echo '<form action="complete.php" method="post"><input type="hidden" name="id" value="'. $activity["id"].'"><input type="hidden" name="item" value="'. $activity["activity"].'"><button type="submit">&#x2757&#x2757&#x2757</button></form>';
                                        }elseif ($activity['complete']==1){
                                          echo "&#x2705&#x2705&#x2705";
                                        }
                                         ?>
                                        <!--  -->
                                      </td>
                                      <td><form action="remove.php" method="post"><input type="hidden" name="id" value="<?php echo $activity['id'];?>"><input type="hidden" name="item" value="<?php echo $activity['activity'] ?>"><button type="submit">remove</button></form></td>
                                  
                                  </tr>
                              </tbody>
                              <?php } 
                            }
                          ?>
                        
                    </table>
                </div> 
      </div>
        

      </div>
    </section><!-- End activities to do -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Add an activity to the list</h2>
          <p>Add task here : Date, Time, Message</p>
        </div>
      </div>

      

      <div class="container text-center">
          <div class="col-lg-8 mt-5 mt-lg-0">

            <form action="contact.php" method="post" role="form">
            <div class="form-group mt-3">
                <input type="date" class="form-control" name="deadline" id="subject" required>
              </div>
              <div class="form-group mt-3">
                <input type="time" class="form-control" name="time" id="subject" required>
              </div>
              
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="3" placeholder="&#x27A5;" required></textarea>
              </div>
              <!-- <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div> -->
              <div class="text-center"><button type="submit">&#x2795;</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="section-title">
          <h2>About Us</h2>
          <p>This is a todo list</p>
        </div>

        
      </div>
    </section><!-- End About Us Section -->



  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <h3>TO-DO LIST</h3>
      <!-- <p>Et aut eum quis fuga eos sunt ipsa nihil. Labore corporis magni eligendi fuga maxime saepe commodi placeat.</p> -->
      <div class="copyright">
        &copy; Copyright <strong><span>TODO-LIST</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
      </div>
    </div>
  </footer><!-- End Footer -->

  <!-- <div id="preloader"></div> -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/purecounter/purecounter.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>