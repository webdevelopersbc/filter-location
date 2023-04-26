<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Search Box Example</title>
	<style>
		/* Styles for search box container */
		.search-container {
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 10px;
		}
		
		/* Styles for search box input */
		.search-box {
			width: 100%;
			max-width: 400px;
			padding: 10px;
			border: none;
			border-radius: 20px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
			font-size: 16px;
			background-color: #f1f1f1;
			transition: background-color 0.3s ease-in-out;
		}
		
		/* Styles for search box input when focused */
		.search-box:focus {
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
		}
		
		/* Styles for search box submit button */
		.search-button {
			padding: 10px 20px;
			background-color: #4CAF50;
			color: #fff;
			border: none;
			border-radius: 20px;
			cursor: pointer;
			transition: background-color 0.3s ease-in-out;
		}
		
		/* Styles for search box submit button when hovered */
		.search-button:hover {
			background-color: #3e8e41;
		}
        .search-container {
    margin-top: 10%;
}
		
		@media screen and (max-width: 600px) {
			/* Styles for search box container when on mobile devices */
			.search-container {
				flex-direction: column;
			}
			
			/* Styles for search box input when on mobile devices */
			.search-box {
				max-width: 100%;
				border-radius: 10px;
			}
			
			/* Styles for search box submit button when on mobile devices */
			.search-button {
				margin-top: 10px;
				border-radius: 10px;
			}
		}
	</style>
 
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/fuse.js@6.6.2"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/fuse.js/dist/fuse.js"></script> -->
<?php  
require_once 'config.php';

$sql = "SELECT * FROM `wp_location`";
$result = mysqli_query($conn, $sql);
 
if (mysqli_num_rows($result) > 0) {
    
    $data = array();
 
    while ($row = mysqli_fetch_assoc($result)) {
   
        $data[] = $row;
    }
 
    $jsondata =  json_encode($data);
	// echo "<pre>";
	// print_r($jsondata);
} else {
    // No results found
    header('HTTP/1.1 404 Not Found');
    die('Error: No data found');
}
 
mysqli_close($conn);
?>
</head>
<body>

<?php  

 
?>

<form action="">
	<div class="search-container">
		<input type="text" id="searchbox" name="location"   placeholder="Search..." class="search-box">
         <ul id="searchResult1">

        
         </ul>
         <input type="hidden" name="geo_tag_status" id="geo_tag_status">
         <input type="hidden" name="version_1" id="version_1">
         <input type="hidden" name="type" id="type">
         <input type="hidden" name="country_code" id="country_code">
         <input type="hidden" name="country_name" id="country_name">
         <input type="hidden" name="latitude" id="latitude">
         <input type="hidden" name="longitude" id="longitude">
        
		<button type="submit" id="searchbtn" class="search-button">Search</button>
	</div>
    </form>


   
</body>
<script>
var data = <?php echo $jsondata ?>;
// console.log(data);

var options = {
  keys: ['Location'],
  threshold: 0.3
};

var fuse = new Fuse(data, options);

var searchInput = document.getElementById('searchbox');

var geo_tag_status = document.getElementById('geo_tag_status');
var version_1 = document.getElementById('version_1');
var type = document.getElementById('type');
var country_code = document.getElementById('country_code');
var country_name = document.getElementById('country_name');
var latitude = document.getElementById('latitude');
var longitude = document.getElementById('longitude');

var resultsContainer = document.getElementById('searchResult1');

searchInput.addEventListener('input', function() {
  var searchQuery = searchInput.value;
  var result = fuse.search(searchQuery);
//  console.log(result);
  resultsContainer.innerHTML = '';
  if (result.length > 0) {
    result.forEach(function(item) {

     console.log(item);  
     var itemElement = document.createElement('li');
	 itemElement.setAttribute("class", "location");
    itemElement.textContent = item.item.Location;
    geo_tag_status.value = item.item.GeoTag_status;
    version_1.value = item.item.Inc;
    type.value = item.item.Type;
    country_code.value = item.item.Country_Code;
    country_name.value = item.item.Country_name;
    latitude.value = item.item.Latitude;
    longitude.value = item.item.Longitude;
    resultsContainer.appendChild(itemElement);
    });
  } else {
    var noResultsElement = document.createElement('div');
    noResultsElement.textContent = 'No results found.';
    resultsContainer.appendChild(noResultsElement);
  }
});

// $('.location').click(function(){
//    var selected_val = $(this).val();
//    console.log(selected_val);
// 	document.getElementById('searchbox').value = selected_val;
// });

function getEventTarget(e) {
        e = e || window.event;
        return e.target || e.srcElement; 
    }

    var ul = document.getElementById('searchResult1');
    ul.onclick = function(event) {
        var target = getEventTarget(event);
        // alert(target.innerHTML);
		document.getElementById('searchbox').value = target.innerHTML;


		var searchQuery = target.innerHTML;
  var result = fuse.search(searchQuery);
  resultsContainer.innerHTML = '';
 
    result.forEach(function(item) {
     var itemElement = document.createElement('li');
	 itemElement.setAttribute("class", "location");
    itemElement.textContent = item.item.Location;
    geo_tag_status.value = item.item.GeoTag_status;
    version_1.value = item.item.Inc;
    type.value = item.item.Type;
    country_code.value = item.item.Country_Code;
    country_name.value = item.item.Country_name;
    latitude.value = item.item.Latitude;
    longitude.value = item.item.Longitude;
    resultsContainer.appendChild(itemElement);
    });
  
    };
</script>
</html>
