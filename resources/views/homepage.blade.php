<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Companion </title>
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="{{ asset('vendor/magnific-popup/magnific-popup.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/creative.min.css') }}" rel="stylesheet">

    

  </head>

  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top"></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="{{ url('/login') }}">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="{{ url('/userType') }}">Register</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header class="masthead text-center text-white d-flex" style="background-image: url('../image/header.jpg');">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <h1 class="text-uppercase">
              <strong>Welcome to Companion!</strong>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
            <p class="text-faded mb-5">Feel free to post what you feel and facilators will help you. Join on events that interests you and have fun doing activitites with other fascinating people. </p>
            <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Find out more</a>
          </div>
        </div>
      </div>
    </header>

     <div id="about" class = "p-4">
      <div class="p-4">
           <div class = "p-3" style="color: #5b6a6e">
           <h1><b>Facts</b></h1>
           </div>
        <div class="row">
          <div class = "col-sm-4 mb-3 sr-contact" >
            <div class="w-100 p-4 bg-primary"  id="border" style="color:#ffff">
              <h3><b>Did You Know?</b></h3>
              <div class = "row m-0" >
                <div class="col-sm-6">
                <img src = "../image/friends (1).png" class="p-3">
                </div>
                <div class="col-sm-6" style="font-size:20px">
                <p><b>Loneliness does not depend on how many friends or relationships you have</b></p>
                </div>
                <p>Loneliness depends entirely on the subjective quality of your relationships—on whether you feel
                emotionally and/or socially disconnected from those around you. </p>
              </div>
            </div >
          </div>

          <!-- <div class = "col-sm-8  mb-3 sr-contact" >
            <div class="w-100 p-4" id="border">
              <h3><b>Social Networks</b></h3>
              <div class = "row m-0" >
                <div class="col-sm-6">
                <img src = "../image/network (1).png"  class="p-2">
                </div>
                <div class="col-sm-6" style="font-size:20px">
                <p><br><b>Loneliness is contagious in social networks</b></p>
                </div>
                <p>Loneliness has a clear stigma: We tend to be able to spot and identify the lonely people around us. 
                One study found that over a six-month period, lonely people were pushed to the periphery of social networks and 
                surprisingly, so were their friends. 
                </p>
              </div>
            </div >
          </div> -->

          <div class = "col-sm-8 mb-3 sr-contact">
            <div class="w-100 p-4" id="border">
            <div class = "row m-0" >
            <div class = "col-sm-6">
              <h3><b>10% of people aged 16 to 24</b></h3>
            </div>
            <div class = "col-sm-6">
            <img src = "../image/broken-heart.png">
            <img src = "../image/couple (1).png">
            <img src = "../image/idea.png">
            </div>
            </div>
              <div class = "row m-0" >
              <div class="col-sm-7" style="font-size:20px">
                <p><br><b>were "always or often" lonely - the highest proportion of any age group.
                This was more than three times higher than people aged 65 and over.
                Researchers suggest that older people might become more "resilient" to worries about loneliness</b></p>
                </div>
                <div class="col-sm-5 p-3">
                <img src = "../image/sad.png">
                </div>
              </div>
            </div >
          </div>
          
        </div>
      </div>
    </div>  -->

    <div id="about" class="h-50" style="background-image: url('../image/inspired.jpg');background-repeat: no-repeat; background-size:100%;">
      <div class="p-4">
           <div class = "p-3">
           <h1><b>Inspiration</b></h1>
           </div>
          
          <div class = "col-sm-8 mb-3 sr-contact">
            <div class="w-100 h-200 p-4" style = "position:relative;left:500px">
            <p style="font-size: 20px"><b>Happiness is not something you have to achieve.<br> You can still be happy during
            the process of achieving something. <br>So if you change your perspective a little bit,
            I know that many of you are going through tough<br> times right now, but this could be the
            most beautiful moment of our lives.</b></p>
              
            </div >
          </div>
          
        </div>
      </div>
    </div>

    <div class="p-4">
    <div class = "p-3">
           <h1><b>Testimonies</b></h1>
           </div>
   
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
    
      <div class="item active">
      <div class="row">
        <div class="col-sm-3 p-4 " style="background-color:#f87d7e; height: 300px; position:relative;left:100px" id="border">
          <img src="../image/jungkook.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity center">
          <h3 class="center" style="position:relative;left:30px; color:#ffff">Justin Seagull</h3>
          <p style="font-size: 15px; color:#ffff">I made many friends and I gained confidence thanks to this application!</p>
        </div>
        <div class="col-sm-3 p-4" style="background-color:#45b2cd; height: 300px; position:relative;left:150px;" id="border">
          <img src="../image/vante.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity center">
          <h3 class="center" style="position:relative;left:30px; color:#ffff">Kim Vante</h3>
          <p style="font-size: 15px; color:#ffff">This website is so nice. I was able to face my problems and solve them.</p>
        </div>
        <div class="col-sm-3 p-4" style="background-color:#fabf84; height: 300px; position:relative;left:200px;" id="border">
          <img src="../image/lisa.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity center">
          <h3 class="center" style="position:relative;left:30px; color:#ffff">Lalisa Manoban</h3>
          <p style="font-size: 15px; color:#ffff">I am happy right now thanks to this website that recommended me to my facilitator!</p>
        </div>
        
      </div>
    </div>
      <div class="item">
      <div class="row">
        <div class="col-sm-3 p-4 " style="background-color:#f87d7e; height: 300px; position:relative;left:100px" id="border">
        <img src="../image/jennie.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity center">
          <h3 class="center" style="position:relative;left:20px; color:#ffff">Jenny Kim</h3>
          <p style="font-size: 15px; color:#ffff">This website helped a lot of people like me! It lifted up my spirit</p>
        </div>
        <div class="col-sm-3 p-4" style="background-color:#45b2cd; height: 300px; position:relative;left:150px;" id="border">
        <img src="../image/vernon.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity center">
          <h3 class="center" style="position:relative;left:20px; color:#ffff">Vernon di Caprio</h3>
          <p style="font-size: 15px; color:#ffff">I can say that this website really helped me a lot especially in my lonely days!</p>
        </div>
        <div class="col-sm-3 p-4" style="background-color:#fabf84; height: 300px; position:relative;left:200px;" id="border">
        <img src="../image/somi.jpg" alt="Boss" style="width:45%" class="w3-circle w3-hover-opacity center">
          <h3 class="center" style="position:relative;left:20px; color:#ffff">Ennik Douma</h3>
          <p style="font-size: 15px; color:#ffff">This website made my day!</p>
        </div>
        
      </div>
      </div>
    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
