<?php
include('etudiant.php');

class Matiere extends Etudiant {
    private $notes = [];

    public function __construct($id, $name) {
        parent::__construct($id, $name);
    }

    public function ajouterNote($etudiantId, $note) {
        $this->notes[$etudiantId] = $note;
    }

    public function modifierNote($etudiantId, $note) {
        
    }

    public function supprimerNote($etudiantId) {

    }

    public function consulterNotes() {
        return $this->notes;
    }
}