<?php
declare(strict_types=1);

namespace App\Models;

use App\Model;

class Vehiculo extends Model
{
    protected string $table = 'vehiculos';
    protected string $primaryKey = 'idvehi';

    public function findByPlaca(string $placa, int $limit = 5): array
    {
        $stmt = $this->db()->prepare(
            "SELECT * FROM {$this->table} WHERE placa ILIKE ? LIMIT ?"
        );
        $stmt->execute(['%' . $placa . '%', $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
