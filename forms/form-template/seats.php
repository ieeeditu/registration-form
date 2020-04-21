<!-- HTML Template to be displayed when registration has been closed -->
<?php
          
    /**
     * Create a dynamic Title for the page. Used in header.php file.
     */
    $title ="-Registration Stopped"; 

    /**
     * Include header template of HTML
     */
    include("header.php");
?>
    <div class="container" >
                    <!-- style="margin-top: 1em; margin-bottom: 1em;"-->
           <div class="row">
                    <div class="col-md-12" style="padding=0.5em;">
                        <div class="card">
                            <div class="card-body"> 
                              <h3 class="card-title">Registration Closed</h3> 
                              <p>All seats are full! Stay tuned for the event!!! </p>
                            </div>
                        </div>
                    </div>
            </div>

                
                <hr>
    </div>

        <?php include("footer.php")?> 