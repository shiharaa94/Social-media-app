$(document).ready(function() {

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
});