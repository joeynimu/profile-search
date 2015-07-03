<?php
//get data from the json file for first display
$fileURL = "assets/files/people.json";
$jsonData = file_get_contents($fileURL);

//get local data if any

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<title>Sample Intelligent Search</title>
<link rel="stylesheet" href="assets/css/style.css"/>	
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="assets/js/jquery-1.10.2.js"></script>
  <script src="assets/js/jquery-ui.js"></script>
  <script src="assets/js/storage.js"></script>

</head>
 <body>
 <div class="pageContent">
  <div class="searchBar">
  	<input type="text" id="searchField" style="width: 70%;" name="searchTerm" value="" required placeholder="search here..."/>
  	<input type="button" id="searchBtn" style="width: 20%;" name="submit" value="Search" onclick="searchUsers()"/>
  </div>
  </br>
  <div class="generalWrapper">
  <!-- content --> 
  <div class="people">
   <!-- loop through data and display profiles -->
    <?php      
      $jsonParsed=json_decode($jsonData, true);
      //get total users
      $totalUsers = $jsonParsed[total];
      //get the result set
      $resultSet =  $jsonParsed[result];

      //loop and get data; using a few fields here
      for ($i=0; $i < $totalUsers; $i++) { 
      	 $oneUserId = $resultSet[$i][id];
         $oneUserPic = $resultSet[$i][picture];
         $oneUserName = $resultSet[$i][name];
         $oneUserCompany = $resultSet[$i][company];
         $oneUserPhone = $resultSet[$i][phone];

        if($oneUserId!='')
         {
         ?>
        <a href="singleView.php?id=<?php echo $oneUserId; ?>" class="noHighlight">
        <div class="profileTemplate">
           <div class="profileImage">
             <img src="<?php echo $oneUserPic; ?>" alt="icon"/>
           </div>
           <div class="profileDetail">
            <h4 class="specialLink"><?php echo $oneUserName; ?></h4>
            <p>
              <?php echo $oneUserPhone; ?>
              <br>
              <?php echo $oneUserCompany; ?>
              <br>
            </p>
          </div>
        </div>
        </a>
         <?php
        }
      }    
    ?>     
  </div>
  </div>
  <div class="suggestionsWrapper" id="suggestionsZone">
  <!-- area to display suggested people; maximum of 3-->

  
  </div>
  </div>
  <script type="text/javascript">
  //get saved user details
   $(document).ready(function(){
        userKeywords = getKeywords(); //global
        var userAttributes = getUserDetails();

        console.log("TO SUGGEST WORDS FROM: "+userKeywords);

        console.log("TO SUGGEST PEOPLE BASED ON: "+userAttributes);

        if(userAttributes!==null)
        {
           //parse the JSON data for matches and show a maximum of 3 on the suggestions space

           var dataToParse = <?php echo json_encode($resultSet); ?>;
           // var dataToParse = JSON.parse(s);

           var countSuggestions = 0, suggestionsString = "";
           for (var i =0; i < dataToParse.length; i++) {           	               	   
           	   if(countSuggestions<3)
           	   {
           	      singleGender = dataToParse[i].gender;
           	      //check  if this user's attributes are part of our suggestion criteria
           	      if(userAttributes.indexOf(singleGender) >-1)
           	      { 
           	      	countSuggestions+=1;
           	      	//show this user
                      console.log("TO SUGGEST: "+dataToParse[i].name);
                      suggestionsString = suggestionsString+'<br>Based on gender clicked earlier <br><a href="singleView.php?id='+dataToParse[i].id+'">'+dataToParse[i].name+'</a>';
           	      }
           	  }
           	  else
           	  {
           	  	//enough suggestions; break loop
           	  	console.log("TO BREAK LOOP: ");
           	  	break;
           	  }
           }

          $("#suggestionsZone").html("People you may know: <br><br> "+suggestionsString);

           console.log("TO SUGGEST: "+dataToParse.length);
        }
        else
        {
          $("#suggestionsZone").html("No available suggestions at the moment");
        }

       //set autocomplete
       if(userKeywords!==null)
       {
        $( "#searchField" ).autocomplete({
             source: userKeywords
            });
       }
   });

//method to search for users from file
  function searchUsers()
  {  	
  	var searchValue = $("#searchField").val();

  	if(searchValue!=='')
  	{
  	//get earlier JSON
    var searchableJSON = <?php echo $jsonData; ?>;

  	console.log("To search via AJAX with: "+searchValue+" from: "+searchableJSON);

  	//save the keyword for future reference
    updateUserKeywords(searchValue);

  	//get objects where the name matches the user search term
  	//search and get objects
  	matchingObjects = [];

  	var searchResponse = JSON.stringify(getObjects(searchableJSON,'name',searchValue));

    console.log("RESULT: "+searchResponse);

    //parse the JSON, get ids and put in array for use in display in the results
    // var jArray = searchResponse;
    var jArray = eval(searchResponse);
    for (var i = 0; i < jArray.length; i++) 
     {
        singleId = jArray[i].id;
        singleCompany = jArray[i].company;

        //use company detail to filter out the main users leaving out friends. The ids would have been included in the search result
         if(typeof singleCompany != 'undefined' && singleCompany!=='')
         {
           console.log("ADDING: "+singleId+" TO: "+matchingObjects);
           matchingObjects.push(singleId);
         }
     }

     //redirect to search results page
     window.location = "searchResults.php?idsarray="+matchingObjects;
   }
   else
   {
   	//prompt user to enter search term
     $("#searchField").attr("placeholder", "Please enter a name");
   }
  }

  //return an array of objects according to key, value, or key and value matching
function getObjects(obj, key, val) {
    var objects = [];
    for (var i in obj) {

    	var oneObj = obj[i];
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof oneObj == 'object') {
            objects = objects.concat(getObjects(oneObj, key, val));    
        } else 
        //if key matches and value matches or if key matches and value is not passed (eliminating the case where key matches but passed value does not)
        var comparator = JSON.stringify(oneObj);
         // console.log("In search: "+comparator);

       //check for undefined value
       if(typeof comparator != 'undefined')
       {
        if (i == key && comparator.indexOf(val) >-1 || i == key && val == '') { //
            objects.push(obj);
        } else if (comparator.indexOf(val) >-1 && key == ''){
            //only add if the object is not already in the array
            if (objects.lastIndexOf(obj) == -1){
                objects.push(obj);
            }
        }
      }
    }
    return objects;
}
  </script>
 </body>
</html>