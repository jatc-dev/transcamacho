<?php
declare(strict_types=1);

namespace App\Models;

use App\Model;

class Conductor extends Model
{
    protected string $table = 'conductores';
    protected string $primaryKey = 'idcond';

    public function findByNombre(string $nombre, int $limit = 5): array
    {
        $stmt = $this->db()->prepare(
            "SELECT * FROM {$this->table} WHERE nombcond ILIKE ? LIMIT ?"
        );
        $stmt->execute(['%' . $nombre . '%', $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
