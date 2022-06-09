<?php

// Importation de PhpOffice
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;






if(isset($_FILES['file'])){
	
	$fileOk=true;
	
	$filename=basename($_FILES['file']['name']);
	$ext=pathinfo($filename, PATHINFO_EXTENSION);
	$tmp=$_FILES['file']['tmp_name'];
	$type=$_FILES['file']['type'];
	$size=$_FILES['file']['size'];
	$error=$_FILES['file']['error'];
	$extensions=array('xlsx','xls');
	$createdAt=date("Ymd");

	if(!in_array($ext, $extensions) || $size>10*1024*1024){
		$fileOk=false;		
	}



	$file_renamed="Adwa_transac_".$createdAt.".".$ext;

	if($fileOk==true){
		if(move_uploaded_file($tmp, $file_renamed)){
			// Initialisation de PhpOffice
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			// Chargement du fichier
			$spreadsheet = $reader->load($file_renamed);
			// Lecture du fichier, récupération des données sous forme d'array
			$sheetData = $spreadsheet->getActiveSheet()->toArray();



			// Liste des mots pouvant se trouver dans la 1ère ligne (les titres) du fichier excel
			 $head = "numéros numero tel moyen paiement montant prix";
			 $deleteFirstLine=false;


			foreach($sheetData[0] as $sheet){
			// Si il y'a un titre vide dans la ligne des titres
				if(empty($sheet)){
					$deleteFirstLine=true;

				}else{
				
			// Si les mots de la 1ère ligne se retrouve dans notre liste des titres
				if(substr_count(strtolower($head), strtolower($sheet))>0){
					$deleteFirstLine=true;
				}	
			  }

			}


			if($deleteFirstLine==true){
			// Suppression de la 1ère ligne (ligne des titres)
				unset($sheetData[0]);
			}

			// Déclaration du array qui contiendra les infos de toutes les transaction à éffectuer
			$datas=array();
			foreach ($sheetData as $data) {
				

			// Récupértion d'une ligne du tableur et enregistrement en tant que objet
				$item=[
					"number"=>str_replace(" ", "", $data[0]),
					"type"=>$data[1],
					"amount"=>intval(str_replace(" ", "", $data[2]))
				];


			// Si aucune donnée de la ligne (numéro,type,montant) n'est manquante
				if(!empty($data[0]) && !empty($data[1]) && !empty($data[2])){

			// Ajout de la ligne (de l'objet) dans le array des infos
					array_push($datas, $item);
				}
			}


			var_dump($datas);

			// Si le fichier contient des informations
			if(!empty($datas)){

			// // Parcours des données recoltés
			// 	foreach($datas as $data){

			// // Définition des paramètres
			// 		$param=[
			// 			"number"=>$data['number'],
			// 			"type"=>$data['type'],
			// 			"amount"=>$data['amount']
			// 		];

			// //******* Call Webservice here *******

			// 	}


			}else{
				//No data in the file
				echo "No data in the file";
			}
		}	
	}else{
		echo "Erreur de récupératon des données ! Veuillez vérifier la taille du fichier (<10 Mo) et son extension (xls, xlsx)";
	}
	

}else if(isset($_POST['number'])){

		$param=[
			"number"=>$_POST['number'],
			"type"=>$_POST['type'],
			"amount"=>$_POST['amount']
		];

		var_dump($param);

}





?>
