<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf8_polish_ci" />
    <script>

    function jsFun(){
        var x1 = parseFloat(document.getElementById("x1").value);
        if(isNaN(x1))
            document.getElementById("res-div").innerHTML = "Nie podano liczby";
        else {
            document.getElementById("res-div").innerHTML = x1 * 5;
        }
    }


    </script>

</head>  
<body>


<br/>

    <form>
		<div style="padding-bottom:15px" id="res-div" ></div>
		
		
		<div style="padding-bottom:15px">
		x1: <input type=text id="x1" value="">
		</div>
		<div>
		x2: <input type=text id="x2" value="">
		</div>
		</br>
		<div>
		x3: <input type=text id="x3" value="">
		</div>
		</br>
		<div >
		<input  type="button" value="Oblicz" onclick="jsFun();">
		</div>
	</form>


</body>
</html>