# Genesys Invoice
## Post Install
Posteriormente ejecutar
``` bash
php artisan migrate
```
## Crear usuario
``` bash
php artisan user:create
```
## Agregar al modelo Models\User.php
```
... php
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'establishment_id',
    ];
...
```
### Configuración importante para funcionalidad de graphql

<a href="https://lighthouse-php.com/5.2/eloquent/complex-where-conditions.html#setup">
https://lighthouse-php.com/5.2/eloquent/complex-where-conditions.html#setup
</a>

## Importar Graphql

``` bash
php artisan vendor:publish --tag=genesys-fact-schema
```

### Agregar modelos de la libreria
En lighthouse.php

``` php
...
    
    'namespaces' => [
        'models' => ['App',
            'App\\Models',
            'GenesysLite\\GenesysBusiness\\Models',
            'GenesysLite\\GenesysCrm\\Models',
            'GenesysLite\\GenesysCatalog\\Models',
            'GenesysLite\\GenesysFact\\Models',
            'GenesysLite\\GenesysInventory\\Models',
            'GenesysLite\\GenesysUbigee\\Models'],
        'queries' => 'App\\GraphQL\\Queries',
        'mutations' => 'App\\GraphQL\\Mutations',
        'subscriptions' => 'App\\GraphQL\\Subscriptions',
        'interfaces' => 'App\\GraphQL\\Interfaces',
        'unions' => 'App\\GraphQL\\Unions',
        'scalars' => 'App\\GraphQL\\Scalars',
        'directives' => ['App\\GraphQL\\Directives'],
        'validators' => ['App\\GraphQL\\Validators'],
    ],
```
### Importar graphql
``` 
#import  ./GenesysBusiness/*.graphql
#import  ./GenesysCatalog/*.graphql
#import  ./GenesysCrm/*.graphql
#import  ./GenesysFact/*.graphql
#import  ./GenesysInventory/*.graphql
#import  ./GenesysUbigee/*.graphql
```

### Para guardar archivos agregar lo siguiente

``` 

"Can be used as an argument to upload files using https://github.com/jaydenseric/graphql-multipart-request-spec"
scalar Upload @scalar(class: "Nuwave\\Lighthouse\\Schema\\Types\\Scalars\\Upload")
```