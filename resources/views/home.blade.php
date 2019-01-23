<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>{{config('swagger-lume.api.title')}}</title>


        <link rel="stylesheet" type="text/css" href="home-assets/vendor/bootstrap/css/bootstrap.min.css" >
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i" rel="stylesheet">

                <link href="home-assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" >

        <link rel="stylesheet" type="text/css" href="home-assets/css/coming-soon.min.css" >
        
    </head>

    <body>

        <div class="overlay"></div>
        <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="home-assets/mp4/bg.mp4" type="video/mp4">
        </video>

        <div class="masthead">
            <div class="masthead-bg"></div>
            <div class="container h-100">
                <div class="row h-100">
                    <div class="col-12 my-auto">
                        <div class="masthead-content text-white py-5 py-md-0">
                            <h1 class="mb-3">{{config('swagger-lume.api.title')}}</h1>

                            <p class="mb-5">Desarrollo de sistema de autogestión de conocimiento como herramienta informática inclusiva Open source que favorezca el aprendizaje de estudiantes con discapacidad auditiva leve de tercer nivel de educación superior</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="social-icons">
            <ul class="list-unstyled text-center mb-0">
                <li class="list-unstyled-item">
                    <label for="docs">Documentación</label>
                    <a href="{{route('swagger-lume.docs')}}" id="docs">
                        <i class="fab fa-gratipay"></i>
                    </a>
                </li>
                <li class="list-unstyled-item">
                    <label for="api">API</label>
                    <a href="{{route('swagger-lume.api')}}" id="api">
                        <i class="fab fa-calendar"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Bootstrap core JavaScript -->
        <script src="home-assets/vendor/jquery/jquery.min.js"></script>
        <script src="home-assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Custom scripts for this template -->
        <script src="home-assets/js/coming-soon.min.js"></script>

    </body>

</html>
