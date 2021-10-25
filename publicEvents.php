<!DOCTYPE html>
<html lang="en">
    <!-- 
        CSS Styling:
        text-align
        padding 
        border 
        margin-top
        color
     -->
    <head>
        <link rel="stylesheet" href="main.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
        <title>Public Events</title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="author" content="Eric Sakmyster and Merron Tecleab">
        <meta name="description" content="Invitation page">
        <meta name="keywords" content="Merron Eric invitation">
    </head>

    <body>
      <div id='header-footer-container'>
        <header>
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
              <div class="container-fluid">
                  <a class="navbar-brand" href="index.html">UVA Sports Invitations</a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNavDropdown">
                      <ul class="navbar-nav">
                          <li class="nav-item active">
                              <a class="nav-link" href="index.html">Home</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" style = "border-bottom: 3px solid rgb(47, 120, 255);" aria-current="page" href="publicEvents.html">Public Events</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="createEvent.html">Create Event</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#">User Search</a>
                          </li>
                      </ul>
                  </div>
                  <a class="btn btn-primary btn-md" id= "login" href="login.html" role="button">Login</a>
              </div>
          </nav>
        </header>
        <div id='body'>
          <h1 style="text-align: center; font-size: 70px;">Public Events Hub</h1>
          <div class="container" id="container-invitation">
              <div class="input-group">
                  <input type="search" class="form-control rounded" style="margin-right: 5px;" placeholder="Search" aria-label="Search"/><!--Search bar-->
                  <button type="button" class="btn btn-outline-primary">Search</button> <!--Search button-->
                  <button type="button" class="btn btn-outline-primary">Filter</button> <!--Filter button-->
              </div>

              <div class="card text-center" id="card-invitation" style="border: 5px solid black;">
                  <div class="card-header">
                    Featured
                  </div>
                  <div class="card-body"> 
                    <h5 class="card-title">Co-Rec Pick-Up Soccer</h5> <!--Soccer invitation event-->
                    <p class="card-text">5 v 5</p> <!--Amount of player-->
                    <p class="card-text">@Carr's Field</p> <!--Location of event-->
                    <p class="card-text">4:30-5:30 PM 9/10/21</p> <!--Date/Time of event-->
                    <p class="card-text">4 Spots Remaining</p> <!--Amount of spots left-->
                    <a href="#" class="btn btn-primary">Going</a> <!--Going button-->
                    <a href="#" class="btn btn-warning">Unsure</a> <!--Unsure button-->
                    <a href="#" class="btn btn-danger">Not going</a> <!--Not going button-->
                  </div>
                  <div class="card-footer text-muted">
                    2 days ago <!--When the even was posted-->
                  </div>
              </div>

              <div class="card text-center" id="card-invitation" style="border: 5px solid black;">
                  <div class="card-header">
                    Featured
                  </div>
                  <div class="card-body"> 
                    <h5 class="card-title">Women's Pick-Up Spikeball</h5> <!--Spikeball invitation event-->
                    <p class="card-text">2 v 2</p> <!--Amount of player-->
                    <p class="card-text">@Ohill Field</p> <!--Location of event-->
                    <p class="card-text">8-9 AM 9/15/21</p> <!--Date/Time of event-->
                    <p class="card-text">2 Spots Remaining</p> <!--Amount of spots left-->
                    <a href="#" class="btn btn-primary">Going</a> <!--Going button-->
                    <a href="#" class="btn btn-warning">Unsure</a> <!--Unsure button-->
                    <a href="#" class="btn btn-danger">Not going</a> <!--Not going button-->
                  </div>
                  <div class="card-footer text-muted">
                    2 days ago <!--When the even was posted-->
                  </div>
              </div>

              <div class="card text-center" id="card-invitation" style="border: 5px solid black; margin-bottom: 15px;">
                  <div class="card-header">
                    Featured
                  </div>
                  <div class="card-body"> 
                    <h5 class="card-title">Men's Pick-Up Basketball</h5> <!--Basketball invitation event-->
                    <p class="card-text">5 v 5</p> <!--Amount of player-->
                    <p class="card-text">@Slaughter</p> <!--Location of event-->
                    <p class="card-text">9-10:30 PM 9/15/21</p> <!--Date/Time of event-->
                    <p class="card-text">3 Spots Remaining</p> <!--Amount of spots left-->
                    <a href="#" class="btn btn-primary">Going</a> <!--Going button-->
                    <a href="#" class="btn btn-warning">Unsure</a> <!--Unsure button-->
                    <a href="#" class="btn btn-danger">Not going</a> <!--Not going button-->
                  </div>
                  <div class="card-footer text-muted">
                    2 days ago <!--When the even was posted-->
                  </div>
              </div>
          </div>
        </div>
        <footer class = 'primary-footer'>
          <nav class = 'footer-nav'>
              <a class="btn btn-primary btn-sm" href="index.html" role="button">Home
              </a> |
              <a class="btn btn-primary btn-sm" href="publicEvents.html" role="button">Public Events
                  <span class="badge bg-secondary">0</span>
              </a> |
              <a class="btn btn-primary btn-sm" href="createEvent.html" role="button">Create Event
              </a> |
              <a class="btn btn-primary btn-sm" href="#" role="button">User Search</a>
          </nav>
        </footer>
      </div>
    </body>
</html>