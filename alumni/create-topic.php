<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['alumniid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {
$alumniid=$_SESSION['alumniid'];
$topicname=$_POST['topicname'];

$sql="insert into tblDiscussionTopics(CreatedBy, TopicName) values(:alumniid, :topicname)";
$query=$dbh->prepare($sql);
$query->bindParam(':alumniid',$alumniid,PDO::PARAM_STR);
$query->bindParam(':topicname',$topicname,PDO::PARAM_STR);
$query->execute();

$LastInsertId=$dbh->lastInsertId();
if ($LastInsertId>0) {
    echo '<script>alert("Discussion topic has been added.")</script>';
    echo "<script>window.location.href ='view-discussion.php'</script>";
  }
  else {
    echo '<script>alert("Something Went Wrong. Please try again")</script>';
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>College Alumni System || Add Discussion Topic</title>
  <link rel="stylesheet" href="../admin/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../admin/style.css" />
  <link rel="stylesheet" href="../admin/css/responsive.css" />
  <link rel="stylesheet" href="../admin/css/colors.css" />
  <link rel="stylesheet" href="../admin/css/bootstrap-select.css" />
  <link rel="stylesheet" href="../admin/css/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../admin/css/custom.css" />
  <link rel="stylesheet" href="../admin/js/semantic.min.css" />
</head>
<body class="inner_page general_elements">
<div class="full_container">
  <div class="inner_container">
    <!-- Sidebar  -->
    <?php include_once('includes/sidebar.php');?>
    <!-- end sidebar -->
    <!-- right content -->
    <div id="content">
      <!-- topbar -->
      <?php include_once('includes/header.php');?>
      <!-- end topbar -->
      <!-- dashboard inner -->
      <div class="midde_cont">
        <div class="container-fluid">
          <div class="row column_title">
            <div class="col-md-12">
              <div class="page_title">
                <h2>Add Discussion Topic</h2>
              </div>
            </div>
          </div>
          <!-- row -->
          <div class="row column8 graph">
            <div class="col-md-12">
              <div class="white_shd full margin_bottom_30">
                <div class="full graph_head">
                  <div class="heading1 margin_0">
                    <h2>Add Discussion Topic</h2>
                  </div>
                </div>
                <div class="full progress_bar_inner">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="full">
                        <div class="padding_infor_info">
                          <div class="alert alert-primary" role="alert">
                            <form method="post">
                              <fieldset>
                                <div class="field">
                                  <label class="label_field">Topic Name</label>
                                  <input type="text" name="topicname" value="" class="form-control" required='true'>
                                </div>
                                <br>
                                <div class="field margin_0">
                                  <label class="label_field hidden">hidden label</label>
                                  <button class="main_bt" type="submit" name="submit" id="submit">Add</button>
                                </div>
                              </fieldset>
                            </form>
                          </div>
                          <hr>
                          <h3>Existing Discussion Topics</h3>
                          <div class="table_section padding_infor_info">
                            <div class="table-responsive-sm">
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th>S.No</th>
                                    <th>Topic Name</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  $sql = "SELECT TopicName FROM tblDiscussionTopics ORDER BY TopicName ASC";
                                  $query = $dbh->prepare($sql);
                                  $query->execute();
                                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                                  $cnt = 1;
                                  if($query->rowCount() > 0) {
                                    foreach($results as $row) {
                                      echo "<tr>";
                                      echo "<td>" . htmlentities($cnt) . "</td>";
                                      echo "<td>" . htmlentities($row->TopicName) . "</td>";
                                      echo "</tr>";
                                      $cnt++;
                                    }
                                  } else {
                                    echo "<tr><td colspan='2'>No discussion topics available.</td></tr>";
                                  }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- funcation section -->
          </div>
        </div>
        <!-- footer -->
        <?php include_once('includes/footer.php');?>
      </div>
      <!-- end dashboard inner -->
    </div>
  </div>
  <!-- model popup -->
</div>
<!-- jQuery -->
<script src="../admin/js/jquery.min.js"></script>
<script src="../admin/js/popper.min.js"></script>
<script src="../admin/js/bootstrap.min.js"></script>
<script src="../admin/js/animate.js"></script>
<script src="../admin/js/bootstrap-select.js"></script>
<script src="../admin/js/owl.carousel.js"></script>
<script src="../admin/js/Chart.min.js"></script>
<script src="../admin/js/Chart.bundle.min.js"></script>
<script src="../admin/js/utils.js"></script>
<script src="../admin/js/analyser.js"></script>
<script src="../admin/js/perfect-scrollbar.min.js"></script>
<script>
  var ps = new PerfectScrollbar('#sidebar');
</script>
<script src="../admin/js/jquery.fancybox.min.js"></script>
<script src="../admin/js/custom.js"></script>
<script src="../admin/js/semantic.min.js"></script>
</body>
</html>
<?php } ?>
