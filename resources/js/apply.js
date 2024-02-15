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
                if (response.message === 'Application successful') {
                    Swal.fire({
                        title: "Apply Success!",
                        icon: "success",
                        timer: 1500,
                    });
                } else {

                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                    });
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 400 && xhr.responseJSON && xhr.responseJSON.message === 'You have already applied to this advertisement') {
                    Swal.fire({
                        title: "Already Applied!",
                        text: xhr.responseJSON.message,
                        icon: "info",
                    });
                } else {

                    Swal.fire({
                        title: "Failed!",
                        text: "Administrators and super administrators cannot apply to advertisements",
                        icon: "error",
                    });
                }
            }
        });
    });
});
