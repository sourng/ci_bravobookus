<!DOCTYPE HTML>
<html>

<head>
    <title>Bravobookus - Hotels</title>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Template, html, premium, themeforest" />
    <meta name="description" content="Traveler - Premium template for travel companies">
    <meta name="author" content="Tsoy">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <?php 
    if(isset($style_home)){
        $this->load->view($style_home);
    }
    ?>
</head>

<body>
    <!-- FACEBOOK WIDGET -->
    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- /FACEBOOK WIDGET -->
    <div class="global-wrap">
        <header id="main-header">
            <?php 
            if(isset($header_top)){
                $this->load->view($header_top);
            }
            ?>
            <div class="container">
            <?php 
                if(isset($nav)){
                    $this->load->view($nav);
                }
            ?>
            </div>        
        </header>
<!--main Page-->


        <div class="container">
            <?php 
                if(isset($page)){
                    $this->load->view($page);
                }
            ?>
            
        </div>



        <footer id="main-footer">
            <?php 
                if(isset($footer)){
                    $this->load->view($footer);
                }
            ?>
        </footer>

        <!-- Script Footer -->
        <?php 
            if(isset($script_footer_home)){
                $this->load->view($script_footer_home);
            }
        ?>

    </div>
</body>

</html>


