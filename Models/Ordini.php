<?php

class Ordini {

	protected $db;

	function __construct($db) {

		$this->db = $db;
	}

	function list($dataDa, $dataA, $paese) {

		$parameters = array();

		$where = array();

		if ($dataDa !== null && $dataA !== null) {

			$where[] = "(Ordini.Data BETWEEN :dataDa AND :dataA)";
			$parameters['dataDa'] = $dataDa;
			$parameters['dataA'] = $dataA;
		}

		if ($paese !== null) {

			$where[] = "(Ordini.PaeseDestinazione = :paese)";
			$parameters['paese'] = $paese;
		}

		$whereClause = '';

		if (count($where) > 0) {

			$whereClause = "WHERE " . join(' AND ', $where);
		}

		$recordset = $this->db->select(
			"
				SELECT
					Ordini.id,
					Ordini.Data,
					Ordini.PaeseDestinazione

				FROM Ordini

				{$whereClause}

				ORDER BY Data
			",
			$parameters
		);

		if ($recordset !== false) {

			$recordset = array_map(function($ordine) {

				$ordine['id'] = (int)$ordine['id'];

				return $ordine;

			}, $recordset);

			return $recordset;
		}
	}


	function get($id) {

		$recordset = $this->db->select(
			"
				SELECT
					Ordini.id,							-- 0
					Ordini.Data,						-- 1
					Ordini.PaeseDestinazione,			-- 2

					OrdiniRighe.idProdotto,
					OrdiniRighe.Quantita,

					Prodotti.Nome,
					Prodotti.CO2,

					Prodotti.CO2 * OrdiniRighe.Quantita AS CO2Risparmiata

				FROM Ordini

					LEFT JOIN OrdiniRighe
						ON OrdiniRighe.idOrdine = Ordini.id

					LEFT JOIN Prodotti
						ON Prodotti.id = OrdiniRighe.idProdotto

				WHERE Ordini.id = :idOrdine
			",
			array(
				'idOrdine' => $id
			)
		);

		if ($recordset !== false) {

			if (count($recordset) === 0)
				return null;

			$ordine = array();
 
			foreach ($recordset as $i => $row) {

				if ($i === 0) {
					$ordine['id'] = (int)$row['id'];
					$ordine['Data'] = $row['Data'];
					$ordine['PaeseDestinazione'] = $row['PaeseDestinazione'];

					$ordine['righe'] = array();
				}
				
				$ordine['righe'][] = array(
					'idProdotto' => $row['idProdotto'],
					'Nome' => $row['Nome'],
					'Quantita' => (int)$row['Quantita'],
					'CO2' => (float)$row['CO2'],
				);
			}

			return $ordine;

		} else {

			echo 'errore query';
		}
	}

	function create(array $data) {


		$sql = "INSERT INTO Ordini (Data, PaeseDestinazione) VALUES (:Data, :PaeseDestinazione)";

		$st = $this->db->getConnection()->prepare($sql);

		$parameters = array(
			'Data' => $data['Data'],
			'PaeseDestinazione' => $data['PaeseDestinazione'],
		);

		if ($st->execute($parameters) /* === true */) {

			$id = $this->db->getConnection()->lastInsertId();



			$this->creaRigheOrdine($id, $data['righe']);

			return $id;
		}
	}

	function update($id, array $data) {


		$sql = "UPDATE Ordini SET Data = :Data, PaeseDestinazione = :PaeseDestinazione WHERE id = :id";
		$st = $this->db->getConnection()->prepare($sql);

		$parameters = array(
			'id' => $id,
			'Data' => $data['Data'],
			'PaeseDestinazione' => $data['PaeseDestinazione'],
		);

		if ($st->execute($parameters) !== false) {

			$this->cancellaRigheOrdine($id);

			$this->creaRigheOrdine($id, $data['righe']);
		}
	}

	function delete($id) {

		$sql = "DELETE FROM Ordini WHERE id = :id";
		$st = $this->db->getConnection()->prepare($sql);

		if ($st->execute(array('id' => $id)) !== false) {

			$this->cancellaRigheOrdine($id);
		}
	}

	protected function creaRigheOrdine($id, $righe) {

		foreach ($righe as $row) {
			$sql = "
				INSERT INTO OrdiniRighe
					(idOrdine, idProdotto, Quantita)
				VALUES
					(:idOrdine, :idProdotto, :Quantita)
			";

			$st = $this->db->getConnection()->prepare($sql);

			$parameters = array(
				'idOrdine' => $id,
				'idProdotto' => $row['idProdotto'],
				'Quantita' => $row['Quantita'],
			);

			if ($st->execute($parameters) /* === true */) {}
		}
	}

	protected function cancellaRigheOrdine($id) {

		$sql = "DELETE FROM OrdiniRighe WHERE idOrdine = :id";
		$st = $this->db->getConnection()->prepare($sql);

		$st->execute(array('id' => $id));
	}
}
