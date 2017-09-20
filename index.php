<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>S'weet! Search Tweets</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>

	<div id="main">
	<?php $q = isset($_GET['q']) ? $_GET['q'] : null; ?>

		<div id="search">
		<form action="" method="get">
		  <label>
		  S'weet!
		  <input type="text" name="q" id="searchbox"  value="<?php echo $q;?>"/>
		  <input type="submit" name="submit" id="submit" value="Search" />
		  </label>
		  <p class="helptext">enter terms like snow, happy hour, @jimmyfallon, #politics</p>
		</form>
		</div>
		<div id="results">
		<?php
		require_once 'scripts/functions.php';
		
		//Search API 
		
		$q=$_GET['q'];
		$q=urlencode($q);
		$search = "http://search.twitter.com/search.atom?rpp=10&page=1&result_type=recent&q=".$q."";
		
		$tw = curl_init();
		
		curl_setopt($tw, CURLOPT_URL, $search);
		curl_setopt($tw, CURLOPT_RETURNTRANSFER, TRUE);
		$twi = curl_exec($tw);
		$search_res = new SimpleXMLElement($twi);
		
			
		## Echo the Search Data
		
		foreach ($search_res->entry as $tweet) {
		$tweettext = $tweet->content;		
		$date =  strtotime($tweet->updated);
		$dayMonth = date('d M', $date);
		$year = date('y', $date);
		$message = $row['content'];
		$posted = time_ago($theDate, $date);
		
		echo "<div class='user'><a href=\"",$tweet->author->uri,"\" target=\"_blank\"><img border=\"0\" width=\"48\" class=\"user_photo\" src=\"",$tweet->link[1]->attributes()->href,"\" title=\"", $tweet->author->name, "\" /></a> <div class='user_name'><a href=\"",$tweet->author->uri,"\" target=\"_blank\">",$tweet->author->name,"</a></div><div class='tweet_text'>".$tweettext."  &nbsp;<span class='time_ago'>&middot;&nbsp;".$posted."&nbsp;&middot;</span></div><div class='clear'></div></div>";
		}		
		curl_close($tw);
		
		?>
		<p class="footer">submitted by <a href="mailto:smithwebsmith@gmail.com">Lisa D. Smith</a></p>
		</div>
	</div>
	
</body>
</html>