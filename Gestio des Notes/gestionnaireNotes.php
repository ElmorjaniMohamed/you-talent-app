<?php
include('Matiere.php');

class GestionnaireNotes {
    private $listeEtudiants = [];
    private $listeMatieres = [];

    public function ajouterEtudiant($id, $nom) {
        $this->listeEtudiants[$id] = new Etudiant($id, $nom);
    }
}