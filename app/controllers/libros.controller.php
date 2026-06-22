<?php 
require_once __DIR__ . '/../models/libros.model.php';

class LibrosController{
    private $model;


    public function __construct(){
        $this->model = new LibrosModel();
    }

    // Endpoint GET /api/libros
    public function getLibros($req, $res){
        $genero = $req->query->genero ?? null;
        $sort = $req->query->sort ?? null;
        $order = strtoupper($req->query->order ?? "ASC");

        $camposPermitidos = [
            "id_libro",
            "titulo",
            "genero",
            "anio_publicacion",
            "editorial",
            "id_autor"
        ];

        if($sort && !in_array($sort, $camposPermitidos)){
            return $res->json("Campo de ordenamiento inválido", 400);
        }

        if ($order != "ASC" && $order != "DESC"){
            return $res->json("Tipo de orden inválido", 400);
        }
        
        if ($genero){
            $libros = $this->model->getByGenero($genero);
        } else {
            $libros = $this->model->getAll($sort, $order);
        }
        

        return $res->json($libros, 200);
    }

    //
    public function getLibroById($req, $res){
        
        $id_libro = $req->params->id;

        $libro = $this->model->getById($id_libro);
        if(!$libro){
            return $res->json("El libro con el id=$id_libro no existe", 404);
        }

        return $res->json($libro, 200);
    }

    //
    public function insertLibro($req, $res){
        $titulo = $req->body->titulo ?? null;
        $genero = $req->body->genero ?? null;
        $anio_publicacion = $req->body->anio_publicacion ?? null;
        $editorial = $req->body->editorial ?? null;
        $id_autor = $req->body->id_autor ?? null;

        if (empty ($titulo) || empty ($genero) || empty ($anio_publicacion) || empty ($editorial) || empty ($id_autor)){
            return $res->json("Faltan completar datos", 400);
        } 

        try {
            $id = $this->model->insert($titulo, $genero, $anio_publicacion, $editorial, $id_autor);
            $libro = $this->model->getById($id);
            return $res->json($libro, 201);
        } catch (PDOException $e) {
            return $res->json("El autor indicado no existe", 400);
        }
    }

    public function updateLibro($req, $res){
        $id_libro = $req->params->id;
        $libro = $this->model->getById($id_libro);

        if (!$libro){
            return $res->json("El libro con el id=$id_libro no existe", 404);
        }

        $titulo = $req->body->titulo ?? null;
        $genero = $req->body->genero ?? null;
        $anio_publicacion = $req->body->anio_publicacion ?? null;
        $editorial = $req->body->editorial ?? null;
        $id_autor = $req->body->id_autor ?? null;

        if ($titulo === null ||$genero === null || $anio_publicacion === null || $editorial === null || $id_autor === null){
            return $res->json("Faltan completar datos", 400);
        }

        try {
            $this->model->update($id_libro, $titulo, $genero, $anio_publicacion, $editorial, $id_autor);
            $libro = $this->model->getById($id_libro);
            return $res->json($libro, 200);

        } catch (PDOException $e) {
            return $res->json("El autor indicado no existe", 400);
        }
    }

    public function removeLibro($req, $res){
        $id_libro = $req->params->id;
        $libro = $this->model->getById($id_libro);

        if (!$libro){
            return $res->json("El libro con el id=$id_libro no existe", 404);
        }

        $this->model->delete($id_libro);
        
        return $res->json("El libro con el id=$id_libro fue eliminado", 200);
    }
}