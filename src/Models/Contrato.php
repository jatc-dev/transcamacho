<?php
declare(strict_types=1);

namespace App\Models;

use App\Model;

class Contrato extends Model
{
    protected string $table = 'contratos';
    protected string $primaryKey = 'idcontrato';

    public function findByContratante(string $contratante, int $limit = 50): array
    {
        $stmt = $this->db()->prepare(
            "SELECT * FROM {$this->table} WHERE contratante ILIKE ? ORDER BY {$this->primaryKey} DESC LIMIT ?"
        );
        $stmt->execute(['%' . $contratante . '%', $limit]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function count(): int
    {
        $stmt = $this->db()->query("SELECT COUNT(*) FROM {$this->table}");
        return (int) $stmt->fetchColumn();
    }
}
