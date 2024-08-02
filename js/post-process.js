$(document).ready(function() {
    let offset = 0;
    const limit = 10;
    let loading = false;

    function fetchPosts() {
        if (loading) return;
        loading = true;
        $('#loader').text('Loading...')

        $.ajax({
            url: 'php/fetch_posts.php',
            method: 'GET',
            data: { offset: offset, limit: limit },
            success: function(response) {
                try {
                    const posts = response;
                    //console.log('Parsed posts:', posts); // Log the parsed response
                    if (posts.length > 0) {
                        let postsHtml = '';
                        posts.forEach(post => {
                            if (post.post_image.length > 0) {
                                postsHtml += `
                                <!-- Card -->
                                <div class="card post-area glass-effect">
                                    <!-- Card Header-->
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="row col-md-10">
                                                <div class="col-md-2" style="min-width: 100px;margin-right:5px;">
                                                    <!-- Post user Profile--> 
                                                    <img src="img/profilepic/${post.profile_pic}" alt="${post.profile_pic}" class="post-header-profile-image">  
                                                    <!-- !Post user Profile--> 
                                                </div>
                                                    <div class="col-md-6" > 
                                                        <!-- Post user name/date-->
                                                        <h4 class="post-header-username">${post.firstname} ${post.lastname}</h4>
                                                        <span class=" post-header-date ">${post.created_at}</span>
                                                        <!-- !Post user name/date-->
                                                    </div>
                                                
                                            </div>
                                            <div class="dropdown col-md-2" style="text-align:right;">
                                                <!-- Post Edit-->
                                                <i class="bi bi-three-dots " id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <ul class="dropdown-menu glass-effect text-white" aria-labelledby="dropdownMenuButton1">
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Edit</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="bi bi-trash"></i> Delete</a></li>
                                                </ul>
                                                </i>
                                                <!-- !Post Edit-->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- !Card Header-->
    
                                    <!-- Card Body-->
                                    <div class="card-body" style="background-color: #3C3E41;"> 
                                        <div> 
                                            <!-- Post Description--> 
                                            <p>${post.description}</p>
                                            <!-- !Post Description--> 
                                        </div> 
                                        <!-- Post Image-->
                                        <img src="img/post_images/${post.post_image}" alt="post-image" class="post-image">  
                                        <!-- !Post Image--> 
                                    </div> 
                                    <!-- Post like--> 
                                    
                                    `;
                                if (post.liked == 1) {
                                    postsHtml += `
                                            <div class="card-footer">
                    
                                            <p><span id="${post.post_id}_likeCount" >Likes : ${post.post_likes}</span></p>
                                            <img id="${post.post_id}" src="img/system/liked.png" alt="like button" class="like-btn like-me"> </span>
                                            </div>
                                            <!-- Post like--> 
                                        </div>
                                        <!-- !Card -->
                                        `;
                                } else {
                                    postsHtml += `
                                            <div class="card-footer">
                                            
                                             <p><span id="${post.post_id}_likeCount" >Likes : ${post.post_likes}</span></p>
                                            <img id="${post.post_id}" src="img/system/like.png" alt="like button" class="like-btn like-me"> </span>
                                            </div>

                                           
                                            <!-- Post like--> 
                                        </div>
                                        <!-- !Card -->
                                        `;
                                }

                            } else {
                                postsHtml += `
                            <!-- Card -->
                            <div class="card post-area glass-effect">
                                <!-- Card Header-->
                                <div class="card-header">
                                    <div class="row">
                                        <div class="row col-md-10">
                                            <div class="col-md-2" style="min-width: 100px;margin-right:5px;">
                                                <!-- Post user Profile--> 
                                                <img src="img/profilepic/${post.profile_pic}" alt="${post.profile_pic}" class="post-header-profile-image">  
                                                <!-- !Post user Profile--> 
                                            </div>
                                                <div class="col-md-6" > 
                                                    <!-- Post user name/date-->
                                                    <h4 class="post-header-username">${post.firstname} ${post.lastname}</h4>
                                                    <span class=" post-header-date ">${post.created_at}</span>
                                                    <!-- !Post user name/date-->
                                                </div>
                                            
                                        </div>
                                        <div class="dropdown col-md-2" style="text-align:right;">
                                            <!-- Post Edit-->
                                            <i class="bi bi-three-dots " id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <ul class="dropdown-menu glass-effect text-white" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-trash"></i> Delete</a></li>
                                            </ul>
                                            </i>
                                            <!-- !Post Edit-->
                                        </div>
                                    </div>
                                </div>
                                <!-- !Card Header-->

                                <!-- Card Body-->
                                <div class="card-body" style="background-color: #3C3E41;"> 
                                    <div> 
                                        <!-- Post Description--> 
                                        <p>${post.description}</p>
                                        <!-- !Post Description--> 
                                    </div> 
                                    <!-- Post Image-->
                                    <!-- no post image here -->  
                                    <!-- !Post Image--> 
                                </div> 
                                <!-- Post like--> 
                                `;
                                if (post.liked == 1) {
                                    postsHtml += `
                                            <div class="card-footer">
                                            <p>Likes : ${post.post_likes} <span id="${post.post_id}_liked">and you</span></p>
                                            <img id="${post.post_id}" src="img/system/liked.png" alt="like button" class="like-btn like-me"> </span>
                                            </div>
                                            <!-- Post like--> 
                                        </div>
                                        <!-- !Card -->
                                        `;
                                } else {
                                    postsHtml += `
                                            <div class="card-footer row">
                                            <p><span id="${post.post_id}_likeCount" >Likes : ${post.post_likes}</span></p>
                                            <img id="${post.post_id}" src="img/system/like.png" alt="like button" class="like-btn like-me"> </span>
                                            </div>
                                            <!-- Post like--> 
                                        </div>
                                        <!-- !Card -->
                                        `;
                                }
                            }

                        });
                        $('#post_area').append(postsHtml);
                        offset += posts.length;
                        //console.log('New offset:', offset); // Log the new offset value
                        loading = false;
                        $('#loader').text('Load more..');

                    } else {
                        // No more posts to load
                        $('#loader').text('No more posts');
                    }
                    //console.log("Data correctly processed"); // This should now log

                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                }
            },
            error: function() {
                console.error('Failed to fetch posts');
                loading = false;
                $('#loader').text("Failed to fetch posts");
            }
        });
    }


    // Initial fetch
    fetchPosts();

    // load more posts
    $("#loader").click(function() {
        fetchPosts();
    });

});