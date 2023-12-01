<?php

namespace Controllers;

use Models\ServiceModel;

class ServicesController
{
    public function index()
    {
        // Affiche la liste des services
        $services = ServiceModel::getAllServices();
        // Affiche une vue avec la liste des services
        // Exemple : return view('services.index', ['services' => $services]);
    }

    public function create()
    {
        // Affiche le formulaire de création d'un service
        // Exemple : return view('services.create');
    }

    public function store($request)
    {
        // Valide et enregistre un nouveau service dans la base de données
        $serviceName = $request->input('serviceName');
        ServiceModel::addService($serviceName);
        // Redirige vers la liste des services après ajout
        // Exemple : return redirect('/services');
    }

    public function edit($id)
    {
        // Récupère les informations du service à modifier
        $service = ServiceModel::getServiceById($id);
        // Affiche le formulaire d'édition avec les données du service
        // Exemple : return view('services.edit', ['service' => $service]);
    }

    public function update($request, $id)
    {
        // Valide et met à jour les informations du service dans la base de données
        $newName = $request->input('newName');
        ServiceModel::updateService($id, $newName);
        // Redirige vers la liste des services après modification
        // Exemple : return redirect('/services');
    }

    public function destroy($id)
    {
        // Supprime le service de la base de données
        ServiceModel::deleteService($id);
        // Redirige vers la liste des services après suppression
        // Exemple : return redirect('/services');
    }
}