<div style="background-color:#ffff; height: 20px">

</div>

    <section id="contact" style="padding: 1rem 0;background-color: #254450" class="p-4">
      <div class="container">
      <div class = "p-3">
           <h1 style="color:#ffff"><b>Contact Us</b></h1>
           </div>
        <!-- <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading">Let's Get In Touch!</h2>
            <hr class="my-4">
            <p class="mb-5">Ready to start your next project with us? That's great! Give us a call or send us an email and we will get back to you as soon as possible!</p>
          </div>
        </div> -->
        <div class="row">
          <div class="col-lg-4 ml-auto text-center">
            <h3 style="color:#ffff"><b>Suicide Hotline</b></h3>
            <i class="fa fa-phone fa-3x mb-3 sr-contact"></i>
            <p style="font-size: 20px; color:#ffff"><b>804 4673</b></p>
          </div>
          <div class="col-lg-4 mr-auto text-center">
          <h3 style="color:#ffff"><b>Email</b></h3>
            <i class="fa fa-envelope-o fa-3x mb-3 sr-contact"></i>
            <p>
              <a href="mailto:your-email@your-domain.com">companion@gmail.com</a>
            </p>  
          </div>
        </div>
      </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{ asset('vendor/scrollreveal/scrollreveal.min.js') }}"></script>
    <script src="{{ asset('vendor/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

    <!-- Custom scripts for this template -->
    <script src="{{ asset('js/creative.min.js') }}"></script>

  </body>

</html>
