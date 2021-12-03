import { Component, OnInit} from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
// Authors: Eric Sakmyster and Merron Tecleab
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class InvitationComponent implements OnInit{
  // Invites will contain all the invites in the database
  invites: any = [];
  // Usernames will contain all user_ids of users who accepted particular invites
  usernames: any = [];
  // Fields for binding
  class = "alert alert-primary";
  border_style: string = "5px solid black";
  padding_style: string = "10px";
  margin_top_style: string = "50px";
  error = "";
  constructor ( private http: HttpClient ) {
  }

  ngOnInit (){
    this.getInvitesAndUsernames();
  }
 

  getInvitesAndUsernames(): void {
    // Get request to get invites from backend listInvites.php
    this.http.get("https://cs4640.cs.virginia.edu/ems5fa/CS4640-Sports-Invitation-System-Sprint-5/listInvites.php").subscribe(
      (respData) => {this.invites = respData;
      this.usernames = new Array((<Array<any>>respData).length);
      for(let j = 1;j <= (<Array<any>>respData).length; j++){
        // Post request to get user_ids from backend listUsers.php
        this.http.post("https://cs4640.cs.virginia.edu/ems5fa/CS4640-Sports-Invitation-System-Sprint-5/listUsers.php", {invite_id : j}).subscribe(
          (respData2) => {
            if (!(<Array<any>>respData2).length){
              this.usernames[j-1] = [0];
            }
            else{
              this.usernames[j-1]= respData2;
            }
          },
          (error2) => {this.error = error2; }
        );
      }},
      (error) => {this.error = error; }
    );
  }
  // Used for view to component binding
  getInfo (): void {
    alert("If a user has accepted an invitation, their ids will be listed under these invitations.")
  }
}
