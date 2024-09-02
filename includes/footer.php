<footer class="footer">
      <div class="footer_background" style="background-image:url(images/footer_background.png)"></div>
      <div class="container">
         <div class="row footer_row">
            <div class="col">
               <div class="footer_content">
                  <div class="row">

                     <div class="col-lg-4 footer_col">
               
                        <!-- Footer About -->
                        <div class="footer_section footer_about">
                           <div class="footer_logo_container">
                              <a href="#">
                                 <div class="footer_logo_text">College <span>Alumni S/Y</span></div>
                              </a>
                           </div>
                           <div class="footer_about_text">
                              <p>Lorem ipsum dolor sit ametium, consectetur adipiscing elit.</p>
                           </div>
                           <div class="footer_social">
                              <ul>
                                 <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                 <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                 <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                 <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                              </ul>
                           </div>
                        </div>
                        
                     </div>

                     <div class="col-lg-4 footer_col">
               
                        <!-- Footer Contact -->
                        <div class="footer_section footer_contact">
                           <div class="footer_title">Contact Us</div>
                           <div class="footer_contact_info">
                              <ul>
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
                                 <li>Email: <?php  echo htmlentities($row->Email);?></li>
                                 <li>Phone:  +<?php  echo htmlentities($row->MobileNumber);?></li>
                                 <li><?php  echo htmlentities($row->PageDescription);?></li><?php $cnt=$cnt+1;}} ?>
                              </ul>
                           </div>
                        </div>
                        
                     </div>

                     <div class="col-lg-4 footer_col">
               
                        <!-- Footer links -->
                        <div class="footer_section footer_links">
                           <div class="footer_title">Quick Links</div>
                           <div class="footer_links_container">
                              <ul>
                                 <li><a href="index.php">Home</a></li>
                           <li><a href="about.php">About</a></li>
                        
                           <li><a href="contact.php">Contact</a></li>
                           <li><a href="alumni/login.php">Alumni</a></li>
                           <li><a href="admin/login.php">Admin</a></li>
                              </ul>
                           </div>
                        </div>
                        
                     </div>

                    

                  </div>
               </div>
            </div>
         </div>

         <div class="row copyright_row">
            <div class="col">
               <div class="copyright d-flex flex-lg-row flex-column align-items-center justify-content-start">
                  <div class="cr_text"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> College Alumni System 
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
                
               </div>
            </div>
         </div>
      </div>
   </footer>