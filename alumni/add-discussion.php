<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['alumniid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $alumniid = $_SESSION['alumniid'];
        $topicid = $_POST['topicid'];
        $message = $_POST['message'];

        $sql = "INSERT INTO tblDiscussions (TopicID, Message, PostedBy, PostedDate) 
                VALUES (:topicid, :message, :alumniid, NOW())";
        $query = $dbh->prepare($sql);
        $query->bindParam(':topicid', $topicid, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->bindParam(':alumniid', $alumniid, PDO::PARAM_STR);
        $query->execute();

        $LastInsertId = $dbh->lastInsertId();
        if ($LastInsertId > 0) {
            echo '<script>alert("Discussion has been added.")</script>';
            echo "<script>window.location.href ='view-discussion.php'</script>";
        } else {
            echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>College Alumni System || Add Discussion</title>
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
            <?php include_once('includes/sidebar.php'); ?>
            <div id="content">
               <?php include_once('includes/header.php'); ?>
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>Add Discussion</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row column8 graph">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>Add Discussion</h2>
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
                                                         <label class="label_field">Discussion Topic</label>
                                                         <select name="topicid" class="form-control" required>
                                                            <option value="">Select Topic</option>
                                                            <?php
                                                            $sql = "SELECT ID, TopicName FROM tblDiscussionTopics ORDER BY TopicName";
                                                            $query = $dbh->prepare($sql);
                                                            $query->execute();
                                                            $topics = $query->fetchAll(PDO::FETCH_OBJ);
                                                            foreach ($topics as $topic) {
                                                                echo "<option value='{$topic->ID}'>{$topic->TopicName}</option>";
                                                            }
                                                            ?>
                                                         </select>
                                                      </div>
                                                      <br>
                                                      <div class="field">
                                                         <label class="label_field">Message</label>
                                                         <textarea name="message" class="form-control" required rows="6"></textarea>
                                                      </div>
                                                      <br>
                                                      <div class="field margin_0">
                                                         <button class="main_bt" type="submit" name="submit" id="submit">Add</button>
                                                      </div>
                                                   </fieldset>
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php include_once('includes/footer.php'); ?>
               </div>
            </div>
         </div>
      </div>
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
      <script src="../admin/js/custom.js"></script>
      <script src="../admin/js/semantic.min.js"></script>
   </body>
</html>
<?php } ?>
