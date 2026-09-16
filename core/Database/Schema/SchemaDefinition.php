<?php

declare(strict_types=1);

namespace Core\Database\Schema;

/**
 * Declarative table description (Prisma-inspired). Lives in database/schema/.
 */
abstract class SchemaDefinition
{
    protected string $table = '';

    abstract public function define(Blueprint $table): void;

    public function tableName(): string
    {
        return $this->table;
    }

    public function blueprint(): Blueprint
    {
        $blueprint = new Blueprint($this->table);
        $this->define($blueprint);

        return $blueprint;
    }

    /** @return array<int, array{column: string, type: string, nullable: bool}> */
    public function describe(): array
    {
        $out = [];
        foreach ($this->blueprint()->columns() as $column) {
            $out[] = ['column' => $column->name, 'type' => $column->type, 'nullable' => $column->isNullable];
        }

        return $out;
    }
}
