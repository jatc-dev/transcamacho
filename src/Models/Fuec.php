<?php
declare(strict_types=1);

namespace App\Models;

use App\Model;

class Fuec extends Model
{
    protected string $table = 'fuec';
    protected string $primaryKey = 'numfuec';

    public function findByNumFuec(string $numfuec): ?array
    {
        $stmt = $this->db()->prepare(
            "SELECT * FROM {$this->table} WHERE numfuec = ? LIMIT 1"
        );
        $stmt->execute([$numfuec]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }

    public function listByContratante(string $contratante, int $limit = 50): array
    {
        $stmt = $this->db()->prepare(
            "SELECT * FROM {$this->table} WHERE contratante ILIKE ? ORDER BY numfuec DESC LIMIT ?"
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
