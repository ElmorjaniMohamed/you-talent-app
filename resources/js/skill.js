$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"').attr("content"),
    },
});


// delete advert
$("#skillTable").on("click", ".delete-Button", function() {
    const skillId = $(this).data("id");

    if (skillId) {
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
                    url: `skills/${skillId}`,
                    type: "DELETE",
                    success: function(response) {
                        console.log(response);
                        if (response.status === "success") {
                            // Annonce supprimée avec succès
                            Swal.fire({
                                title: "Deleted!",
                                text: "Skill has been deleted.",
                                icon: "success",
                                timer: 1500,
                            });

                            // Supprimer la ligne du tableau correspondant à l'annonce supprimée
                            $(`#skill_${skillId}`).remove();
                        } else {
                            // Échec de la suppression
                            Swal.fire({
                                title: "Failed!",
                                text: "Unable to delete Skill!",
                                icon: "error",
                            });
                        }
                    },
                    error: function(error) {
                        // Erreur lors de la requête AJAX
                        Swal.fire({
                            title: "Failed!",
                            text: "Unable to delete Skill!",
                            icon: "error",
                        });
                    },
                });
            }
        });
    }
});
