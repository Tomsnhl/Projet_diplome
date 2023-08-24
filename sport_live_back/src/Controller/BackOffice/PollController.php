<?php

namespace App\Controller\BackOffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/polls")
 */
class PollController extends AbstractController {

    /**
     * @Route("/", name="admin_polls_index")
     */
    public function index() {
        // Récupérez tous les sondages et affichez-les
    }

    /**
     * @Route("/new", name="admin_polls_new")
     */
    public function create() {
        // Affichez un formulaire pour créer un nouveau sondage et sauvegardez-le
    }

    /**
     * @Route("/{id}", name="admin_polls_show")
     */
    public function show($id) {
        // Affichez les détails d'un sondage spécifique
    }

    /**
     * @Route("/{id}/edit", name="admin_polls_edit")
     */
    public function edit($id) {
        // Affichez un formulaire pour modifier un sondage spécifique et sauvegardez les modifications
    }

    /**
     * @Route("/{id}/delete", name="admin_polls_delete")
     */
    public function delete($id) {
        // Supprimez un sondage spécifique
    }

    /**
     * @Route("/{id}/answers", name="admin_polls_answers")
     */
    public function answers($id) {
        // Affichez toutes les réponses pour un sondage spécifique
    }

    // ... Ajoutez d'autres méthodes si nécessaire
}
