<?php

class Prodotti
{

    protected $db;

    function __construct($db)
    {

        $this->db = $db;
    }

    function list()
    {

        $parameters = array();

        $recordset = $this->db->select(
            "
				SELECT
					Prodotti.id,
					Prodotti.Nome,
					Prodotti.CO2

				FROM Prodotti
			",
            $parameters
        );

        if ($recordset !== false) {

            $recordset = array_map(function ($prodotto) {

                $prodotto['id'] = (int)$prodotto['id'];

                return $prodotto;
            }, $recordset);

            return $recordset;
        }
    }


    function get($id)
    {

        $recordset = $this->db->select(
            "
                SELECT
                    Prodotti.id,
                    Prodotti.Nome,
                    Prodotti.CO2

                FROM Prodotti

                WHERE Prodotti.id = :id
			",
            array(
                'id' => $id
            )
        );

        if ($recordset !== false) {

            $recordset = array_map(function ($prodotto) {

                $prodotto['id'] = (int)$prodotto['id'];

                return $prodotto;
            }, $recordset);

            return $recordset;
        }
    }


    function getName($nome)
    {

        $recordset = $this->db->select(
            "
                SELECT
                    Prodotti.id,
                    Prodotti.Nome,
                    Prodotti.CO2

                FROM Prodotti

                WHERE Prodotti.Nome = :Nome
			",
            array(
                'Nome' => $nome
            )
        );

        if ($recordset !== false) {

            $recordset = array_map(function ($prodotto) {

                $prodotto['id'] = (int)$prodotto['id'];

                return $prodotto;
            }, $recordset);

            return $recordset['Nome'];
        }
    }

    function create(array $data)
    {


        $sql = "INSERT INTO Prodotti (Nome, CO2) VALUES (:Nome, :CO2)";

        $st = $this->db->getConnection()->prepare($sql);

        $parameters = array(
            'Nome' => $data['Nome'],
            'CO2' => $data['CO2'],
        );

        if ($st->execute($parameters) /* === true */) {

            $id = $this->db->getConnection()->lastInsertId();

            return $id;
        }
    }

    function update($id, array $data)
    {

        $sql = "UPDATE Prodotti SET Nome = :Nome, CO2 = :CO2 WHERE id = :id";
        $st = $this->db->getConnection()->prepare($sql);

        $parameters = array(
            'id' => $id,
            'Nome' => $data['Nome'],
            'CO2' => $data['CO2'],
        );

        $st->execute($parameters);
    }

    function delete($id)
    {

        $sql = "DELETE FROM Prodotti WHERE id = :id";
        $st = $this->db->getConnection()->prepare($sql);

        $st->execute(array('id' => $id));
    }
}
