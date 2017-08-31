    <?PHP
    include('config.php');
    $bienthuy = new bienthuyconnect();
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
    <head>
    <title>jQuery/Ajax Star Rating </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">     
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.1.js"></script>
    <style>
    .star { display: inline-block; background: url("star.png") no-repeat; width: 25px; height: 25px }
    .star_hover { display: inline-block; background: url("star.png") no-repeat; background-position: 0 -25px; width: 25px; height: 25px }
    </style>
    </head>     
    <body>     
    <div class="container">
    <div class="row">
    <div class="col-md-12">
    <br /><br />
    <?php
    function starBar($numStar, $mediaId, $starWidth) {
        global $bienthuy;
        $cookie_name = 'bienthuytime'.$mediaId;
        $nbrPixelsInDiv = $numStar * $starWidth; // Calculate the DIV width in pixel
        
        // Rate average and number of rate from the database
        $query = $bienthuy->getOne('SELECT round(avg(rate), 2) AS average, count(rate) AS nbrRate FROM bienthuy_rating WHERE media='.$mediaId.'');
        
        //num of pixel to colorize (in yellow)
        $numEnlightedPX = round($nbrPixelsInDiv * $query['average'] / $numStar, 0);
        
        $getJSON = array('numStar' => $numStar, 'mediaId' => $mediaId); // We create a JSON with the number of stars and the media ID
        $getJSON = json_encode($getJSON);
     
        $starBar = '<div id="'.$mediaId.'">';
        $starBar .= '<div class="star_bar" style="width:'.$nbrPixelsInDiv.'px; height:'.$starWidth.'px; background: linear-gradient(to right, #ffc600 0px,#ffc600 '.$numEnlightedPX.'px,#ccc '.$numEnlightedPX.'px,#ccc '.$nbrPixelsInDiv.'px);" rel='.$getJSON.'>';
        for ($i=1; $i<=$numStar; $i++) {
            $starBar .= '<div title="'.$i.'/'.$numStar.'" id="'.$i.'" class="star"';
            if( !isset($_COOKIE[$cookie_name]) ) $starBar .= ' onmouseover="overStar('.$mediaId.', '.$i.', '.$numStar.'); return false;" onmouseout="outStar('.$mediaId.', '.$i.', '.$numStar.'); return false;" onclick="rateMedia('.$mediaId.', '.$i.', '.$numStar.', '.$starWidth.'); return false;"';
            $starBar .= '></div>';
        }
        $starBar .= '</div>';
        $starBar .= '<div class="resultMedia'.$mediaId.'" style="font-size: small; color: grey">'; // We show the rate score and number of rates
        if ($query['nbrRate'] == 0) $starBar .= 'Not rated yet';
        else $starBar .= 'Rating: ' . $query['average'] . '/' . $numStar . ' (' . $query['nbrRate'] . ' votes)';
        $starBar .= '</div>';
        $starBar .= '<div class="box'.$mediaId.'"></div>';
        $starBar .= '</div>';
        return $starBar;
    }
    // Display 4 star bar system for 4 different IDs
    echo starBar(3, 502, 25); // 3 stars, Media ID 200, 25px star image
    echo starBar(5, 201, 25); // 5 stars, Media ID 201, 25px star image
    echo starBar(10, 202, 25); // 10 stars, Media ID 202, 25px star image
    echo starBar(30, 203, 25); // 30 stars, Media ID 203, 25px star image
    ?>
    </div>
    </div>
    </div>
    <script type="text/javascript" src="rate.js"></script>
    </body>
    </html>