<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Declaration;
use App\Models\Paiement;

use Carbon;


class HomeController extends Controller
{
    
    public function __construct(Request $request)
    {
        // $this->middleware('auth');		
    }

	
    public function stats_journalieres()
    {
		
        return view('stats_journalieres');
		
    }
	
	
    public function declarations(Request $request)
    {
		$declarations = Declaration::where(['TDBDECLARATIONSTATUT'=>'VALIDE'])->get()->sortBy('TDBDECLARATIONDATE');
		
		foreach($declarations as $declaration){
			
			$timestamp = strtotime($declaration->TDBDECLARATIONDATE);
			
			$montant = $declaration->TDBDECLARATIONMONT;
			
			$data[] = array($timestamp, $montant);
		}
		
        return $data;
		
    }
	
    public function paiements(Request $request)
    {
		$paiements 	  = Paiement::where(['TDBPAIEMENTSTATUT'=>'VALIDE'])->get()->sortBy('TDBPAIEMENTDATE');
		
		foreach($paiements as $paiement){
			
			$timestamp = strtotime($paiement->TDBPAIEMENTDATE);
			
			$montant = $paiement->TDBPAIEMENTMONT;
			
			$data[] = array($timestamp, $montant);
		}
		
        return $data;
		
    }
	
	
	
    public function stats_journalieres_data(Request $request)
    {
		$search_date_fin = $request->d;
		
		$today = !empty($search_date_fin)? $search_date_fin : gmdate('Y-m-d');
		$date_debut = Carbon::parse($today)->subDays(30)->format('d-m-Y');
		
		$data = [];
		for($i=0;$i<31;$i++){
			
			$date = Carbon::parse($date_debut)->addDays($i)->format('Y-m-d');
			
			$declaration = Declaration::where(['TDBDECLARATIONDATE'=>$date, 'TDBDECLARATIONSTATUT'=>'VALIDE'])->first();
			$paiement 	  = Paiement::where(['TDBPAIEMENTDATE'=>$date, 'TDBPAIEMENTSTATUT'=>'VALIDE'])->first();
			
			$data['dates'][] 		= Carbon::parse($date)->format('d-m-Y');
			$data['declarations'][] = !empty($declaration)? $declaration->TDBDECLARATIONMONT : 0;
			$data['paiements'][] 	= !empty($paiement)? $paiement->TDBPAIEMENTMONT : 0;
			
		}
		
        return $data;
		
    }
	
	
	
}
