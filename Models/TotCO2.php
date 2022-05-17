<?php

class TotCO2 {

	protected $db;

	function __construct($db) {

		$this->db = $db;
	}

	function list($dataDa, $dataA, $paese, $prodottoId) {

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

        if ($prodottoId !== null) {
            $where[] = "(Prodotti.id = :prodottoId)";
            $parameters['prodottoId'] = $prodottoId;
        }

		$whereClause = '';

		if (count($where) > 0) {

			$whereClause = "WHERE " . join(' AND ', $where);
		}

		$recordset = $this->db->select(
			"
				SELECT SUM(Prodotti.CO2 * OrdiniRighe.Quantita) AS CO2Risparmiata

				FROM Ordini

                LEFT JOIN OrdiniRighe
                    ON OrdiniRighe.idOrdine = Ordini.id

                LEFT JOIN Prodotti
                    ON Prodotti.id = OrdiniRighe.idProdotto

				{$whereClause}

			",
			$parameters
		);

		if ($recordset !== false) {

            return $recordset;
		}
	}

}
