<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"><!--
<link rel="stylesheet" href="{{asset('css/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('css/modal3.css')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900"> -->
<!-- 
<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/assets/css/slider.css">
<link rel="stylesheet" type="text/css" href="{{env('APP_URL')}}/assets/css/menu.css">
-->

<!-- <style>
    #loading-screen {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: rgba(0,0,0, 0.5);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
        width: 100%;
      }
  
    #loading-screen img{
        width: 60%;
        max-width: 250px;
        height: auto;
        animation: drotate 3s linear infinite;
      }
      
    @keyframes drotate{
      from {
        transform: rotateY(0deg);
    
        filter: drop-shadow(0 0 0.1rem rgba(255, 255, 0, 0.3));
    
      }
      to {
        transform: rotateY(360deg);
        filter: drop-shadow(0 0 0.1rem rgba(255, 255, 0, 1));
      }
      
    }

    div:where(.swal2-container) .swal2-html-container{
      color:white !important;
    }
</style> -->
<style>

</style>
<script>
	 function loadPage(path){
        //showLoading();
        $.ajax({
            url: "/"+path,
            type: "GET",
            success: function (response) {
                //$('#navi-menu .menu-item').removeClass('active');
				if(response.success == true){
					$('#content').html();
            
			window.history.pushState({}, '', '/'+path); 
				
				}
				else{
						if(response.message == 'login'){
						console.log('login first');
					}
					else{
						alert('response.message');
					}
				}
             

               
             
            },
            error: function () {
                alert("Failed to load "+path+".");
            },
            complete: function(){
             //   hideLoading();
            }
        });
    }
</script>