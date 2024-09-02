<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['alumniid']==0)) {
  header('location:logout.php');
  } else{

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>College Alumni System || View Current Alumni</title>
      <link rel="stylesheet" href="../admin/css/bootstrap.min.css" />
      <link rel="stylesheet" href="../admin/style.css" />
      <link rel="stylesheet" href="../admin/css/responsive.css" />
      <link rel="stylesheet" href="../admin/css/colors.css" />
      <link rel="stylesheet" href="../admin/css/bootstrap-select.css" />
      <link rel="stylesheet" href="../admin/css/perfect-scrollbar.css" />
      <link rel="stylesheet" href="../admin/css/custom.css" />
      <link rel="stylesheet" href="../admin/js/semantic.min.css" />
      <link rel="stylesheet" href="../admin/css/jquery.fancybox.css" />
   </head>
   <body class="inner_page tables_page">
      <div class="full_container">
         <div class="inner_container">
            <?php include_once('includes/sidebar.php');?>
            <div id="content">
              <?php include_once('includes/header.php');?>
               <div class="midde_cont">
                  <div class="container-fluid">
                     <div class="row column_title">
                        <div class="col-md-12">
                           <div class="page_title">
                              <h2>View College Alumni</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>View College Alumni</h2>
                                 </div>
                              </div>
                              
                              <div class="table_section padding_infor_info">
                                 <form method="GET">
                                    <div class="row">
                                       <div class="col-md-4">
                                          <label for="course">Course:</label>
                                          <select name="course" id="course" class="form-control">
                                             <option value="">All Courses</option>
                                             <?php
                                             $courseQuery = "SELECT ID, CourseName FROM tblcourse";
                                             $courseResult = $dbh->prepare($courseQuery);
                                             $courseResult->execute();
                                             $courses = $courseResult->fetchAll(PDO::FETCH_OBJ);
                                             foreach($courses as $course) {
                                                echo "<option value='{$course->ID}'";
                                                if ($_GET['course'] == $course->ID) echo " selected";
                                                echo ">{$course->CourseName}</option>";
                                             }
                                             ?>
                                          </select>
                                       </div>
                                       <div class="col-md-4">
                                          <label for="batch">Batch:</label>
                                          <select name="batch" id="batch" class="form-control">
                                             <option value="">All Batches</option>
                                             <?php
                                             $batchQuery = "SELECT DISTINCT Batch FROM tblalumni ORDER BY Batch";
                                             $batchResult = $dbh->prepare($batchQuery);
                                             $batchResult->execute();
                                             $batches = $batchResult->fetchAll(PDO::FETCH_OBJ);
                                             foreach($batches as $batch) {
                                                echo "<option value='{$batch->Batch}'";
                                                if ($_GET['batch'] == $batch->Batch) echo " selected";
                                                echo ">{$batch->Batch}</option>";
                                             }
                                             ?>
                                          </select>
                                       </div>
                                       <div class="col-md-4" style="margin-top: 24px;">
                                          <button type="submit" class="btn btn-primary">Filter</button>
                                       </div>
                                    </div>
                                 </form>
                                 <br/>
                                 <div class="table-responsive-sm">
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th>S.No</th>
                                             <th>Full Name</th>
                                             <th>Batch</th>
                                             <th>Course</th>
                                             <th>Registration Date</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php
                                          // Pagination setup
                                          if (isset($_GET['pageno'])) {
                                             $pageno = $_GET['pageno'];
                                          } else {
                                             $pageno = 1;
                                          }
                                          $no_of_records_per_page = 10;
                                          $offset = ($pageno-1) * $no_of_records_per_page;

                                          // Construct the base query
                                          $sql = "SELECT a.ID, a.FullName, a.Batch, c.CourseName, a.RegDate  
                                                  FROM tblalumni a 
                                                  LEFT JOIN tblcourse c ON a.CourseGraduated = c.ID";

                                          // Apply filters if any
                                          $conditions = [];
                                          $params = [];

                                          if (!empty($_GET['course'])) {
                                             $conditions[] = "a.CourseGraduated = :course";
                                             $params[':course'] = $_GET['course'];
                                          }

                                          if (!empty($_GET['batch'])) {
                                             $conditions[] = "a.Batch = :batch";
                                             $params[':batch'] = $_GET['batch'];
                                          }

                                          // Append conditions to SQL query
                                          if ($conditions) {
                                             $sql .= " WHERE " . implode(' AND ', $conditions);
                                          }

                                          // Add pagination to the query
                                          $sql .= " LIMIT $offset, $no_of_records_per_page";

                                          $query = $dbh->prepare($sql);
                                          foreach ($params as $key => &$val) {
                                              $query->bindParam($key, $val);
                                          }
                                          $query->execute();
                                          $results = $query->fetchAll(PDO::FETCH_OBJ);

                                          $cnt = 1;
                                          if ($query->rowCount() > 0) {
                                             foreach ($results as $row) {
                                          ?>
                                          <tr>
                                             <td><?php echo htmlentities($cnt);?></td>
                                             <td><?php  echo htmlentities($row->FullName);?></td>
                                             <td><?php  echo htmlentities($row->Batch);?></td>
                                             <td><?php  echo htmlentities($row->CourseName);?></td>
                                             <td><?php  echo htmlentities($row->RegDate);?></td>
                                          </tr>
                                          <?php
                                                $cnt++;
                                             }
                                          } else {
                                             echo "<tr><td colspan='5'>No records found</td></tr>";
                                          }
                                          ?>
                                       </tbody>
                                    </table>
                                    <div align="left">
                                       <ul class="pagination" >
                                          <li><a href="?pageno=1"><strong>First></strong></a></li>
                                          <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                             <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><strong style="padding-left: 10px">Prev></strong></a>
                                          </li>
                                          <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                             <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><strong style="padding-left: 10px">Next></strong></a>
                                          </li>
                                          <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>

                           </div>
                        </div>
                     </div>
                  </div>
                  <?php include_once('includes/footer.php');?>
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
      <script src="../admin/js/jquery.fancybox.min.js"></script>
      <script src="../admin/js/custom.js"></script>
      <script src="../admin/js/semantic.min.js"></script>
   </body>
</html>
<?php } ?>
