# TPEspecial-2

## Auth Token:

GET - With an specific useremail and password, you will reach a token that allows to CREATE, MODIFY and DELETE items from different entities:

    http://localhost/Web2/TPE-2/api/auth/token

## Api-Drink:

GET - You can get all registers from the Entity "Drink":
    http://localhost/Web2/TPE-2/api/drinks

GET ID - You cand get the register from the Entity "Drink" with an specific id:
    http://localhost/Web2/TPE-2/api/drink/:id

POST - You can create a new register from the Entity "Drink"; token is required:
    http://localhost/Web2/TPE-2/api/drink

PUT - You can modify a register from the Entity "Drink" with an specific id; token is required:
    http://localhost/Web2/TPE-2/api/drink/:id

DELETE - You can delete a register from the Entity "Drink" with an specific id; token is required:
    http://localhost/Web2/TPE-2/api/drink/:id

## Api-Alcohol-Content:

GET - You can get all registers from the Entity "Alcohol-Content":
    http://localhost/Web2/TPE-2/api/alcohol-contents

GET ID - You cand get the register from the Entity "Alcohol-Content" with an specific id:
    http://localhost/Web2/TPE-2/api/alcohol-contents/:id

POST - You can create a new register from the Entity "Alcohol-Content"; token is required:
    http://localhost/Web2/TPE-2/api/alcohol-contents

PUT - You can modify a register from the Entity "Alcohol-Content" with an specific id; token is required:
    http://localhost/Web2/TPE-2/api/alcohol-contents/:id

DELETE - You can delete a register from the Entity "Alcohol-Content" with an specific id; token is required:
    http://localhost/Web2/TPE-2/api/alcohol-contents/:id

## Api-Category:

GET - You can get all registers from the Entity "Categories":
    http://localhost/Web2/TPE-2/api/categories

GET ID - You cand get the register from the Entity "Categories" with an specific id:
    http://localhost/Web2/TPE-2/api/categories/:id

POST - You can create a new register from the Entity "Categories"; token is required:
    http://localhost/Web2/TPE-2/api/categories

PUT - You can modify a register from the Entity "Categories" with an specific id; token is required:
    http://localhost/Web2/TPE-2/api/categories/:id

DELETE - You can delete a register from the Entity "Categories" with an specific id; token is required:
    http://localhost/Web2/TPE-2/api/categories/:id