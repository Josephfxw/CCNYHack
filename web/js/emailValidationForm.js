function validateEmail()
{
  // alert("Hello");

   var emailID = document.myForm.EMail.value;
   
//testing
   //var emailID = " m@h.uny.edu";


   atPos = emailID.indexOf("@");
   dotPos = emailID.lastIndexOf(".");
   if (atPos < 1 || ( dotPos - atPos < 2 )) 
   {
       alert("Please enter correct email ID")
       document.myForm.EMail.focus();
       return false;
   }
  
  ////testing .edu with sample
    // var emailSample = "mmhas@hunter.cuny.edu";

    // if (emailSample.substring(emailSample.length-3, emailSample.length) == "edu"){

    //     alert("validEmail");

    //     return true;
    //  }
  
    else if (emailID.substring(emailID.length-8, emailID.length) !== "cuny.edu"){

        alert("invalid Email address, please enter an email address with 'cuny.edu'");

        return false;
     }
      
   return( true );


}
