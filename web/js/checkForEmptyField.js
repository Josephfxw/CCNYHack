function checkForEmptyField()
{
 
   if( document.myForm.UserName.value == "" )
   {
     alert( "Please provide your UserName!" );
     document.myForm.UserName.focus() ;
     return false;
   }
   if( document.myForm.EMail.value == "" )
   {
     alert( "Please provide your Email!" );
     document.myForm.EMail.focus() ;
     return false;
   }
   if( document.myForm.password.value == "" ||
           document.myForm.password.value.length >= 6 )
   {
     alert( "Please enter your password, minimum of 6 characters" );
     document.myForm.password.focus() ;
     return false;
   }
   return( true );
}