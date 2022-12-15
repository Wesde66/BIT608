<?php


include "re_used_file/check_session.php";
include "re_used_file/header.php";
include "re_used_file/menu.php";
//Login status is shown in the menu
?>


<style>
    .mySlides {
        display: none;
    }
</style>


<body>

    <h2 class="w3-center">Welcome to the Ongaonga Bed & Breakfast</h2>
    <br>
    <H6 class="w3-center">The retired couple Mr and Mrs Smith have a large beautiful homestead in the Ongaonga Region.
        We live by ourselves have this beautifuly large heritage home which we have turned into a Bed & Breakfast (B&B).
        Our home is close to Napier, Waipukurau and Tikokino....</H6>

    <div class="w3-content w3-section" style="max-width:80%">
        <img class="mySlides" src="../Motueka/style/images/Room1.jpg" style="width:100%">
        <img class="mySlides" src="../Motueka/style/images/room2.jpg" style="width:100%">
        <img class="mySlides" src="../Motueka/style/images/room3.jpg" style="width:100%">
    </div>

    <script>
        var myIndex = 0;
        carousel();

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            myIndex++;
            if (myIndex > x.length) {
                myIndex = 1
            }
            x[myIndex - 1].style.display = "block";
            setTimeout(carousel, 4000); // Change image every 2 seconds
        }
    </script>


    <?php
    include "re_used_file/footer.php";
    ?>