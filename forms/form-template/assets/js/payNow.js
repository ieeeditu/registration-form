$(document).ready(function() {
 // payCount()
});

function payNow() {
  // Get the checkbox
  var w2 =document.getElementById('w2')
  var checkBox = w2.getAttribute('data-id');
  var paydiv = document.getElementById('div-'+checkBox+'-pay')
  var pay =  paydiv.getElementsByTagName('input')  
  var btn =  document.getElementById('reg');
    btn.disabled= false;
    console.log("test")
  if (w2.checked != true){

    paydiv.style.display = "none";
    btn.innerText = "Pay and Register";

    for(i = 0;i < pay.length; i++){
      pay[i].checked = false;
      pay[i].required = false;}
    
    }  else {     
    
    paydiv.style.display = "block";

    for(i = 0;i < pay.length; i++){
      pay[i].required = true;
    }
    btn.innerText = "Enter OTP and Register";
    }
}


