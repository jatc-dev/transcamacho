<?php
declare(strict_types=1);

namespace App\Models;

use App\Model;

class Usuario extends Model
{
    protected string $table = 'usuarios';
    protected string $primaryKey = 'id';

    public function findByUsuarioOrEmail(string $identifier): ?array
    {
        $stmt = $this->db()->prepare(
            "SELECT * FROM {$this->table} WHERE usuario = ? OR correo = ? LIMIT 1"
        );
        $stmt->execute([$identifier, $identifier]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }

    public function existeUsuario(string $usuario): bool
    {
        $stmt = $this->db()->prepare(
            "SELECT 1 FROM {$this->table} WHERE usuario = ? LIMIT 1"
        );
        $stmt->execute([$usuario]);
        return $stmt->fetchColumn() !== false;
    }

    public function existeEmail(string $email): bool
    {
        $stmt = $this->db()->prepare(
            "SELECT 1 FROM {$this->table} WHERE correo = ? LIMIT 1"
        );
        $stmt->execute([$email]);
        return $stmt->fetchColumn() !== false;
    }

    public function activar(int $id): bool
    {
        return $this->update($id, ['activacion' => 1]);
    }

    public function actualizarUltimaSesion(int $id): void
    {
        $this->db()->prepare(
            "UPDATE {$this->table} SET last_session = NOW(), token_password = '', password_request = 0 WHERE id = ?"
        )->execute([$id]);
    }
}
