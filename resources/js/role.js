$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"').attr("content"),
    },
});


// delete advert
$("#roleTable").on("click", ".delete-Button", function() {
    const roleId = $(this).data("id");

    if (roleId) {
        Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3F83F8",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Suppression de l'annonce via une requête AJAX
                $.ajax({
                    url: `roles/${roleId}`,
                    type: "DELETE",
                    success: function(response) {
                        console.log(response);
                        if (response.status === "success") {
                            // Annonce supprimée avec succès
                            Swal.fire({
                                title: "Deleted!",
                                text: "Role has been deleted.",
                                icon: "success",
                                timer: 1500,
                            });

                            // Supprimer la ligne du tableau correspondant à l'annonce supprimée
                            $(`#role_${roleId}`).remove();
                        } else {
                            // Échec de la suppression
                            Swal.fire({
                                title: "Failed!",
                                text: "Unable to delete Role!",
                                icon: "error",
                            });
                        }
                    },
                    error: function(error) {
                        // Erreur lors de la requête AJAX
                        Swal.fire({
                            title: "Failed!",
                            text: "Unable to delete Role!",
                            icon: "error",
                        });
                    },
                });
            }
        });
    }
});
