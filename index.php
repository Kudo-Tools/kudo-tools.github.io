<?php

session_start();
$_SESSION;

require("functions/connection.php");
require("functions/methods.php");

$con = establish_connection();
$button_text = check_login_homepage($con); 
$availability = NULL;
$stock_pass = "general";
$matchFound = (array_key_exists("pass", $_GET));
if($matchFound) {
    $stock_pass = htmlspecialchars($_GET["pass"]);
    if(!empty($stock_pass)) {
        $amt = get_stock_availibility($con, $stock_pass);
        if($amt > 0) {
            $availability = $amt . " licenses available";
        } else {
            $availability = "no licenses available";
        }
    } else {
        $amt = get_stock_availibility($con, "general");
        if($amt > 0) {
            $availability = $amt . " licenses available";
        } else {
            $availability = "no licenses available";
        }
    }
} else {
    $amt = get_stock_availibility($con, "general");
    if($amt > 0) {
        $availability = $amt . " licenses available";
    } else {
        $availability = "no licenses available";
    }
}

?>
<html>
    <head>
        <title>Kudo</title>
        <link href="src/styles/main.css" rel="stylesheet" type="text/css">
        <link href="src/styles/header.css" rel="stylesheet" type="text/css">
        <link href="src/styles/body.css" rel="stylesheet" type="text/css">
        <link href="src/styles/BigTitle.css" rel="stylesheet" type="text/css">
        <link href="src/styles/mainImage.css" rel="stylesheet" type="text/css">
        <link href="src/styles/mainInfo.css" rel="stylesheet" type="text/css">
        <link href="src/styles/features.css" rel="stylesheet" type="text/css">
        <link href="src/styles/customization.css" rel="stylesheet" type="text/css">
        <link href="src/styles/FAQ.css" rel="stylesheet" type="text/css">
        <link href="src/styles/footer.css" rel="stylesheet" type="text/css">
        <script src="src/js/features.js"></script>

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"> -->
    </head>
    <body>
        <header>
            <img class="logo" onclick="window.location='https://www.kudotools.com/'" src="images/LoginKudo.png" alt="logo">
            <nav>
                <ul class="navigation">
                    <li><a href="#features">features</a></li>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#social">social media</a></li>
                    <li><a href="" download="Kudo Tools">download</a></li>
                </ul>
            </nav>
            <div class="right_header">
                <div onclick="location.href='login'" class="login_button">
                    <a  href="#"><button><?php echo $button_text; ?></button></a>
                </div>
                <a onclick="location.href='signup?pass=<?php echo $stock_pass?>'" class="sign_up">sign up</a>
               
            </div>
        </header>
        <body>
            <div class="container">
                <div class="content">
                    <div class="big_title">
                        <h1>Reselling Managed</h1>
                        <p>Use an automated toolbox to make your reselling career simple</p>
                    </div>
                    <div class="button_container">
                        <button onclick="location.href='signup?pass=<?php echo $stock_pass?>'" id="purchase"><?php echo $availability;?></button>
                        <button onclick="location.href='#information';" class="learn_more">learn more
                            <i class="arrow right"></i>
                        </button>
                    </div>
                    <div  class="main_section">
                        <div id="information" class="information_container">
                            <div class="information" style="width: 400px;">
                                <h1>Grouping</h1>
                                <p>Easily categorize all your tasks 
                                    with built in task grouping</p>
                            </div>
                            <div class="information" style="width: 500px;">
                                <h1>Quick and Simple</h1>
                                <p>With a easy-to-use user interface, reselling
                                    is easier to manage then ever</p>
                            </div>
                            <div class="information" style="width: 400px;">
                                <h1>Unlimited</h1>
                                <p>Run as many tasks as your computer can handle</p>
                            </div>
                        </div>

                        <div class="image_container">
                            <div class="image_outline">
                                <img class="main_ui" src="images/whiteImage.png" alt="logo">
                            </div>
                        </div>
                    </div>
                    <div id="features" class="features_container">
                        <div class="selection_container">
                            <div class="selectors" onclick=showSlide(0)>
                                <img class="icon" src="images/ReCaptcha.png" alt="logo">
    
                                <a class="selector_titles">Email Harvesters</a>
                                <p class="selector_description">farm infinite email 
                                    accounts to achieve 
                                    one clicks <br> view test results with an in built ReCaptcha tester</p>
                            </div>
                            <div class="selectors" onclick=showSlide(1)>
                                <img class="icon" src="images/Profiles.png" alt="logo">
    
                                <a class="selector_titles">Profile Converter</a>
                                <p class="selector_description">easily manage your profiles with various tools <br>
                                import and export with 1 click</p>
                            </div>
                            <div class="selectors" onclick=showSlide(2)>
                                <img class="icon" src="images/Inventory.png" alt="logo">
    
                                <a class="selector_titles">Inventory Manager</a>
                                <p class="selector_description">quickly add products and view profit margins <br>see realtime asks and bids</p>
                            </div>
                        </div> 
                        <div class="slides_container">
                            <div class="slide">
                                <div class="left_information">
                                    <br>
                                    <br>
                                    <strong>Activity Generator</strong>
                                    <p>Generate human parallel activity on all your gmails automatically. 
                                        <br> With built in sleep, break, and wakeup times, you can leave 
                                        <br> accounts running for hours on end</p>
                                    <br>
                                    <br>
                                    <div style="float:left; margin-right: 30px;">
                                        <strong>Password Changer</strong>
                                        <p>Change your gmail passwords <br> in 
                                             masses</p>
                                    </div>
                                    <!-- <br>
                                    <br> -->
                                    <div style="float:left">
                                        <strong>ReCAPTCHA Tester</strong>
                                        <p>Easily test your gmail ReCAPTCHA v2
                                            <br>  and ReCAPTCHA v3 scores</p>
                                    </div>
                                    
                                </div>
                                <img class="slide_image" src="images/Harvesters.png">
                                <!-- <div class="right_information"></div> -->
                            </div>
                            <div class="slide">
                                <div class="left_information">
                                    <br>
                                    <br>
                                    <strong>Direct Convert</strong>
                                    <p>With a single click of a button, directly export profiles to <br> your favorite bots save files</p>
                                    <br>
                                    <br>
                                    <div style="float:left; margin-right: 30px;">
                                        <strong>Import Detection</strong>
                                        <p>Drag and drop your profiles and Kudo 
                                            <br>will automatically identify the imports</p>
                                    </div>
                                    <!-- <br>
                                    <br> -->
                                    <div style="float:left; margin-top: 30px;">
                                        <strong>Random Profile Creation</strong>
                                        <p>Create profiles with jigged addresses<br> and/or random phone numbers <br> as well as randomized catchalls</p>
                                    </div>
                                    <br>
                                    <br>
                                    <strong>Multi-Bot Export</strong>
                                    <p>Select multiple bots to export your profiles to</p>
                                    <br>
                                    <br>
                                </div>
                                <img class="slide_image" src="images/ProfilesPage.png">
                                <!-- <div class="right_information"></div> -->
                            </div>
                            <div class="slide">
                                <div class="left_information">
                                    <br>
                                    <br>
                                    <strong>Item Tracker</strong>
                                    <p>Quickly add new products with a couple clicks using <br> the built in product searcher</p>
                                    <br>
                                    <br>
                                    <div style="float:left; margin-right: 30px;">
                                        <strong>Live Prices</strong>
                                        <p>Get a products live bids / asks <br> automatically or with a click of a button</p>
                                    </div>
                                    <!-- <br>
                                    <br> -->
                                    <!-- <div style="float:left">
                                        <strong>ReCAPTCHA Tester</strong>
                                        <p>Easily test your gmail ReCAPTCHA v2
                                            <br>  and ReCAPTCHA v3 scores</p>
                                    </div> -->
                                    
                                </div>
                                <img class="slide_image" src="images/InventoryPage.png">
                                <!-- <div class="right_information"></div> -->
                            </div>
                        </div>
                    </div>
                    <div id="customization" class="customization custom_container">
                        <div class="image_container">
                            <img class="image image_1" src="images/TitleImage.png">
                            <img class="image image_2" src="images/whiteImage.png">
                            <img class="image image_3" src="images/Blue.png">
                        </div>
                        <div class="text_container">
                            <a class="custom_title">Control Your Look</a>
                            <p>Various user interface color options available.<br>
                            Easily switch between color layouts to <br> 
                            choose the right color for you</p>
                        </div>
                    </div>
                    <div id="faq" class="FAQ_section">
                        <div style="margin-top: 100px;"></div>
                        <div class="row_parent">
                            <div class="FAQ_item first_item">
                                <!-- <img class="feature_icon" src="images/RedInventory.png"> -->
                                <div class="feature_title">Where can I download Kudo?</div>
                                <div class="feature_description">
                                    You can download Kudo for free at
                                    <br>
                                    <a style="background: transparent; color: #60a2ff; text-decoration: underline;"href="https://www.kudotools.com/download">https://www.kudotools.com/download</a>
                                    <br>
                                    <br>
                                    Download the zip file, then unzip it, and run the Kudo.exe to launch the application
                                </div>
                            </div>
                            <div class="FAQ_item second_item">
                                <!-- <img class="feature_icon" src="images/RedCard.png"> -->
                                <div class="feature_title">How much is Kudo?</div>
                                <div class="feature_description">
                                    For the time being, Kudo is free to all users
                                    <br>
                                    However this is subject to change in the future
                                    <br>
                                    All members will be alerted if any changes are to occur
                                </div>
                            </div>
                        </div>
                         <div class="row_parent">
                            <div class="FAQ_item third_item">
                                <!-- <img class="feature_icon" src="images/RedCaptcha.png"> -->
                                <div class="feature_title">What is the future of Kudo?</div>
                                <div class="feature_description">
                                    <!-- <br> -->
                                    Kudo started only as a simple ReCaptcha harvester but has grown to be much more   
                                    <br>
                                    The developer team will continue to grow Kudo with new features and pefections
                                    <br>
                                    With an endless list of helpful features, Kudo is planned to constantly be receiving new additions
                                    <br>
                                    <br>
                                    <strong style="background: transparent; color: white; margin-right: 10px;">Have a suggestion?</strong>
                                    <!-- <br> -->
                                    Feel free to share it in suggestions channel of the Kudo discord 
                                </div>
                            </div>
                            <div class="FAQ_item fourth_item">
                                <!-- <img class="feature_icon" src="images/RedArrow.png"> -->
                                <div class="feature_title">Is there a dashboard?</div>
                                <div class="feature_description">
                                    There is a dashboard for each individuals key
                                    <br>
                                    You can access yours at
                                    <br>
                                    <a style="background: transparent; color: #60a2ff; text-decoration: underline;"href="https://www.kudotools.com/dashboard">https://www.kudotools.com/dashboard</a>
                                    <br>
                                    Through the dashboard, you can connect your discord account to Kudo
                                </div>
                            </div>
                        </div>
                        <div class="row_parent">
                            <div class="FAQ_item fith_item">
                                <!-- <img class="feature_icon" src="images/RedVan.png"> -->
                                <div class="feature_title">Where should I go for support?</div>
                                <div class="feature_description">
                                    For any help/support, you can create a ask in the corresponding 
                                    <br>
                                    chat in the Kudo 
                                    <a style="background: transparent; color: #60a2ff; text-decoration: underline;"href="https://discord.gg/9RVJ4MR3Ws">discord server</a>
                                    <br>
                                    <br>
                                    <strong style="background: transparent; color: white; margin-right: 10px;">Need 1 on 1 support?</strong>
                                    <!-- <br> -->
                                    <br>
                                    Create a ticket in the discord and wait for 
                                   staff to assist you
                                </div>
                            </div>
                            <div class="FAQ_item sixth_item">
                                <!-- <img class="feature_icon" src="images/RedKey.png"> -->
                                <div class="feature_title">What operating systems work with Kudo?</div>
                                <div class="feature_description">
                                    Currently, only Windows 10 operating systems have been tested and are supported. 
                                    <br> 
                                    An expansion of more operating systems is planned for the future
                                </div>
                            </div>
                        </div> 
                        <div id="social" class="footer-basic">
                            <footer style="background: transparent;">
                                <div class="social_title">
                                    <h1>Social Media</h1>
                                </div>
                                <br>
                                <div class="wrapper">
                                    <div onclick="location.href='https://twitter.com/KudoTools';" class="icon twitter">
                                        <div class="tooltip">Twitter</div>
                                        <span style="background: transparent;"><i class="fab fa-twitter"></i>
                                            <img class="social_media_icon" src="images/Twitter.png">
                                        </span>
                                    </div>
                                    <!-- <div class="icon instagram">
                                      <div class="tooltip">Instagram</div>
                                        <span style="background: transparent;"><i class="fab fa-instagram"></i>
                                            <img class="social_media_icon" src="images/Instagram.png">
                                        </span>
                                    </div> -->
                                    
                                    <div onclick="location.href='https://github.com/TeedsK/Kudo-Download/releases';" class="icon github">
                                      <div class="tooltip">Github</div>
                                        <span style="background: transparent;"><i class="fab fa-github"></i>
                                            <img class="social_media_icon" src="images/Github.png">
                                        </span>
                                    </div>
                                    <!-- <div class="icon youtube">
                                      <div class="tooltip">Youtube</div>
                                        <span style="background: transparent;"><i class="fab fa-youtube"></i>
                                            <img class="social_media_icon" src="images/Youtube.png">
                                        </span>
                                    </div> -->
                                  </div>
                            </footer>
                        </div>
                    </div>
                    
                </div>
                
            </div>
            
        </body>
    </body>
</html>