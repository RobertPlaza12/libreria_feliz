
<?php

class Titulo
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = "SELECT
                    t.*,
                    COUNT(tt.id_tienda) AS total_tiendas
                FROM titulos t
                LEFT JOIN tienda_titulo tt
                    ON t.id_titulo = tt.id_titulo
                GROUP BY t.id_titulo
                ORDER BY t.id_titulo DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $sql = "SELECT *
                FROM titulos
                WHERE id_titulo = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function create($datos)
    {
        $sql = "INSERT INTO titulos
                    (titulo, autor, isbn, editorial,
                     anio_publicacion, precio, descripcion)
                VALUES
                    (:titulo, :autor, :isbn, :editorial,
                     :anio_publicacion, :precio, :descripcion)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':titulo', trim($datos['titulo']));
        $stmt->bindValue(':autor', trim($datos['autor']));
        $stmt->bindValue(':isbn', $datos['isbn'] ?: null);
        $stmt->bindValue(':editorial', $datos['editorial'] ?: null);
        $stmt->bindValue(
            ':anio_publicacion',
            $datos['anio_publicacion'] ?: null
        );
        $stmt->bindValue(':precio', $datos['precio']);
        $stmt->bindValue(':descripcion', $datos['descripcion'] ?? '');

        return $stmt->execute();
    }

    public function update($id, $datos)
    {
        $sql = "UPDATE titulos SET
                    titulo = :titulo,
                    autor = :autor,
                    isbn = :isbn,
                    editorial = :editorial,
                    anio_publicacion = :anio_publicacion,
                    precio = :precio,
                    descripcion = :descripcion
                WHERE id_titulo = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':titulo', trim($datos['titulo']));
        $stmt->bindValue(':autor', trim($datos['autor']));
        $stmt->bindValue(':isbn', $datos['isbn'] ?: null);
        $stmt->bindValue(':editorial', $datos['editorial'] ?: null);
        $stmt->bindValue(
            ':anio_publicacion',
            $datos['anio_publicacion'] ?: null
        );
        $stmt->bindValue(':precio', $datos['precio']);
        $stmt->bindValue(':descripcion', $datos['descripcion'] ?? '');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM titulos
                WHERE id_titulo = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
