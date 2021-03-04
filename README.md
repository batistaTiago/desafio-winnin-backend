# Desafio Backend Winnin - Solucao por Tiago Batista

Para rodar o sistema, deve-se seguir os passos definidos no arquivo `initial-setup.sh`.


Obs: a obtenção dos dados na API do Reddit foi feita utilizando um CRON com a configuracao "0 0 * * *", isto é, todos os dias à meia noite. A rotina que é executada pelo cron pode ser verificada no arquivo `src/app/Console/Kernel.php` e `src/app/Console/Commands/FetchRedditHotData.php`.

Para rodar os testes: `docker-compose exec php bash -c "php artisan config:clear && ./vendor/bin/phpunit ./tests"` (podendo passar a flag `--testdox` opcionalmente)

A porta exposta da API, por padrão, é a 8100 mas isso pode ser configurado no arquivo `docker-compose.yml`, dentro do serviço nginx.

Os endpoints desenvolvidos estão no arquivo `routes/api.php` e ambos utilizam os seguintes parâmetros de entrada (que devem ser passados em formato query_string):

*OBRIGATORIO* `start_date` e `end_date`-> define um intervalo de tempo (entre duas strings em formato datetime) em que o post deve ter sido criado para ser considerado no retorno

*OBRIGATORIO* `sort_key` -> define qual parâmetro deve ser usado na ordenação dos itens da lista de retorno, e pode assumir exclusivamente as strings: "count_up_votes" e "count_comments"


1 - GET /api/v1/posts
http://localhost:8100/api/v1/posts?start_date=2021-02-03&end_date=2021-03-03&sort_key=count_up_votes
\[Retorno\]

```json
{
    "sucesso": true,
    "data": [
        {
            "id": 59,
            "author": "TheInsaneApp",
            "title": "How to keep kids away from TV - The Artificial Intelligence Way",
            "count_comments": 383,
            "count_up_votes": 76,
            "original_id": "lvuwf7",
            "created_at": "2021-03-02T05:36:15.000000Z",
            "updated_at": null
        },
        {
            "id": 68,
            "author": "new_confusion_2021",
            "title": "Made my computer trip balls (GAN trained on psychedelic and visionary artworks)",
            "count_comments": 448,
            "count_up_votes": 35,
            "original_id": "lvfua3",
            "created_at": "2021-03-01T18:03:55.000000Z",
            "updated_at": null
        },
        {
            "id": 67,
            "author": "mr_j_b",
            "title": "US Currently Incapable Of Defense Against Artificial Intelligence Threats",
            "count_comments": 15,
            "count_up_votes": 7,
            "original_id": "lw0jsl",
            "created_at": "2021-03-02T12:09:47.000000Z",
            "updated_at": null
        },
        // ...
    ]
}
```



2 - GET /api/v1/posts
http://localhost:8100/api/v1/authors?start_date=2021-02-03&end_date=2021-03-03&sort_key=count_comments
\[Retorno\]

```json
{
    "sucesso": true,
    "data": [
        {
            "author": "new_confusion_2021",
            "count_comments": "448",
            "count_up_votes": "35"
        },
        {
            "author": "TheInsaneApp",
            "count_comments": "383",
            "count_up_votes": "76"
        },
        {
            "author": "rikki_hi",
            "count_comments": "43",
            "count_up_votes": "2"
        },
        {
            "author": "mr_j_b",
            "count_comments": "21",
            "count_up_votes": "10"
        },
        // ...
    ]
}
```

Estou incluindo, dentro da pasta `src`, um arquivo `.env`, com todas as variáveis de ambientes necessárias para rodar o sistema. Nele, estão as credenciais para conectar no banco local que usei como testes (as mesmas que estão definidas no arquivo `docker-compose.yml`, dentro do serviço mysql). O nome do banco em questão foi 'test_winnin', mas pode ser ajustado conforme a preferência.


Na descrição do desafio proposto estava dizendo que poderia ser feito em qualquer linguagem, mas que era preferível que fosse feito em Node ou Go. Apesar de ter exposição ao ambiente Node, não cheguei a praticar tanto a linguagem. Decidi fazer em PHP/Laravel pois é a ferramenta com a qual tenho mais familiaridade e posso entregar um trabalho melhor em menos tempo, mas não acho que fazer em Node seria um impeditivo considerando o prazo que foi dado.


Obrigado pela oportunidade.