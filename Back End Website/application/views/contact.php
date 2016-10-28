<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Jharu</title>
    
    <link rel="stylesheet" href="<? echo base_url() ?>files/css/normalize.css">

    <link rel="stylesheet" href="<? echo base_url() ?>files/css/style.css">
    
  </head>

  <body>

    <div class="login">
    <img src="<? echo base_url() ?>files/img/logo.png" style='width:100%;'>
    <fieldset>
        <p align="center" style="color:red" id="res"></p>
    </fieldset>
    <fieldset>
      <input type="email" placeholder="Email" id="email"/>
    </fieldset>
    <fieldset>
      <textarea style="width:100%" id="msg"></textarea>
    </fieldset>
    <input type="submit" value="send message" onclick="zn()" />
    <div class="utilities">
      <a href="<? echo base_url() ?>index.php/login">login</a>
      <a href="http://www.itechoid.com">&copy iTechoid 2015 &rarr;</a>
    </div>
</div>
    
   <script type="text/javascript">
      function zn(e) {
        
        email = document.getElementById("email").value;
        msg = document.getElementById("msg").value;

        if(email != '' && msg != '')
        {
            req = new XMLHttpRequest();

            req.onreadystatechange = function() {
                if(req.readyState == 4 && req.status == 200)
                {
                    if(req.responseText == '1')
                    {
                        document.getElementById("res").innerHTML = "Successfully send";   
                    }
                    else
                    {
                        document.getElementById("res").innerHTML = "Unknown Error occured";   
                    }
                }
            }

            send = "trozan="+JSON.stringify({ 'email':email,'msg':msg });
            http = '<? echo base_url() ?>index.php/contact/sending/';

            req.open('POST',http,false);
            req.setRequestHeader('Content-type','application/x-www-form-urlencoded');
            req.send(send);

        }
        else
        {
            document.getElementById("res").innerHTML = "Fill out the form properly";
        }

      }
   </script> 
    
    
    
  </body>
</html>