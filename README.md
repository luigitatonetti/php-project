# PHP FIRST PROJECT

## Descrizione
Attraverso l'uso di un DB mysql, questa api mostra la quantità di co2 risparmiata per alcuni prodotti quando vengono effettutati degli ordini.


## Uso


- Prodotti

    -  Elenco degli prodotti:            GET    .../prodotti
    - Creazione Prodotto:               POST   .../prodotti         (payload nel body json)
    - Modifica Prodotto:                PUT    .../prodotti/2       (payload nel body json)
    - Cancellazione Prodotto:           DELETE .../prodotti/2
    

- Ordini

    - Elenco degli ordini:            GET    .../ordini
    - Elenco degli ordini filtrato:   GET    .../ordini?range=2021-04-01,2022-05-10&paese=italia
    - Dettaglio Ordine:               GET    .../ordini/2
    - Creazione Ordine:               POST   .../ordini         (payload nel body json)
    - Modifica Ordine:                PUT    .../ordini/2       (payload nel body json)
    - Cancellazione Ordine:           DELETE .../ordini/2

- Totale co2 risparmiata

    - Totale co2 risparmiata:            GET    .../totCO2
    - Totale co2 risparmiata filtrato:   GET    .../totCO2?range=2021-04-01,2022-05-10&paese=italia
