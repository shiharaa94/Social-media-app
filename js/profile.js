$(document).ready(function() {

    // fetch Profile data
    function fetchProfile() {

        $.ajax({
            url: 'php/fetch-profile.php',
            method: 'GET',
            cache: false,
            dataType: 'json',
            success: function(response) {
                const profile_data = response;
                let profileHtml = '';

                profileHtml += `
                   <center>

                        <div style="color:white;">
                            <center>
                            <img src="img/Profilepic/${profile_data.profile_pic}" alt="Profile Image" style="width: 75px; border-radius:50%;margin-top:-80px;">
                                <h3>${profile_data.firstname} ${profile_data.lastname}</h2>
                                <h4>${profile_data.username}</h3>
                                <h6>${profile_data.gender}</h5>
                                <h6>${profile_data.email}</h5> 
                                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#edit_Modal"><i class="bi bi-pencil-square"></i></button>
                            </center>
                        </div>                  
                `;

                $('#profile_area').html(profileHtml);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Failed to fetch profile: ' + textStatus + ', ' + errorThrown);
            }
        });
    }

    fetchProfile();
    //

    // Load friend list
    function fetchFriends() {
        $.ajax({
            url: 'php/fetch_friends.php',
            method: 'GET',
            success: function(response) {
                try {
                    //console.log('Raw response:', response);
                    const friends = response; // Parse response as JSON
                    //console.log('Parsed friends:', friends);

                    if (Array.isArray(friends)) { // Check if friends is an array
                        if (friends.length > 0) {
                            let friendsHtml = '';
                            friends.forEach(friend => { // Use singular variable name
                                friendsHtml += `
                                <div>
                                    <span class="text-white">
                                        <img src="img/Profilepic/${friend.profile_pic}" alt="profile-image" style="width: 50px; border-radius: 50%; margin-right: 10px">
                                        ${friend.firstname} ${friend.lastname}
                                    </span>
                                    <hr>
                                </div>
                            `;
                            });

                            $('#friends_area').html(friendsHtml); // Replace content instead of appending

                        } else {
                            // No friends to load, optionally show a message or handle this case
                            $('#friends_area').html('<p>No friends to show.</p>');
                        }
                    } else {
                        throw new TypeError('Expected an array but got ' + typeof friends);
                    }
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            },
            error: function() {
                console.error('Failed to fetch friends');
            }
        });
    }

    fetchFriends();
    //

    // fill Edit modal data
    function fetchEdit_Profile() {

        $.ajax({
            url: 'php/fetch-profile.php',
            method: 'GET',
            cache: false,
            dataType: 'json',
            success: function(response) {
                const profile_data = response;
                let profileEditHtml = '';

                profileEditHtml = `
            <div class="row align-items-start">
                <div class="mb-3 col-md-6" >
                    <label for="edit_firstname" class="form-label">First name</label>
                    <input type="text" class="form-control" id="edit_firstname" name="edit_firstname" value="${profile_data.firstname}" >
                </div>
                <div class="mb-3 col-md-6">
                    <label for="edit_lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="edit_lastname" id="edit_lastname" value="${profile_data.lastname}" required>
                </div>
            </div>

            <div class="mb-3 col-md-12">
                <label for="edit_username" class="form-label">Username</label>
                <input type="text" class="form-control" name="edit_username" id="edit_username" value="${profile_data.username}" required >
            </div>
            <div class="mb-3 col-md-12">
                <label for="edit_email" class="form-label">Email</label>
                <input type="email" class="form-control" name="edit_email" id="edit_email" value="${profile_data.email}" required>
            </div>

            <label for="gender" class="form-label">Gender</label>

            <div class="row mb-4">
 `;
                if (profile_data.gender == "male") {
                    profileEditHtml += `
                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="edit_gender" id="male" value="male" checked=true required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                            
                </div>

                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="edit_gender" id="female" value="female" required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>

            </div>
            `;
                } else {
                    profileEditHtml += `
                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="edit_gender" id="male" value="male"  required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                            
                </div>

                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="edit_gender" id="female" value="female" checked=true required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>

            </div>
            `;
                }

                profileEditHtml += `

            <div class="col-md-12 mb-5">
                <div class="mb-3">
                    <label for="edit_profile_pic" class="form-label">Profile Picture</label>
                    <input class="form-control" type="file" id="edit_profile_pic" name="edit_profile_pic">
                </div>
            </div>

          </div>
          <div class="modal-footer">
            <input type="submit" id="btn_post" value="Update" class="btn btn-primary" width="100%">
          </div>

            `;

                $('#profile_edit_Form').html(profileEditHtml);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Failed to fetch profile: ' + textStatus + ', ' + errorThrown);
            }
        });
    }

    fetchEdit_Profile()
        //

    // Update profile data
    $('#profile_edit_Form').submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);

        $.ajax({
            url: 'php/update-profile.php',
            method: 'POST',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {

                if (response.status === 200) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Profile Updated Successfully!",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {

                        $('#profile_edit_Form')[0].reset();
                        $('#edit_Modal').modal('hide');
                        fetchEdit_Profile();
                        fetchProfile();
                    });
                } else if (response.status === 201) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "This email already exists. Try with another email!",
                    });
                } else if (response.status === 202) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "This username already exists. Try with another username!",
                    });
                } else if (response.status === 203) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Registration Error!",
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Unexpected error. Please try again later.",
                    });
                }
            },
            error: function(response) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: response.responseText || "An error occurred. Please try again.",
                });
            }
        });
    });
    //

});