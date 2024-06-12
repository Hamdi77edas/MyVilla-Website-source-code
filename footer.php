

<?php
$facebook=mysqli_fetch_array(mysqli_query($connect,"SELECT info_value FROM site_info WHERE 1 AND info_key='facebook'"))['info_value'];
$whatsapp=mysqli_fetch_array(mysqli_query($connect,"SELECT info_value FROM site_info WHERE 1 AND info_key='whatsapp'"))['info_value'];
$telegram=mysqli_fetch_array(mysqli_query($connect,"SELECT info_value FROM site_info WHERE 1 AND info_key='telegram'"))['info_value'];
?>


<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
    <div class="container py-1">
        <div class="pb-4 mb-1" style="border-bottom: 1px solid rgba(255, 255, 255, 0.5) ;">
            <div class="row g-4" ><!dir="rtl">
                <div class="col-lg-6">
                    <a href="#"  >
                        <p class="text-white mb-0" style="font-family: 'Ubuntu', sans-serif !important;">أهلاً بكم في موقع </p>
                        <h3 class="text-white mb-0" style="font-family: 'Ubuntu', sans-serif !important;">MyVilla </h3>
                        
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="d-flex justify-content-end pt-3">
                        
                        <a class="btn btn-outline-secondary m-2 btn-md-square rounded-circle text-white" href="<?php echo $facebook;?>"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-secondary m-2 btn-md-square rounded-circle text-white" href="<?php echo $whatsapp;?>"><i class="fab fa-whatsapp"></i></a>
                        <a class="btn btn-outline-secondary m-2 btn-md-square rounded-circle text-white" href="<?php echo $telegram;?>"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright bg-dark py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0" ><!dir="rtl">
                <span class="text-light">Copyright © 2024 All Rights Reserved</span>
            </div>
            <div class="col-md-6 my-auto text-center text-md-end text-white">
              
                Powered and Developed by  
                <a class="border-bottom" style="color:#fff;" href="https://www.ppu.edu/p/ar">
                 Students in PPU university
                 </a>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->



<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/lib/easing/easing.min.js"></script>
<script src="assets/lib/waypoints/waypoints.min.js"></script>
<script src="assets/lib/lightbox/js/lightbox.min.js"></script>
<script src="assets/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="assets/js/main.js"></script>
</body>

</html>
