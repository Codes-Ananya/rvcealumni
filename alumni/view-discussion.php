<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['alumniid']==0)) {
  header('location:logout.php');
} else {
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>College Alumni System || View Discussions</title>
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
                              <h2>View Discussions</h2>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                           <div class="white_shd full margin_bottom_30">
                              <div class="full graph_head">
                                 <div class="heading1 margin_0">
                                    <h2>View Discussions</h2>
                                 </div>
                              </div>
                              
                              <div class="table_section padding_infor_info">
                                 <form method="GET">
                                    <div class="row">
                                       <div class="col-md-8">
                                          <label for="topic">Discussion Topic:</label>
                                          <select name="topic" id="topic" class="form-control">
                                             <option value="">All Topics</option>
                                             <?php
                                             $topicQuery = "SELECT ID, TopicName FROM tblDiscussionTopics";
                                             $topicResult = $dbh->prepare($topicQuery);
                                             $topicResult->execute();
                                             $topics = $topicResult->fetchAll(PDO::FETCH_OBJ);
                                             foreach($topics as $topic) {
                                                echo "<option value='{$topic->ID}'";
                                                if ($_GET['topic'] == $topic->ID) echo " selected";
                                                echo ">{$topic->TopicName}</option>";
                                             }
                                             ?>
                                          </select>
                                       </div>
                                       <div class="col-md-4" style="margin-top: 24px;">
                                          <button type="submit" class="btn btn-primary">Filter</button>
                                          <a href="create-topic.php" class="btn btn-success">New Topic</a>
                                          <a href="add-discussion.php" class="btn btn-info">Discuss</a>
                                       </div>
                                    </div>
                                 </form>
                                 <br/>
                                 <div class="table-responsive-sm">
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th>S.No</th>
                                             <th>Discussion Topic</th>
                                             <th>Message</th>
                                             <th>Posted By</th>
                                             <th>Posted Date</th>
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
                                          $sql = "SELECT d.ID, d.Message, t.TopicName, a.FullName, d.PostedDate  
                                                  FROM tblDiscussions d 
                                                  LEFT JOIN tblDiscussionTopics t ON d.TopicID = t.ID
                                                  LEFT JOIN tblalumni a ON d.PostedBy = a.ID";

                                          // Apply filters if any
                                          $conditions = [];
                                          $params = [];

                                          if (!empty($_GET['topic'])) {
                                             $conditions[] = "d.TopicID = :topic";
                                             $params[':topic'] = $_GET['topic'];
                                          }

                                          // Append conditions to SQL query
                                          if ($conditions) {
                                             $sql .= " WHERE " . implode(' AND ', $conditions);
                                          }

                                          // Add sorting and pagination to the query
                                          $sql .= " ORDER BY d.PostedDate DESC LIMIT $offset, $no_of_records_per_page";

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
                                             <td><?php echo htmlentities($row->TopicName);?></td>
                                             <td><?php echo htmlentities($row->Message);?></td>
                                             <td><?php echo htmlentities($row->FullName);?></td>
                                             <td><?php echo htmlentities($row->PostedDate);?></td>
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
                                             <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><strong style="padding-left: 10px">Next</strong></a>
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
