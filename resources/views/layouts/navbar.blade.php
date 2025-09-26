<!-- <style>
    .rounded-input {
        border-radius: 20px;
        border: 1px solid #ced4da;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .shadow-orange-button {
        box-shadow: 0 .25rem .5rem rgba(249, 115, 22, 0.2);
    }

    .btn-warning {
        background-color: #fb923c;
        border-color: #f97316;
        color: white;
    }

    .btn-warning:hover {
        background-color: #f97316;
        border-color: #f97316;
    }

    .btn-warning:focus {
        box-shadow: 0 0 0 .25rem rgba(251, 146, 60, 0.5);
    }

    @media (min-width: 768px) {
        .input-location {
            max-width: 150px;
        }
    }
</style>

<nav class="navbar navbar-expand-lg bg-white border-bottom py-2">
    <div class="container-fluid d-flex align-items-center justify-content-between">
    
        <a class="navbar-brand d-flex flex-column align-items-start me-3" href="#">
            <img src="https://www.likeme.co.in/storage/images/likemelogo.webp" alt="LikeMe" style="height: 40px;">

        </a>

     

        <form class="d-flex flex-grow-1 mx-2 mx-md-4" role="search">
            <div class="input-group">
                
                <input type="text" class="form-control rounded-input input-location" placeholder="Delhi"
                    aria-label="Location">
                <span class="input-group-text d-none d-md-block bg-white border-0"><i class="bi bi-geo-alt"></i></span>

          

                <div class="position-relative flex-grow-1 ms-3">
                    <input type="text" class="form-control rounded-input" placeholder="Search" aria-label="Search">
                    <span class="position-absolute top-50 end-0 translate-middle-y me-2"><i
                            class="bi bi-mic text-muted"></i></span>
                    <span class="position-absolute top-50 end-0 translate-middle-y me-5"><i
                            class="bi bi-search text-muted"></i></span>
                </div>
            </div>
        </form>

     
        <div class="d-flex align-items-center ms-2 ms-sm-4">
          
            <div class="d-none d-lg-flex flex-column align-items-end me-4">
                <button class="btn btn-sm btn-warning shadow-orange-button mb-1">Create Seller Account</button>
                <button class="btn btn-sm btn-outline-secondary border-gray-500 rounded-pill"
                    style="font-size: 0.75rem;">Advertise</button>
            </div>

         

            <div class="d-flex align-items-center d-none d-lg-flex me-4">
                <img src="https://via.placeholder.com/32" alt="User" class="rounded-circle me-1"
                    style="height: 32px; width: 32px;">
                <span class="text-sm">Login/Sign Up</span>
            </div>

     

            <a href="tel:9662596625"
                class="btn btn-sm btn-warning d-none d-md-flex align-items-center shadow-orange-button">
                <i class="bi bi-telephone me-1"></i> Dial 96625 96625
            </a>
        </div>
    </div>
