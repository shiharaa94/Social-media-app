$(document).ready(function() {

    console.log("post-create js loaded ready");

    $('#post_Create_Form').submit(function(e) {
        console.log("form submitted");
        e.preventDefault();

        const fd = new FormData(this);
        $('#btn_post').text('Please Wait..');

        $.ajax({
            url: 'php/create-post.php',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Post Created Successfully.!",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#btn_post').text('Post');
                        $('#post_Create_Form')[0].reset();
                        $('#create_Modal').modal('hide');
                    });
                } else if (response.status == 201) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Internal server error.!",
                    });
                } else if (response.status == 202) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Internal server error in image upload.!",
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "An error occurred: " + xhr.status + " " + error,
                });
                $('#btn_post').text('Post');
            }
        });
    });
});