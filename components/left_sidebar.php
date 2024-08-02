<div class=" mr-2 mt-3" style="width:auto">
<div class="dropdown mb-5">
<button class="btn sidebar-button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <img src="img/Profilepic/<?php echo $_COOKIE['logged_profilePic'] ?>" alt="profile-image" style="width: 50px;border-radius:50%; margin-right:5px"><?php echo $_COOKIE['logged_username'] ?>
</button>

  <div class="dropdown-menu " aria-labelledby="profilemenu">
    <a class="dropdown-item" id="btn_profile" href="profile.php">Profile</a>
    <a class="dropdown-item" id="" href="#">Settings</a>
    <a class="dropdown-item"  href="./php/logout-process.php">Logout</a>
  </div>
</div>

<a href="#"><button class="btn sidebar-button"><img width="30" height="30" src="https://img.icons8.com/color/48/documents.png" alt="documents"/> Pages</button></a>
<a href="#"><button class="btn sidebar-button"><img width="30" height="30" src="https://img.icons8.com/ultraviolet/40/user-group-woman-woman.png" alt="user-group-woman-woman"/> Groups</button></a>
<a href="#"><button class="btn sidebar-button"><img width="30" height="30" src="https://img.icons8.com/color-glass/48/task-completed--v1.png" alt="task-completed--v1"/> Liked Pages</button></a>
</div>