</nav> -->
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-bottom_color fixed-top">
        <div class="container-fluid">
          <a class="navbar-brand img-fluid rounded-4" href="https://www.likeme.co.in" alt="img" widht="188" height="60" aria-label=" brand-logo">
              <img src="https://www.likeme.co.in/storage/images/likemelogo.webp" alt="LikeMe" widht="188" height="60" decoding="async" data-nimg="intrinsic" class="object-fit-cover">
              </a>
        
        <button class="navbar-toggler" onclick="sfunc()" id="tbutton"><i class="bi bi-list"></i></button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="location-nav navbar-nav mb-2 mb-lg-0">
              <li class="dropdown">
                <form action="https://www.likeme.co.in/search" id="search_form" method="GET" onsubmit="return submitform();">
                <input type="hidden" name="_token" value="BGx2QDOa9d2T3sDnlUG3KznDgLYahuT1ud7U5MhL">                    <div class="dropdown text-center"> 
                    <lable for="new_location" class="d-none">Location</lable>
                        <!--<input oninput="location_change(this)" type="text" name="new_location"-->
                        <!--onclick="removelocationtxt()" value="delhi" name=""-->
                        <!--class="selectcity rounded-4 shadow-none border" id="new_location" data-bs-toggle="dropdown" aria-expanded="false" autocomplete="off" onkeydown="location_keydown(this)"/>-->
                        
                        <input oninput="location_change(this)" type="text" name="new_location" onclick="removelocationtxt()" value="delhi" class="selectcity rounded-4 shadow-none border" id="new_location" data-bs-toggle="dropdown" aria-expanded="false" autocomplete="off" onkeydown="location_keydown(this)" style="margin-top: 2px;">
                        
                        <ul class="dropdown-menu" id="location_ul">
                            <li>
                                <a href="javascript:getcurrentLocation()" aria-label="select" class="dropdown-item">
                              <span><i class="bi bi-crosshair me-2"></i></span>
                              Select Your Current Location
                            </a>
                          </li>
                        </ul>
                      </div>
              </form></li>
            </ul>
           <script>
           
             document.getElementById("new_location").addEventListener("keydown", function(event) {
            // Check if the Enter key is pressed
            if (event.key === "Enter") {
                event.preventDefault(); // Prevent form submission if inside a form
                handleSearch(event.target.value); // Call your function with the input value
            }
        });
        
        function handleSearch(val) {
                   var currentRequest = null;    
                  currentRequest = jQuery.ajax({
                                           type:'GET',
                                           url:'/ajax/select_city/'+val+"?selected=true",
                                           data:{},
                                           beforeSend : function()    {           
                                                if(currentRequest != null) {
                                                    currentRequest.abort();
                                                }
                                            },
                                           success:function(data) {
                                               
                                               if(data == ""){
                                                 data = "delhi";  
                                               }
                                                setCookie('CUR_CITY',data,30);
                                                                setCookie('CUR_AREA',data,30);
                                                                
                                                                setCookie('NEW_CUR_CITY', data,30);
                                                             //  current_area.innerHTML = data;
                                                              new_location.value=data;
                                                              
                                                              
                                                              if(window.location.href.includes("lmid")){
                                                                  window.location.href = updateUrlFromWord(window.location.href,data);
                                                              }else{
                                                                  if(window.location.href.includes("?")){
                                                                    window.location.href = window.location.href + "&new_location="+data; 
                                                                  }else{
                                                                      window.location.href = window.location.href + "?new_location="+data;
                                                                  }
                                                              }
                                                
                                             
                                           }
                                        });
        }
           
           function location_keydown(ele) {
                // if(event.key === 'Enter') {
                //   ele.value = document.getElementById('first_li').innerHTML;   
                //   window.location.href= document.getElementById('first_li').href;
                   
                // }
            }
           
            function location_change(e){
                var text = e.value;
                var currentRequest = null;    
                  currentRequest = jQuery.ajax({
                           type:'GET',
                           url:'/ajax/select_city/'+text,
                           data:{ss:text},
                            beforeSend : function()    {           
                                if(currentRequest != null) {
                                    currentRequest.abort();
                                }
                            },
                           success:function(data) {
                               
                                if(data != ''){
                                    document.getElementById('location_ul').classList.add("show");    
                                     document.getElementById('location_ul').innerHTML=data;
                                }else{
                                    document.getElementById('location_ul').classList.remove("show");
                                }
                                
                               
                           }
                        });
                    }
           
                //   var input = document.getElementById("new_location");
                //   //Optional if you have data
                //     input.addEventListener('keypress', function(e){
                       
                //       if(e.keyCode == 13){
                //             var options = Array.from(document.getElementById("datalist_location").options).map(function(el){
                //     return el.innerHTML;
                //     });
                //         var relevantOptions = options.filter(function(option){
                //           return option.toLowerCase().includes(input.value.toLowerCase());
                //         }); // filtering the data list based on input query
                       
                //         if(relevantOptions.length > 0){
                //           document.getElementById("new_location").value = relevantOptions.shift();
                //           var lataz =  document.getElementById("lat").value;
                //              var longaz =  document.getElementById("long").value;
                //              //alert(relevantOptions.shift());
                //             $.ajax({
                //                   type:'GET',
                //                   url:'/admin/get_area?lat='+lataz+"&long="+longaz+"&city="+relevantOptions.shift(),
                //                   data:{},
                //                   success:function(data) {
                                        
                //                         setCookie('CUR_CITY',relevantOptions.shift(),30);
                //                         setCookie('CUR_AREA',data,30);
                                        
                //                         setCookie('NEW_CUR_CITY',data  +" " + relevantOptions.shift(),30);
                                   
                //                       document.getElementById("new_location").value=data  +" " + relevantOptions.shift();
                //                          location.reload();
                //                   }
                //                 });
                           
                //         }
                //       }
                //     });
           </script>
           
   
            <div class="action-link d-flex flex-column flex-fill gap-0">
              <div class="nav-btn text-end yourElement" style="display: block;">
                                   

                  <a href="https://www.likeme.co.in/seller" class="btn btn-primary btn-sm loading overflow-hidden">Create Seller Account <span class="badge bg-secondary">Free</span></a>
                  
                                    <a href="https://www.likeme.co.in/advertise" class="btn btn-outline-primary btn-sm">Advertise</a>
                  
              </div>
              
              
            
              <div class="d-flex align-items-center">
                <div class="d-flex global-search">
               <section class=" search widthgbsearch mx-auto">
        <div class="containeer">
            <div class="row px-2">
                <div class="col-12 d-flex align-items-center rond  justify-content-between">
                    <!-- search-icon -->
                    <div class="col d-flex align-items-center px-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                        </svg>
                  
                        <!-- search-icon -->
                        <!-- input-field-x -->
                        <div class="col">
                            <input type="search" oninput="searchOnInput()" id="search" autocomplete="off" name="search" required="" value="" class="searchbar border-0" placeholder="e.g. Hote">
                            <button type="submit" class="d-none"></button>
                        </div>
                        <!-- input-field -->
                    </div>
                <!-- rest-icons -->
                <div class="d-flex align-items-center gap-2 justify-content-end pe-0">
                    <div class="col px-0 d-flex justify-content-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" id="newdiva" class="" onclick="searchremove()" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
                            </svg>
                            <a href="javascript:runSpeechRecog()">
                                <img src="https://www.likeme.co.in/webpage/images/microphone.gif" alt="microphone gif" class"microphoneee"="" width="30px" height="30px">        
                            </a>
                        
                    </div>
                    
                </div>
                
                <!-- rest-icons -->
                </div>
            </div>
        </div>
    </section>
    <section class="result-show position-absolute" id="resultSection" style="display: none;">
        <div class="container">
            <div class="row px-2">
                <div class="col-12 bg-white rond border">
                    <ul id="newul">
                    </ul>
                </div>
            </div>
        </div>
    </section>
    

    
   
<!--thku modaL-->
   

                     <input type="hidden" id="lat" name="lat">
                          <input type="hidden" id="long" name="long">
</div>
 
                <ul class="navbar-nav mb-2 mb-lg-0 ms-auto float-end nav-inline-fix" data-bs-toggle="dropdown" aria-expanded="true">
                  <script>
                       var login_popup_open  = "0";
                  </script>
                
                  <li class="signup-link d-flex gap-2 align-items-center">
                      <img src="https://www.likeme.co.in/public/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                     <button type="button" class="btn btn-link text-decoration-none p-1 py-0 text-dark fw-bold" id="loginModalBtn" data-bs-toggle="modal" data-bs-target="#staticBackdropza">
                      Login/Sign Up
                  </button>
                </li>
                                                <script>
                    function newfunction(){
                      login_popup_open  = "1";
                    }
                </script>
            
              </ul>
              </div>
              
              <div class="customer-care ms-auto yourElement" style="display: block;">
                <div class="phone-icon"><i class="icon-phone"></i></div>
                  <span class="contact-fix">Dial <a href="tel:96625-96625" class="fix-phone"> 96625 96625</a></span>
              </div>
            </div>
          </div>
        </div>
      </nav>