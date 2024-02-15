$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"').attr("content"),
    },
});

// create Advert
$(document).ready(function() {
    $('#createAdvertForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/admin/adverts/',
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = response.redirect_url;
                    }
                });
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', xhr.responseJSON.message, 'error');
            }
        });
    });
});

// update Advert
$(document).ready(function() {
    $('#updateAdvertForm').submit(function(e) {
        e.preventDefault();
        var advertId = $(this).data('advert-id');
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '/admin/adverts/' + advertId,
            data: formData,
            success: function(response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = response.redirect_url;
                    }
                });
            },
            error: function(xhr, status, error) {
                Swal.fire('Error!', xhr.responseJSON.message, 'error');
            }
        });
    });
});



// delete advert

    $("#advertTable").on("click", ".deleteButton", function() {
        const advertId = $(this).data("id");

        if (advertId) {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Suppression de l'annonce via une requête AJAX
                    $.ajax({
                        url: `adverts/${advertId}`,
                        type: "DELETE",
                        success: function(response) {
                            if (response.status === "success") {
                                // Annonce supprimée avec succès
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Advert has been deleted.",
                                    icon: "success",
                                    timer: 1500,
                                });

                                // Supprimer la ligne du tableau correspondant à l'annonce supprimée
                                $(`#advert_${advertId}`).remove();
                            } else {
                                // Échec de la suppression
                                Swal.fire({
                                    title: "Failed!",
                                    text: "Unable to delete Advert!",
                                    icon: "error",
                                });
                            }
                        },
                        error: function(error) {
                            // Erreur lors de la requête AJAX
                            Swal.fire({
                                title: "Failed!",
                                text: "Unable to delete Advert!",
                                icon: "error",
                            });
                        },
                    });
                }
            });
        }
    });

