<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 Error - Page not found | Artistic designing</title>
    <link rel="shortcut icon" type="image/x-icon" href="http://artisticdesigning.com/images/logo-compressed.png" />
    <style>
        body{
            margin: 0;
            background-color: #222;
            color: white;
            font-family: helvetica;
        }
        *{
            box-sizing: border-box;
            text-align: center;
        }
        div.left, div.right{
            display: inline-block;
            width: 50%;
            padding: 70px 0;
        }
        div.txt{
            width: 100%;
        }
        h1,h2,h3,h4,h5,h6{
            margin: 0;
            font-weight: 600;
        }
        h1{
            font-size: 180px;
        }
        h2{
            font-size: 40px;
        }
        h3{
            font-size: 36px;
        }
        h4{
            margin-top: 60px;
            font-size: 44px;
            color: #ccc;
        }
        h5{
            margin-top: 5px;
            font-size: 24px;
            color: #ccc;
        }
        h6{
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 48px;
            text-align: left;
            padding-left: 80px;
        }
        ul a{
            color: #fff;
            font-size: 22px;
            text-decoration: none;
            transition: 0.2s ease-in-out;
        }
        ul a:hover{
            margin-left: 12px;
        }
        ul{
            list-style: none;
            padding-left: 100px;
        }
        ul li{
            padding: 5px;
            text-align: left;
        }
        .right img{
            height: 350px;
            vertical-align: bottom;
            transform-origin: top center;
        }
        @keyframes rotate{
            0%{
                transform: rotate(0deg);
            }
            15%{
                transform: rotate(45deg);
            }
            30%{
                transform: rotate(-45deg);
            }
            45%{
                transform: rotate(30deg);
            }
            60%{
                transform: rotate(-30deg);
            }
            75%{
                transform: rotate(15deg);
            }
            90%{
                transform: rotate(-15deg);
            }
            100%{
                transform: rotate(0deg);
            }
        }
        body > a > img{
            filter: drop-shadow(3px 3px 14px rgba(0,0,0,0.6));
            margin: 20px 0;
        }
        @media screen and (max-width: 768px){
            div.left, div.right{
                display: block;
                width: 100%;
            }
            h1{
                font-size: 150px;
            }
            h2{
                font-size: 36px;
            }
            h3{
                font-size: 28px;
            }
            h4{
                margin-top: 40px;
                font-size: 36px;
                color: #ccc;
            }
            h5{
                margin-top: 5px;
                font-size: 20px;
                color: #ccc;
            }
            .right img{
                height: 300px;
            }
            div.left, div.right{
                padding: 30px 0 40px;
            }
            h6{
                font-size: 36px;
                text-align: center;
                padding-left: 0;
            }
            ul{
                padding-left: 0;
            }
            ul li{
                text-align: center;
            }
        }
    </style>
</head>
<body onload="showAnimation()">
    <a href="http://artisticdesigning.com"><img src="http://artisticdesigning.com/images/logo-compressed.png" alt="Artistic designing Logo" height="65" /></a><br />
    <div class="left">
        <div class="txt">
            <h1>404</h1>
            <h2>Error - Page not found</h2>
            <h4>We searched whole world</h4>
            <h5>But, the page you're looking for was not found</h5>
        </div>
    </div><div class="right">
        <img src="http://artisticdesigning.com/images/not-found.png" id="page-img" alt="Wrong page image" />
    </div>
    <h6>Important links:</h6>
    <ul>
        <li><a href="http://artisticdesigning.com">Home</a></li>
        <li><a href="http://artisticdesigning.com/login">Login</a></li>
        <li><a href="http://artisticdesigning.com/signup">Signup</a></li>
        <li><a href="http://artisticdesigning.com/flipbook">Flipbook</a></li>
    </ul>
    <script>
        function showAnimation(){
            document.getElementById("page-img").style.animation="rotate 2s ease-in-out both";
        }
    </script>
</body>
</html>