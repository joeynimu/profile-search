<?php
//get id
$userId = $_GET['id'];

//get data from the json file for first display
$fileURL = "assets/files/people.json";
$jsonData = file_get_contents($fileURL);
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
  <!-- content -->
  <a href="index.php"> Home </a>
  <br>
  <div class="generalWrapper"> 
  <div class="people">
   <!-- loop through data and display profiles -->
    <?php  
    if(isset($userId) && $userId!='')
    {    
      $jsonParsed=json_decode($jsonData, true);
      //get total users
      $totalUsers = $jsonParsed[total];
      //get the result set
      $resultSet =  $jsonParsed[result];

      //loop and get sample data
      for ($i=0; $i < $totalUsers; $i++) { 
      	 $oneUserId = $resultSet[$i][id];
          //only show the requested user
      	if($oneUserId==$userId)
      	{
         $oneUserPic = $resultSet[$i][picture];
         $oneUserName = $resultSet[$i][name];
         $oneUserGender = $resultSet[$i][gender];
         $oneUserCompany = $resultSet[$i][company];
         $oneUserPhone = $resultSet[$i][phone];
         $oneUserAbout = $resultSet[$i][about];

         ?>
         <script type="text/javascript">
            //save the gender to local storage; will be used for profile suggestions         
            addUserDetails(<?php echo json_encode($oneUserGender); ?>);
         </script>
        <div class="profileTemplate" style="width: 70%;">
           <div class="profileImage">
             <img src="<?php echo $oneUserPic; ?>" alt="icon"/>
           </div>
           <div class="profileDetail">
            <h4 class="specialLink"><?php echo $oneUserName; ?></h4>
            <p>
             <br>
              <?php echo $oneUserGender; ?>
              <br>
              <?php echo $oneUserPhone; ?>
              <br>
              <?php echo $oneUserCompany; ?>
              <br><br>
              <?php echo $oneUserAbout; ?>
            </p>
          </div>
        </div>       
         <?php
       }
      }
    }  
    else
    {
      echo "Error! User Must be specified!";
    }  
    ?>     
  </div>
  </div>
  <div class="suggestionsWrapper" id="suggestionsZone">
   
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
  </script>
 </body>
</html>