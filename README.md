# Web 2 TPE - API REST Biblioteca Digital

### Integrantes

* Milagros Montero Larricq (mail: [milagrosmontero2005@gmail.com](mailto:milagrosmontero2005@gmail.com))

---

# API REST - Biblioteca Digital

## Descripción

Este proyecto corresponde a la tercera parte del Trabajo Práctico Especial de Web II.

Se desarrolló una **API REST** utilizando PHP con arquitectura **Modelo - Vista - Controlador (MVC)** para gestionar una biblioteca digital.

La API permite consultar y administrar libros almacenados en una base de datos MySQL, devolviendo todas las respuestas en formato JSON.

Además, incorpora autenticación mediante **JSON Web Token (JWT)** para proteger los endpoints que modifican información.

---

# Tecnologías utilizadas

* PHP
* MySQL
* PDO
* Apache (XAMPP)
* Arquitectura MVC
* JWT (JSON Web Token)

---

# Base de datos

La API utiliza la misma base de datos desarrollada en la segunda parte del trabajo práctico.

## Tablas principales

### Autores

Contiene la información de cada autor registrado.

Atributos:

* `id_autor`
* `nombre`
* `apellido`
* `nacionalidad`

### Libros

Contiene la información de los libros disponibles.

Atributos:

* `id_libro`
* `titulo`
* `genero`
* `anio_publicacion`
* `editorial`
* `id_autor`

La relación entre ambas tablas es **1:N**, donde un autor puede tener varios libros y cada libro pertenece a un único autor.

---

# Configuración

## Requisitos

* Apache
* PHP
* MySQL
* XAMPP (o similar)

## Instalación

1. Clonar el repositorio dentro de `htdocs`.

2. Crear la base de datos:

```
bibloteca
```

3. Importar el archivo `.sql` incluido en el proyecto.

4. Iniciar Apache y MySQL.

---

# URL Base

```
http://localhost/web-2-tpe-bibloteca-API/api
```

---

# Autenticación

Los siguientes métodos requieren autenticación mediante JWT:

* POST
* PUT
* DELETE

## Obtener Token

### Endpoint

```
POST /auth/token
```

### Body

```json
{
    "email":"webadmin",
    "password":"admin"
}
```

### Respuesta

```json
"eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."
```

Una vez obtenido el token, debe enviarse en el Header:

```
Authorization: Bearer TOKEN
```

---

# Endpoints disponibles

| Método | Endpoint    | Descripción              |
| ------ | ----------- | ------------------------ |
| GET    | /libros     | Obtiene todos los libros |
| GET    | /libros/:id | Obtiene un libro por ID  |
| POST   | /libros     | Agrega un libro          |
| PUT    | /libros/:id | Modifica un libro        |
| DELETE | /libros/:id | Elimina un libro         |
| POST   | /auth/token | Obtiene un token JWT     |

---

# Obtener todos los libros

```
GET /libros
```

Respuesta

```
200 OK
```

---

# Obtener un libro por ID

```
GET /libros/{id}
```

Ejemplo

```
GET /libros/15
```

Respuesta

```
200 OK
```

o

```
404 Not Found
```

---

# Agregar un libro

```
POST /libros
```

Header

```
Authorization: Bearer TOKEN
```

Body

```json
{
    "titulo":"Nuevo Libro",
    "genero":"Novela",
    "anio_publicacion":2024,
    "editorial":"Planeta",
    "id_autor":8
}
```

Respuesta

```
201 Created
```

---

# Modificar un libro

```
PUT /libros/{id}
```

Header

```
Authorization: Bearer TOKEN
```

Body

```json
{
    "titulo":"Nuevo título",
    "genero":"Acción",
    "anio_publicacion":2024,
    "editorial":"Planeta",
    "id_autor":8
}
```

Respuesta

```
200 OK
```

---

# Eliminar un libro

```
DELETE /libros/{id}
```

Header

```
Authorization: Bearer TOKEN
```

Respuesta

```
200 OK
```

---

# Filtrado

La colección de libros puede filtrarse por género.

Ejemplo:

```
GET /libros?genero=Novela
```

---

# Ordenamiento

Los resultados pueden ordenarse por cualquiera de los siguientes campos:

* id_libro
* titulo
* genero
* anio_publicacion
* editorial
* id_autor

Orden ascendente

```
GET /libros?sort=titulo
```

Orden descendente

```
GET /libros?sort=titulo&order=DESC
```

Otro ejemplo

```
GET /libros?sort=anio_publicacion
```

---

# Códigos de respuesta

| Código | Descripción                       |
| ------ | --------------------------------- |
| 200    | Solicitud realizada correctamente |
| 201    | Recurso creado correctamente      |
| 400    | Datos inválidos o incompletos     |
| 401    | No autorizado o token inválido    |
| 404    | Recurso no encontrado             |

---

# Observaciones

* Todas las respuestas se devuelven en formato JSON.
* Los endpoints POST, PUT y DELETE requieren un token JWT válido.
* El ordenamiento admite cualquier campo de la tabla `libros`.
* El filtrado se realiza mediante el campo `genero`.
