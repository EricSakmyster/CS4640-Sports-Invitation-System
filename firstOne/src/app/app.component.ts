import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  // title = 'firstOne';

  // verifyUsername() : boolean { //arrow function
  //     let username = document.getElementById("inputUsername").value;

  //     if(username.length >= 5 && username.length <= 10) { // Returns true if the username field is within 5-10 letters
  //         return true;
  //     }

  //     alert("Username error!");
  //     return false;
  // }

  // userErrType() : boolean {
  //     var username = document.getElementById("inputUsername").value;

  //     if(username.length >= 5 && username.length <= 10) { // Returns true if the username field is within 5-10 letters
  //         return true;
  //     }

  //     document.getElementById("userHelp").innerHTML = "Enter a username between 5-10 letters";
  //     return false;
  // }

  // verifyPassword() : boolean { //anonymous function
  //     var password = document.getElementById("inputPassword").value;
      
  //     var isUpper = false;
  //     for (let i = 0; i < password.length; i++) { // Check if any upper case letters exist in the input
  //         var temp = password.charAt(i);
  //         if(temp == temp.toUpperCase()) {
  //             isUpper = true;
  //             break;
  //         }
  //     }

  //     var isLower = false;
  //     for (let i = 0; i < password.length; i++) { // Check if any lower case letters exist in the input
  //         var temp = password.charAt(i);
  //         if(temp == temp.toLowerCase()) {
  //             isLower = true;
  //             break;
  //         }
  //     }

  //     if(password.length >= 5 && password.length <= 10 && isUpper == true && isLower == true) {
  //         return true;
  //     }
  //     alert("Password error!");

  //     return false;
  // }

  // passErrType() : void {
  //     var password = document.getElementById("inputPassword").value;
      
  //     var isUpper = false;
  //     for (let i = 0; i < password.length; i++) { // Check if any upper case letters exist in the input
  //         var temp = password.charAt(i);
  //         if(temp == temp.toUpperCase()) {
  //             isUpper = true;
  //             break;
  //         }
  //     }

  //     var isLower = false;
  //     for (let i = 0; i < password.length; i++) { // Check if any lower case letters exist in the input
  //         var temp = password.charAt(i);
  //         if(temp == temp.toLowerCase()) {
  //             isLower = true;
  //             break;
  //         }
  //     }

  //     if(password.length < 5 || password.length > 10) { // If the password is out of the 5-10 letter range
  //         document.getElementById("passHelp").innerHTML = "Enter a password between 5-10 letters";
  //     }

  //     else if(isUpper == false) { // If the password does not have any upper case letters
  //         document.getElementById("passHelp").innerHTML = "Include at least one upper case letter";
  //     }

  //     else if(isLower == false) { // If the password does not have any lower case letters
  //         document.getElementById("passHelp").innerHTML = "Include at least one lower case letter";
  //     }


  // }


  // addAccount() : boolean {
  //     var isValidName = verifyUsername();
  //     var isValidPassword = verifyPassword();

  //     if(isValidName == true && isValidPassword == true) { // If the username and the password are typed in properly
  //         window.location.href = "login.php";
  //         return true;
  //     }

  //     else if(isValidName == true && isValidPassword == false) { // If the username is typed in properly
  //         event.preventDefault(); // Stops the page from logging in
  //         passErrType(); // Display the password error message
  //         document.getElementById("userHelp").innerHTML = "";
  //         return false;
  //     }

  //     else if(isValidName == false && isValidPassword == true) { // If the password is typed in properly
  //         event.preventDefault(); // Stops the page from logging in
  //         userErrType(); // Display the username error message
  //         document.getElementById("passHelp").innerHTML = "";
  //         return false;
  //     }

  //     else { // If both the username and the password isn't typed in properly
  //         userErrType(); // Display the username error message
  //         passErrType(); // Display the password error message
  //         event.preventDefault(); // Stops the page from logging in
  //         return false;
  //     }
      
  // }
}
