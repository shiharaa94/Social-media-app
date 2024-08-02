$(document).ready(function() {
    $(document).on('click', '.like-me', function(e) {
        e.preventDefault();
        var id = $(this).attr('id');
        $.ajax({
            url: 'php/post-like.php',
            method: 'POST',
            data: { id: id },
            cache: false,
            dataType: 'json',
            success: function(response) {
                if (response.liked === "yes") {
                    $('#' + response.id).attr('src', 'img/system/liked.png');
                    $('#' + response.id + '_likeCount').text('Likes: ' + response.post_likes);
                } else {
                    $('#' + response.id).attr('src', 'img/system/like.png');
                    $('#' + response.id + '_likeCount').text('Likes: ' + response.post_likes);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Failed to fetch likes: ' + textStatus + ', ' + errorThrown);
            }
        });
    });
});