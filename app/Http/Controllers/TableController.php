<?php

namespace App\Http\Controllers;

class TableController extends Controller
{
    
    public function table_casier()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Acceuil"], ['name' => "FiveAIM LPSD"]];
        return view('/content/table/table-bootstrap/index_casier', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    public function table_creation_casier()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Acceuil"], ['name' => "FiveAIM LPSD"]];
        return view('/content/table/table-bootstrap/create_casier', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    public function table_profil_casier()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Acceuil"], ['name' => "FiveAIM LPSD"]];
        return view('/content/table/table-bootstrap/profil_casier', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
    
    



    public function table_utilisateur()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Acceuil"], ['name' => "FiveAIM LPSD"]];
        return view('/content/table/table-bootstrap/table_utilisateur', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    
    public function login()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Acceuil"], ['name' => "FiveAIM LPSD"]];
        $logo = Logo::first();
        return view('/content/table/table-bootstrap/login', [
            'breadcrumbs' => $breadcrumbs,
            'logo'=>$logo
        ]);
    }
}
