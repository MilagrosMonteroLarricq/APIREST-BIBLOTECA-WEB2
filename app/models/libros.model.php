<?php
class LibrosModel {
    private $db;

    public function __construct(){
        //conexion con la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=bibloteca;charset=utf8', 'root','');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //trae todos los libros
    public function getAll($sort = null, $order = "ASC"){
        if($sort){
            $query= $this->db->prepare("SELECT * FROM libros ORDER BY $sort $order");
        } else{
            $query= $this->db->prepare("SELECT * FROM libros");
        }
        
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getByGenero($genero){
        $query = $this->db->prepare("SELECT * FROM libros WHERE genero = ?");
        $query->execute([$genero]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    //trae un libro por id
    public function getById($id){
        $query= $this->db->prepare('SELECT * FROM libros WHERE id_libro = ?');
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    //funcion insert
    public function insert ($titulo,$genero,$anio_publicacion,$editorial,$id_autor){
        $query= $this->db->prepare('INSERT INTO libros(titulo, genero, anio_publicacion, editorial, id_autor) VALUES (?,?,?,?,?)');
        $query->execute([$titulo,$genero,$anio_publicacion,$editorial,$id_autor]);

        return $this->db->lastInsertId();
    }

    //funcion update
    public function update ($id,$titulo,$genero,$anio_publicacion,$editorial,$id_autor){
        $query = $this->db->prepare('UPDATE libros SET titulo = ?, genero = ?, anio_publicacion = ?, editorial = ?, id_autor = ? WHERE id_libro = ?');
        $query->execute([$titulo,$genero,$anio_publicacion,$editorial,$id_autor,$id]);
    }

    //funcion delete
    public function delete($id){
        $query = $this->db->prepare("DELETE FROM libros WHERE id_libro = ?");
        $query->execute([$id]);
    }
}