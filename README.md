# Prueba Técnica - Simple CRUD de Clientes (API)

Este repositorio contiene una API simple para realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) en la entidad de clientes utilizando el framework Yii2.

## Instrucciones para Configuración

### Clonar el Repositorio

```bash
git clone https://github.com/samuelengineerdev/caona_test_client.git
```
### Instalar dependencias

```bash
composer install
```

### Iniciar el proyecto

```bash
php yii serve --docroot=backend/web
```

## Instrucciones para Configuración

### Listar Clientes

```bash
GET http://localhost:8080/api/client
```

### Crear Cliente

```bash
POST http://localhost:8080/api/client

{
  "first_name": "Nombre",
  "last_name": "Apellido",
  "email": "correo@example.com",
  "phone": "1234567890",
  "profile": {
    "civil_status": "Estado Civil",
    "occupation": "Ocupación",
    "membership_level": "Nivel de Membresía"
  },
  "address": {
    "street": "Nombre de la Calle",
    "city": "Ciudad",
    "state": "Estado",
    "postal_code": "Código Postal"
  }
}

```

### Actualizar Cliente

```bash
PUT http://localhost:8080/api/client

{
  "id": 1,
  "first_name": "Nuevo Nombre",
  "last_name": "Nuevo Apellido",
  "email": "nuevo_correo@example.com",
  "phone": "9876543210",
  "profile": {
    "civil_status": "Nuevo Estado Civil",
    "occupation": "Nueva Ocupación",
    "membership_level": "Nuevo Nivel de Membresía"
  },
  "address": {
    "street": "Nueva Calle",
    "city": "Nueva Ciudad",
    "state": "Nuevo Estado",
    "postal_code": "Nuevo Código Postal"
  }
}

```

### Eliminar Cliente

```bash
POST http://localhost:8080/api/client/delete

{
  "id": 1
}

```
