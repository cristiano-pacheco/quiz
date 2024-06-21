# Quiz

This application provides a quiz to suggest products after the user answers a few questions.

## Stack

- PHP 8.3
- MariaDB 11
- Nginx
- Symfony 7.1

For the developer environment it uses [nix](https://nixos.org/) + [devenv](https://devenv.sh/).

The [rooter](https://github.com/run-as-root/rooter) CLI tool was used to provision the environment.

## Installation

1. Clone the repository
2. Run `rooter env start` to start the development environment
3. Run `composer install` to install the dependencies
4. Run `bin/console doctrine:migrations:migrate` to create the database schema

## Architecture

This project an architecture based on the Hexagonal Architecture, clean archtecture and a simplified version of the DDD.

## Docs

### Database
![database.png](docs/database.png)

### Use Cases
![usecases.png](docs/usecases.png)

### Application Flow
![usecases.png](docs/application-flow.png)

## Useful commands

### Linting:
```bash
composer run sniffer
```

### PHPStan:
```bash
composer run phpstan
```

### Unit tests
```bash
composer run unit-test
```

## REST API samples:

### Quiz content

```curl
curl --location 'http://quiz.rooter.test/api/rest/v1/quizzes/5a950d59-c8b4-4f09-bd83-264c315e277b' \
--header 'Content-Type: application/json' 
```

Note: you need to pass the quizId in the URL as the last parameter.

Response as an example:

```json
{
    "quiz": {
        "quiz": {
            "id": "5a950d59-c8b4-4f09-bd83-264c315e277b",
            "name": "Sample"
        },
        "questionList": [
            {
                "question": {
                    "id": "46adf7ee-65d6-4176-a21e-d2cf19f0cf1c",
                    "quizId": "5a950d59-c8b4-4f09-bd83-264c315e277b",
                    "question": "1. Do you have difficulty getting or maintaining an erection?",
                    "sortOrder": 1
                },
                "answerList": [
                    {
                        "id": "f5d025c5-a2d6-4818-81b8-32e91d6179e3",
                        "questionId": "46adf7ee-65d6-4176-a21e-d2cf19f0cf1c",
                        "answer": "Yes",
                        "sortOrder": 1,
                        "behavior": "none",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "cd4ac311-ee9f-4748-9d6d-c8dc5d69bf9c",
                        "questionId": "46adf7ee-65d6-4176-a21e-d2cf19f0cf1c",
                        "answer": "No",
                        "sortOrder": 2,
                        "behavior": "exclude_all_products",
                        "restriction": "exclude_all_products",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    }
                ]
            },
            {
                "question": {
                    "id": "e02ff16a-9bc1-417b-8163-b8aea03ff134",
                    "quizId": "5a950d59-c8b4-4f09-bd83-264c315e277b",
                    "question": "2. Have you tried any of the following treatments before?",
                    "sortOrder": 2
                },
                "answerList": [
                    {
                        "id": "80f36422-f741-4b29-8cdf-f2aa65bf2e14",
                        "questionId": "e02ff16a-9bc1-417b-8163-b8aea03ff134",
                        "answer": "Viagra or Sildenafil",
                        "sortOrder": 1,
                        "behavior": "ask_question",
                        "restriction": "none",
                        "questionIdToAsk": "988d9b1d-58b2-4582-9dcc-cda297b2a4ce",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "b24d9ebb-c654-4556-ac68-2591a39822de",
                        "questionId": "e02ff16a-9bc1-417b-8163-b8aea03ff134",
                        "answer": "Cialis or Tadalafil",
                        "sortOrder": 2,
                        "behavior": "ask_question",
                        "restriction": "none",
                        "questionIdToAsk": "03f61127-65f7-4f12-89d2-6e9ee3b182ad",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "9dbba999-faa6-45ae-b61d-2db264c674d6",
                        "questionId": "e02ff16a-9bc1-417b-8163-b8aea03ff134",
                        "answer": "Both",
                        "sortOrder": 3,
                        "behavior": "ask_question",
                        "restriction": "none",
                        "questionIdToAsk": "81bd885a-b0ed-4719-8375-38b56d63982a",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "8e33053a-5bc1-42e6-adda-232d11078f5a",
                        "questionId": "e02ff16a-9bc1-417b-8163-b8aea03ff134",
                        "answer": "None of the above",
                        "sortOrder": 4,
                        "behavior": "recommend_products",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": [
                            "57a5a136-2e70-11ef-bbee-aad777547dee"
                        ]
                    }
                ]
            },
            {
                "question": {
                    "id": "988d9b1d-58b2-4582-9dcc-cda297b2a4ce",
                    "quizId": "5a950d59-c8b4-4f09-bd83-264c315e277b",
                    "question": "2a. Was the Viagra or Sildenafil product you tried before effective?",
                    "sortOrder": 3
                },
                "answerList": [
                    {
                        "id": "dbfcbffb-35d5-4138-a129-94a00cab58ac",
                        "questionId": "988d9b1d-58b2-4582-9dcc-cda297b2a4ce",
                        "answer": "Yes",
                        "sortOrder": 1,
                        "behavior": "recommend_products",
                        "restriction": "exclude_products",
                        "questionIdToAsk": "",
                        "excludedProductIds": [
                            "57a5c3e6-2e70-11ef-bbee-aad777547dee"
                        ],
                        "recommendedProductIds": [
                            "57a5a136-2e70-11ef-bbee-aad777547dee"
                        ]
                    },
                    {
                        "id": "51a9fae0-73e0-4a3f-8681-7680e26132ca",
                        "questionId": "988d9b1d-58b2-4582-9dcc-cda297b2a4ce",
                        "answer": "No",
                        "sortOrder": 2,
                        "behavior": "recommend_products",
                        "restriction": "exclude_products",
                        "questionIdToAsk": "",
                        "excludedProductIds": [
                            "57a5c3e6-2e70-11ef-bbee-aad777547dee"
                        ],
                        "recommendedProductIds": [
                            "57a5b20c-2e70-11ef-bbee-aad777547dee"
                        ]
                    }
                ]
            },
            {
                "question": {
                    "id": "03f61127-65f7-4f12-89d2-6e9ee3b182ad",
                    "quizId": "5a950d59-c8b4-4f09-bd83-264c315e277b",
                    "question": "2b. Was the Cialis or Tadalafil product you tried before effective?",
                    "sortOrder": 4
                },
                "answerList": [
                    {
                        "id": "7b8b63c3-af2d-4823-8f62-34cd4271ce6b",
                        "questionId": "03f61127-65f7-4f12-89d2-6e9ee3b182ad",
                        "answer": "No",
                        "sortOrder": 2,
                        "behavior": "recommend_products",
                        "restriction": "exclude_products",
                        "questionIdToAsk": "",
                        "excludedProductIds": [
                            "57a5c3e6-2e70-11ef-bbee-aad777547dee"
                        ],
                        "recommendedProductIds": [
                            "57a5b20c-2e70-11ef-bbee-aad777547dee"
                        ]
                    },
                    {
                        "id": "9948e38b-cfbc-4990-a8ed-d25c56c41e7e",
                        "questionId": "03f61127-65f7-4f12-89d2-6e9ee3b182ad",
                        "answer": "Yes",
                        "sortOrder": 2,
                        "behavior": "recommend_products",
                        "restriction": "exclude_products",
                        "questionIdToAsk": "",
                        "excludedProductIds": [
                            "57a5a136-2e70-11ef-bbee-aad777547dee"
                        ],
                        "recommendedProductIds": [
                            "57a5c3e6-2e70-11ef-bbee-aad777547dee"
                        ]
                    }
                ]
            },
            {
                "question": {
                    "id": "81bd885a-b0ed-4719-8375-38b56d63982a",
                    "quizId": "5a950d59-c8b4-4f09-bd83-264c315e277b",
                    "question": "2c. Which is your preferred treatment?",
                    "sortOrder": 5
                },
                "answerList": [
                    {
                        "id": "fe78b99f-beef-4568-bede-b6ced857ed91",
                        "questionId": "81bd885a-b0ed-4719-8375-38b56d63982a",
                        "answer": "Viagra or Sildenafil",
                        "sortOrder": 1,
                        "behavior": "recommend_products",
                        "restriction": "exclude_products",
                        "questionIdToAsk": "",
                        "excludedProductIds": [
                            "57a5c3e6-2e70-11ef-bbee-aad777547dee"
                        ],
                        "recommendedProductIds": [
                            "57a5b20c-2e70-11ef-bbee-aad777547dee"
                        ]
                    },
                    {
                        "id": "1d37e604-aa8d-4f1f-81fc-030e47465d0d",
                        "questionId": "81bd885a-b0ed-4719-8375-38b56d63982a",
                        "answer": "Cialis or Tadalafil",
                        "sortOrder": 2,
                        "behavior": "recommend_products",
                        "restriction": "exclude_products",
                        "questionIdToAsk": "",
                        "excludedProductIds": [
                            "57a5a136-2e70-11ef-bbee-aad777547dee"
                        ],
                        "recommendedProductIds": [
                            "57a5d7e6-2e70-11ef-bbee-aad777547dee"
                        ]
                    },
                    {
                        "id": "345887d5-b46a-47e4-9e6e-d71db39af4ce",
                        "questionId": "81bd885a-b0ed-4719-8375-38b56d63982a",
                        "answer": "None of the above",
                        "sortOrder": 3,
                        "behavior": "recommend_products",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": [
                            "57a5b20c-2e70-11ef-bbee-aad777547dee"
                        ]
                    }
                ]
            },
            {
                "question": {
                    "id": "fb1f5cc7-e8f3-4ed5-aa01-7ef73430689d",
                    "quizId": "5a950d59-c8b4-4f09-bd83-264c315e277b",
                    "question": "3. Do you have, or have you ever had, any heart or neurological conditions?",
                    "sortOrder": 6
                },
                "answerList": [
                    {
                        "id": "afadf23b-9cc8-461d-af15-6c32aac89a89",
                        "questionId": "fb1f5cc7-e8f3-4ed5-aa01-7ef73430689d",
                        "answer": "Yes",
                        "sortOrder": 1,
                        "behavior": "none",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "7f7fbd88-2b1a-434c-aea0-a76d474e5f64",
                        "questionId": "fb1f5cc7-e8f3-4ed5-aa01-7ef73430689d",
                        "answer": "No",
                        "sortOrder": 2,
                        "behavior": "exclude_all_products",
                        "restriction": "exclude_all_products",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    }
                ]
            },
            {
                "question": {
                    "id": "56bc7da4-0718-4be4-9225-8e9440b6ddab",
                    "quizId": "5a950d59-c8b4-4f09-bd83-264c315e277b",
                    "question": "4. Do any of the listed medical conditions apply to you?",
                    "sortOrder": 7
                },
                "answerList": [
                    {
                        "id": "a390b83f-385f-450a-9d4f-a6b44c968cf9",
                        "questionId": "56bc7da4-0718-4be4-9225-8e9440b6ddab",
                        "answer": "Significant liver problems (such as cirrhosis of the liver) or kidney problems",
                        "sortOrder": 1,
                        "behavior": "exclude_all_products",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "fb5ce5d1-b613-47ae-8d98-2e89a4d325b0",
                        "questionId": "56bc7da4-0718-4be4-9225-8e9440b6ddab",
                        "answer": "Currently prescribed GTN, Isosorbide mononitrate, Isosorbide dinitrate , Nicorandil (nitrates) or Rectogesic ointment",
                        "sortOrder": 2,
                        "behavior": "exclude_all_products",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "02ebea7a-31fa-417f-b633-ea8bc5b95e58",
                        "questionId": "56bc7da4-0718-4be4-9225-8e9440b6ddab",
                        "answer": "Abnormal blood pressure (lower than 90/50 mmHg or higher than 160/90 mmHg)",
                        "sortOrder": 3,
                        "behavior": "exclude_all_products",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "1cb5c83f-aa77-4916-933c-d8f4a0e9a147",
                        "questionId": "56bc7da4-0718-4be4-9225-8e9440b6ddab",
                        "answer": "Condition affecting your penis (such as Peyronie's Disease, previous injuries or an inability to retract your foreskin)",
                        "sortOrder": 4,
                        "behavior": "exclude_all_products",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "7aebcc3a-7dc6-4915-9317-8de96ac55aba",
                        "questionId": "56bc7da4-0718-4be4-9225-8e9440b6ddab",
                        "answer": "I don't have any of these conditions",
                        "sortOrder": 5,
                        "behavior": "none",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    }
                ]
            },
            {
                "question": {
                    "id": "d92ca5ef-24f2-48e3-9461-f1e8de6771cf",
                    "quizId": "5a950d59-c8b4-4f09-bd83-264c315e277b",
                    "question": "5. Are you taking any of the following drugs?",
                    "sortOrder": 8
                },
                "answerList": [
                    {
                        "id": "2014b236-7995-4a46-aa48-13ce346666a9",
                        "questionId": "d92ca5ef-24f2-48e3-9461-f1e8de6771cf",
                        "answer": "Alpha-blocker medication such as Alfuzosin, Doxazosin, Tamsulosin, Prazosin, Terazosin or over-the-counter Flomax",
                        "sortOrder": 1,
                        "behavior": "exclude_all_products",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "01d145fd-c4ef-48a7-905a-a48789dd7ef5",
                        "questionId": "d92ca5ef-24f2-48e3-9461-f1e8de6771cf",
                        "answer": "Riociguat or other guanylate cyclase stimulators (for lung problems)",
                        "sortOrder": 2,
                        "behavior": "exclude_all_products",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "08dcb17c-f9eb-4f9e-9e78-5ee554f0ffcf",
                        "questionId": "d92ca5ef-24f2-48e3-9461-f1e8de6771cf",
                        "answer": "Saquinavir, Ritonavir or Indinavir (for HIV)",
                        "sortOrder": 3,
                        "behavior": "exclude_all_products",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "46c7294a-6e34-4ccc-904f-49fda3ab7cfe",
                        "questionId": "d92ca5ef-24f2-48e3-9461-f1e8de6771cf",
                        "answer": "I don't take any of these drugs",
                        "sortOrder": 4,
                        "behavior": "none",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    },
                    {
                        "id": "1d1e9675-368b-442b-9559-c7a8251bc0cd",
                        "questionId": "d92ca5ef-24f2-48e3-9461-f1e8de6771cf",
                        "answer": "Cimetidine (for heartburn)",
                        "sortOrder": 4,
                        "behavior": "exclude_all_products",
                        "restriction": "none",
                        "questionIdToAsk": "",
                        "excludedProductIds": [],
                        "recommendedProductIds": []
                    }
                ]
            }
        ]
    }
}
```

### Product suggestion by answer ids

```curl
curl --location 'http://quiz.rooter.test/api/rest/v1/product-suggestions/by-answer-ids' \
--header 'Content-Type: application/json' \
--data '{
    "idList": [
        "f5d025c5-a2d6-4818-81b8-32e91d6179e3",
        "8e33053a-5bc1-42e6-adda-232d11078f5a",
        "7b8b63c3-af2d-4823-8f62-34cd4271ce6b"
    ]
}'
```

### Product suggestion by answer list

```curl
curl --location 'http://quiz.rooter.test/api/rest/v1/product-suggestions/by-answer-list' \
--header 'Content-Type: application/json' \
--data '{
    "answerList": [
        {
            "id": "e463b3e1-0ee5-4102-97d2-4421ad0a3328",
            "questionId": "e463b3e1-0ee5-4102-97d2-4421ad0a3328",
            "answer": "test",
            "behavior": "none",
            "restriction": "none",
            "sortOrder": 10
        }
    ]
}'
```

Response of the products suggestion:

```json
{
    "productList": {
        "57a5a136-2e70-11ef-bbee-aad777547dee": {
            "id": "57a5a136-2e70-11ef-bbee-aad777547dee",
            "name": "Sildenafil 50mg"
        },
        "57a5b20c-2e70-11ef-bbee-aad777547dee": {
            "id": "57a5b20c-2e70-11ef-bbee-aad777547dee",
            "name": "Sildenafil 100mg"
        }
    }
}
```


