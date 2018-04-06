

$('.form').submit('submit', e => {
    e.preventDefault();
    dataFilter();
});


function dataFilter() {
   var driver = $('select option:selected').val(),
    from = $('input[name=from]').val(),
    to = $('input[name=to]').val();
var xhr;
 if (window.XMLHttpRequest) { // Mozilla, Safari, ...
    xhr = new XMLHttpRequest();
} else if (window.ActiveXObject) { // IE 8 and older
    xhr = new ActiveXObject("Microsoft.XMLHTTP");
}
var data = "driver=" + driver + "&from=" + from + "&to=" + to;
	 xhr.open("POST", "server/dataFilter.php", true);
     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
     xhr.send(data);
     xhr.onreadystatechange = display_data;
	function display_data() {
	 if (xhr.readyState == 4) {
      if (xhr.status == 200) {
       //alert(xhr.responseText);
	  document.getElementsByClassName("results")[0].innerHTML = xhr.responseText;
      } else {
        alert('There was a problem with the request.');
      }
     }
	}
}
