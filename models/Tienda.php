
<?php

class Tienda
{
    private $db;
    private $id_tienda;
    private $nombre_tienda;
    private $direccion;
    private $telefono;
    private $correo;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM tiendas
                ORDER BY id_tienda DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM tiendas
                WHERE id_tienda = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function create($datos)
    {
        $sql = "INSERT INTO tiendas
                (nombre_tienda, direccion, telefono, correo)
                VALUES
                (:nombre_tienda, :direccion, :telefono, :correo)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(
            ':nombre_tienda',
            trim($datos['nombre_tienda'])
        );

        $stmt->bindValue(
            ':direccion',
            $datos['direccion'] ?? ''
        );

        $stmt->bindValue(
            ':telefono',
            $datos['telefono'] ?? ''
        );

        $stmt->bindValue(
            ':correo',
            $datos['correo'] ?? ''
        );

        return $stmt->execute();
    }

    public function update($id, $datos)
    {
        $sql = "UPDATE tiendas SET
                    nombre_tienda = :nombre_tienda,
                    direccion = :direccion,
                    telefono = :telefono,
                    correo = :correo
                WHERE id_tienda = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(
            ':nombre_tienda',
            trim($datos['nombre_tienda'])
        );

        $stmt->bindValue(
            ':direccion',
            $datos['direccion'] ?? ''
        );

        $stmt->bindValue(
            ':telefono',
            $datos['telefono'] ?? ''
        );

        $stmt->bindValue(
            ':correo',
            $datos['correo'] ?? ''
        );

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    // da los títulos asociados a una tienda
    public function getTitulos($id_tienda)
    {
        $sql = "SELECT
                    t.id_titulo,
                    t.titulo,
                    t.autor,
                    tt.cantidad
                FROM tienda_titulo tt
                INNER JOIN titulos t
                    ON t.id_titulo = tt.id_titulo
                WHERE tt.id_tienda = :id_tienda
                ORDER BY t.titulo ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_tienda', $id_tienda, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // para tener todos los títulos para el selector
    public function getTitulosDisponibles()
    {
        $sql = "SELECT id_titulo, titulo, autor
                FROM titulos
                ORDER BY titulo ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // agregar un título a una tienda o actualizar su cantidad
    public function guardarTitulo($id_tienda, $id_titulo, $cantidad)
    {
        $sql = "INSERT INTO tienda_titulo
                    (id_tienda, id_titulo, cantidad)
                VALUES
                    (:id_tienda, :id_titulo, :cantidad)
                ON DUPLICATE KEY UPDATE
                    cantidad = VALUES(cantidad)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id_tienda', $id_tienda, PDO::PARAM_INT);
        $stmt->bindValue(':id_titulo', $id_titulo, PDO::PARAM_INT);
        $stmt->bindValue(':cantidad', $cantidad, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // quitar un título del inventario de una tienda
    public function quitarTitulo($id_tienda, $id_titulo)
    {
        $sql = "DELETE FROM tienda_titulo
                WHERE id_tienda = :id_tienda
                  AND id_titulo = :id_titulo";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id_tienda', $id_tienda, PDO::PARAM_INT);
        $stmt->bindValue(':id_titulo', $id_titulo, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function delete($id)
    {
        $sql = "DELETE FROM tiendas
                WHERE id_tienda = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
