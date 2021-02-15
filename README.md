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
...
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'establishment_id',
    ];
...
```