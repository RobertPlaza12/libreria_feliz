
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

    public function delete($id)
    {
        $sql = "DELETE FROM tiendas
                WHERE id_tienda = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
