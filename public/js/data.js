function sendMyData()   
{  
    // get data  
    var username = "MarioRossi";  
    var password = "Secret Passphrase";  
  
    // prepare array  
    var digest_md5 = Crypto.MD5(password);  
    var json_obj = {"username" : username, "password" : digest_md5 };  
    json_string = myencrypt(JSON.stringify(json_obj));  
  
    // send data  
    $.ajax({  
        type: "POST",  
        url: "./myserver.php",  
        data: {cryption:json_string},  
        context: document.body,  
        async: true,  
        success: function(res, stato)  
        {  
            try {  
                var json_message = mydecrypt(res.trim());  
                var jsObject = eval("(" + json_message + ")");  
                var msg = jsObject.msg;  
            }   
            catch(e) {   
                console.log(e);  
            }                           
        },  
        error : function (richiesta, stato, errori)   
        {  
            var msg = "An error has occured. Call Status: " + stato;  
            console.log(msg);  
        }  
    });  
  
  return false;  
}  