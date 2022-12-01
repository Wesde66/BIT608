<?php
include "header.php";
include "checksession.php";

include "menu.php";
loginStatus(); //show the current login status

echo '<div id="site_content">';
include "sidebar.php";

echo '<div id="content">';
include "content.php";
?>
<div id="privacy_statement" style="margin-left: 8%; margin-top: 5%; margin-right: 3%;">

        <h1>Privacy Statement</h1>
        <p> We collect personal information from you, including information about your:</p>
        <ul>
          <li>Name</li>
          <li>Contact information</li>
          <li>Location</li>
          <li>Interactions with us</li>
          <li>Billing or purchase information</li>
        </ul>

          <p>We collect your personal information in order to:</p>
        <ul>
          <li>Complete your bookings and payments.</li>
        </ul>


         <p>Providing some information is optional. If you choose not to enter personal information or banking details,
          we'll not be able to process your bookings with us.
         </p>

          <p>We keep your information safe by encrypting the files and limiting access to this information to staff only.</p>


         <p>We keep your information for two years at which point we securely destroy it by securely erasing the data.
           You have the right to ask for a copy of any personal information we hold about you,
           and to ask for it to be corrected if you think it is wrong. If you’d like to ask for a copy of your information,
           or to have it corrected, please contact us at Mot@gmail.com, or +6498563214, or P.O. box 267, 0667.</p>

</div>


<?php
echo '</div></div>';
include "footer.php";
?>
