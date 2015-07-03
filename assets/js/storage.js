var storedKeywords = [];
var userAttributes = new Array();

function addUserDetails(userDetails)
{
	//add details to array and push it to storage
	userAttributes = getUserDetails();
	if(userAttributes!=null)
	{
		if(userAttributes.indexOf(userDetails)> -1)
		{
			//data is already included, hence skip saving it
		}
		else
		{
		   userAttributes.push(userDetails);
		}
	}
	else
	{
		userAttributes = new Array();
		userAttributes.push(userDetails);
	}
    localStorage.clickedUsers = JSON.stringify(userAttributes);    
}

function getUserDetails()
{
	//get entire array for later processing
  var usersArray = JSON.parse(localStorage.getItem("clickedUsers"));
     return usersArray;
}


function updateUserKeywords(keywords)
 {
  //add details to array and push it to storage
	storedKeywords = getKeywords();
	if(storedKeywords!=null)
	{
		storedKeywords.push(keywords);
	}
	else
	{
		storedKeywords = new Array();
		storedKeywords.push(keywords);
	}
	localStorage.userkeywords = JSON.stringify(storedKeywords); 
}

function getKeywords()
{	
    var value = JSON.parse(localStorage.getItem("userkeywords"));
	return value;
}

//UTILITY FUNCTIONS
//method to find if an array contains a certain item using indexof
        //uses browser implemented one or if it doesnt exist uses the one created in this function
    var indexOf = function (needle) {
            if (typeof Array.prototype.indexOf === 'function') {
                indexOf = Array.prototype.indexOf;
            } else {
                indexOf = function (needle) {
                    var i = -1,
                        index = -1;

                    for (i = 0; i < this.length; i++) {
                        if (this[i] === needle) {
                            index = i;
                            break;
                        }
                    }
                    return index;
                };
            }

            return indexOf.call(this, needle);
        };