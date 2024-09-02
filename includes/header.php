<header class="header">
         
      <!-- Top Bar -->
      <div class="top_bar">
         <div class="top_bar_container">
            <div class="container">
               <div class="row">
                  <div class="col">
                     <div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
                        <ul class="top_bar_contact_list">
                           <?php
$sql="SELECT * from tblpage where PageType='contactus'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                           <li><div class="question">Have any questions?</div></li>
                           <li>
                              <i class="fa fa-phone" aria-hidden="true"></i>
                              <div><?php  echo htmlentities($row->MobileNumber);?></div>
                           </li>
                           <li>
                              <i class="fa fa-envelope-o" aria-hidden="true"></i>
                              <div><?php  echo htmlentities($row->Email);?></div>
                           </li><?php $cnt=$cnt+1;}} ?>
                        </ul>
                        <div class="top_bar_login ml-auto">
                           <div class="login_button"><a href="alumni/registration.php">Alumni Registration</a></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>            
      </div>

      <!-- Header Content -->
      <div class="header_container">
         <div class="container">
            <div class="row">
               <div class="col">
                  <div class="header_content d-flex flex-row align-items-center justify-content-start">
                     <div class="logo_container">
                        <a href="index.php">
                           <div class="logo_text">RVCE <span>Alumni Portal</span></div>
                        </a>
                     </div>
                     <nav class="main_nav_contaner ml-auto">
                        <ul class="main_nav">
                           <li class="active"><a href="index.php">Home</a></li>
                           <li><a href="about.php">About</a></li>
                        
                           <li><a href="contact.php">Contact</a></li>
                           <li><a href="events.php">Events</a></li>
                           <li><a href="job-lists.php">Posted Jobs</a></li>
                           <li><a href="alumni/login.php">Alumni</a></li>
                           <li><a href="admin/login.php">Admin</a></li>
                        </ul>
                     
                        <!-- Hamburger -->

                        <div class="hamburger menu_mm">
                           <i class="fa fa-bars menu_mm" aria-hidden="true"></i>
                        </div>
                     </nav>

                  </div>
               </div>
            </div>
         </div>
      </div>

      <!-- Header Search Panel -->
      <div class="header_search_container">
         <div class="container">
            <div class="row">
               <div class="col">
                  <div class="header_search_content d-flex flex-row align-items-center justify-content-end">
                     <form action="#" class="header_search_form">
                        <input type="search" class="search_input" placeholder="Search" required="required">
                        <button class="header_search_button d-flex flex-column align-items-center justify-content-center">
                           <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                     </form>
                  </div>
               </div>
            </div>
         </div>         
      </div>         
   </header>