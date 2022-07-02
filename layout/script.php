<!-- Start Script -->
<script src="assets/js/jquery-1.11.0.min.js"></script>
<script src="assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/templatemo.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js"></script>

<script>

    function checkLogin(){
        var userlogin = localStorage.getItem('name');
        if(userlogin == null){
            $(".dropdownUser2").remove();
            $(".dropdown-toggle").remove();
        }else{
            $("#usernonlogin").remove();

        }
        $("#my-profile").html(userlogin);
    }

    setTimeout(function(){
        checkLogin();
        $("#usernonlogin").on('click',function(){
            console.log('ok')
            $("#modalLogin").modal('show');
            return false;
        });
    },100)

</script>