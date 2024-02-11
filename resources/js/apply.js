$(document).ready(function() {

    $('.apply-btn').click(function(e) {
        e.preventDefault(); 
        var advertId = $(this).data('advert-id');

        $.ajax({
            url: '/adverts/' + advertId + '/apply',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    title: "Apply Success!",
                    icon: "success",
                    timer: 1500,
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Failed!",
                    text: "Unable to apply Advert!",
                    icon: "error",
                });
            }
        });
    });
});
