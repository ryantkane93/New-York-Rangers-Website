 <!DOCTYPE html>

<html>
  <head>

<title>NHL and NYR RSS Feed</title>

<!--
	Final Project
	Ryan Kane
	December 1st, 2015
-->

<link href="stylesQuery.css" type="text/css" rel="stylesheet"/>
</head>

<style type="text/css">

/* header */
header{
	text-align: center;
	background-color: black;
	border: 3px dashed red;
}

header h1{
	font-family: "Arial Black",Gadget,sans-serif;
	color: red;
	font-size: 2.3em;
}

#main h3{
	color: red;
	bottom-border: 2px dashed blue;
	text-decoration: underline;
	font-size: 1.3em;
}

ol{
	text-indent: 0em;
	font-style:italic;
	line-height: 2em;
	font-size: 1em;
}

aside {    
	width: 200px;	
	padding: 10px;
	color: black;
    background-color: red;
    float: right;
}


#main h2 {
    border-bottom: 2px dashed red;
    padding-bottom: 10px;
	text-align: center;
	font-weight: bold;
	font-variant: small-caps;
	color: blue;
}	
aside h3{
	color: black;


</style>

</head>
  
<body>

<section id="container">
<header>
<p><img src="images/hockey_rink.jpg" alt="hockey rink" title = "Hockey Rink Diagram" width="700" height="254" /></p>
<h1>NHL and NYR RSS Feed</h1>
</header>
<div id = "nav" class="nav">   
   <p>
	<a href = "#Introduction">Introduction to Possession</a>
	| <a href = "#Stats">Corsi and Fenwick</a>
	| <a href = "#Variations">Variations</a>
   </p>
</div>
   
<article id="main">
<div id = "header">
<?php

//Open source code taken from: http://bavotasan.com/2010/display-rss-feed-with-php/
//Modified by: Ryan Kane, December 2015

    	function getArticles($feedName){
		$rss = new DOMDocument(); //Declare a DOMDocument object to hold the news feed.
    	$rss->load($feedName); //Loads an existing RSS news feed.
    	$feed = array(); //Declare an array to hold the feed elements.
    	foreach ($rss->getElementsByTagName('item') as $node) { //Retrieve the title, description, link and publish date of each article from the feed and store them in the array.
    		$item = array ( 
    			'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
    			'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
    			'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
    			'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
    			);
    		array_push($feed, $item); //Add the article elements into the feed array.
    	}
    	$limit = 5; //Limit the feed to 5 articles only.
    	for($x=0;$x<$limit;$x++) { //Use for a for loop to ouput the elements of each article.
    		$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
    		$link = $feed[$x]['link'];
    		$description = $feed[$x]['desc'];
    		$date = date('l F d, Y', strtotime($feed[$x]['date']));
    		echo '<p><center><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a><center></strong><br />';
    		echo '<center><small><em><FONT COLOR = red>Posted on '.$date.'</FONT></em></small></p></center>';
    		echo '<FONT COLOR = BLUE><p>'.$description.'</p></FONT>';
			echo"<br>";
		}
		}
		
		//Call getArticles twice so that the ten articles in the feed are from different sites.
		getArticles('http://www.nhl.com/rss/news.xml'); //Display 5 articles from the NHL feed.
		getArticles('http://rangers.nhl.com/rss/news.xml'); //Display 5 articles from the Rangers feed.
		
?>
</div>
</article> <!-- end main -->
<div id = "aside" class = "center">
<aside>
<h3>Website Navigation</h3>
<p>
<a href="index.htm">Website Home Page</a>
</p>
<p>
<a href="possession.htm">Corsi and Fenwick</a>
</p>
<p>
<a href="other_stats.htm">Overview of Other Statistics</a>
</p>

<h3>Statistics Websites</h3>
<p>
<a href="http://war-on-ice.com/">War On Ice</a>
</p>

<p>
<a href="http://stats.hockeyanalysis.com/">Hockey Analysis</a>
</p>

<p>
<a href="http://www.behindthenet.ca/">Behind the Net</a>
</p>

<p>
<a href="http://www.puckalytics.com/">Puck Analytics</a>
</p>

<p>
<a href="http://www.hockeydb.com/">Hockey Database</a>
</p>

<p>
<a href="http://www.hockey-reference.com/">Hockey Reference</a>
</p>

<p>
<a href="http://www.nhl.com/stats/?navid=nav-sts-main#">NHL Website's Stats</a>
</p>

<p>
<a href="http://somekindofninja.com/nhl/">SomeKindofNinja Chart Generator</a>
</p>

<p>
<a href="http://www.sportingcharts.com/nhl/">NHL SportingCharts</a>
</p>
</aside> <!-- end sidebar -->
</div>
<footer>
<p>New York Rangers Advanced Statistics &bull; Written by: Ryan Kane &bull; Created December 2015
</section> <!-- end container -->
</body>
</html>



