    <?php
    include('config.php');
    $bienthuy = new bienthuyconnect();
     
    if($_POST) {
    	$mediaId = $_POST['mediaId'];
    	$rate = $_POST['rate'];
    	
    	$expire = 24*3600; // 1 day
    	setcookie('bienthuytime'.$mediaId, 'rated', time() + $expire, '/'); // Place a cookie
    	
    	$query = $bienthuy->execute('INSERT INTO bienthuy_rating (media, rate) VALUES ('.$mediaId.', "'.$rate.'")'); // We insert the new rate
    	
    	$result = $bienthuy->getOne('SELECT round(avg(rate), 2) AS average, count(rate) AS nbrRate FROM bienthuy_rating WHERE media='.$mediaId.'');
    		
    	$dataBack = array('avg' => $result['average'], 'nbrRate' => $result['nbrRate']);
    	$dataBack = json_encode($dataBack);
    	
    	echo $dataBack;
    }
    ?>