<?php

include_once 'APIResponse.php';
include_once 'APIRequest.php';

include_once 'db.php';
include_once 'Models/Ordini.php';
include_once 'Models/Prodotti.php';
include_once 'Models/TotCO2.php';

$request = new APIRequest();
$request->decodeHTTPRequest();

$response = new APIResponse();
$response->addHeader('Content-Type', 'application/json; charset=UTF-8');

$db = new DB('localhost:3306', 'root', 'Nameless12!', 'progettos2i');

$db->openConnection();
if (!$db->isConnectionOpen()) {

	// ho avuto un errore di connessione

	$response->setResponseCode(500);
	$response->setBody(array(
		'error' => "Impossibile connettersi con il DB",
	));
	$response->printAnswer();

	exit;
}

if ($request->getEntity() === 'ordini') {

	$modelOrdini = new Ordini($db);

	if (
		$request->isGET() 								// $request->getMethod() === 'GET'
		&& $request->hasEntityId()						// $request->getIdEntity() !== null
	) {

		$ordine = $modelOrdini->get($request->getIdEntity());
		if ($ordine === null) {

			$response->setResponseCode(404);
		} else {

			$response->setBody($ordine);
		}
	} else if (
		$request->isGET()
		&& !$request->hasEntityId()
	) {

		$dataDa = $dataA = null;
		if ($request->hasQSParameter('range')) {

			$range = $request->getQSParameter('range');


			$p = explode(',', $range);

			$dataDa = $p[0];
			$dataA = $p[1];
		}

		$paese = null;
		if ($request->hasQSParameter('paese')) {

			$paese = $request->getQSParameter('paese');
		}

		$elencoOrdini = $modelOrdini->list($dataDa, $dataA, $paese);

		$response->setBody(array(
			'ordini' => $elencoOrdini,
		));
	} else if (
		$request->isPOST()
		&& !$request->hasEntityId()
	) {

		$data = $request->getBody();

		$id = $modelOrdini->create($data);

		$response->setBody(array(
			'id' => $id,
		));
	} elseif (
		$request->isPUT()
		&& $request->hasEntityId()
	) {
		$ordine = $modelOrdini->get($request->getIdEntity());

		if (empty($ordine)) {

			$response->setResponseCode(404);
		} else {


			$data = $request->getBody();

			$modelOrdini->update($request->getIdEntity(), $data);

			$response->setBody($data);
		}
	} elseif (
		$request->isDELETE()
		&& $request->hasEntityId()
	) {
		$ordine = $modelOrdini->get($request->getIdEntity());

		if (empty($ordine)) {

			$response->setResponseCode(404);
		} else {

			$modelOrdini->delete($request->getIdEntity());
		}
	}
}

if ($request->getEntity() === 'prodotti') {

	$modelProdotti = new Prodotti($db);

	if (
		$request->isGET() 								
		&& $request->hasEntityId()						
	) {

		$prodotto = $modelProdotti->get($request->getIdEntity());
		if ($prodotto === null) {

			$response->setResponseCode(404);
		} else {

			$response->setBody($prodotto);
		}
	} else if (
		$request->isGET()
		&& !$request->hasEntityId()
	) {

		$elencoProdotti = $modelProdotti->list();

		if ($elencoProdotti === null) {

			$response->setResponseCode(404);
		} else {

			$response->setBody(array(
				'prodotti' => $elencoProdotti,
			));
		}
	} else if (
		$request->isPOST()
		&& !$request->hasEntityId()
	) {

		$data = $request->getBody();

		$id = $modelProdotti->create($data);
		$response->setBody(array(
			'id' => $id,
		));

		$response->setResponseCode(201);
	} elseif (
		$request->isPUT()
		&& $request->hasEntityId()
	) {
		$prodotto = $modelProdotti->get($request->getIdEntity());

		if (empty($prodotto)) {

			$response->setResponseCode(404);
		} else {


			$data = $request->getBody();

			$modelProdotti->update($request->getIdEntity(), $data);

			$response->setBody($data);
		}
	} elseif (
		$request->isDELETE()
		&& $request->hasEntityId()
	) {
		$prodotto = $modelProdotti->get($request->getIdEntity());

		if (empty($prodotto)) {

			$response->setResponseCode(404);
		} else {

			$modelProdotti->delete($request->getIdEntity());
		}
	}
}

if ($request->getEntity() === 'totCO2') {

	$modelTotCO2 = new TotCO2($db);

	if (
		$request->isGET() 								
	) {

		$dataDa = $dataA = null;
		if ($request->hasQSParameter('range')) {

			$range = $request->getQSParameter('range');


			$p = explode(',', $range);

			$dataDa = $p[0];
			$dataA = $p[1];
		}

		$paese = null;
		if ($request->hasQSParameter('paese')) {

			$paese = $request->getQSParameter('paese');
		}

		$prodottoId = null;
		if ($request->hasQSParameter('prodottoId')) {

			$prodottoId = $request->getQSParameter('prodottoId');
		}

		$elencoTotCO2 = $modelTotCO2->list($dataDa, $dataA, $paese, $prodottoId);

		$response->setBody(array(
			'totCO2' => $elencoTotCO2,
		));
	}
}
$response->printAnswer();
