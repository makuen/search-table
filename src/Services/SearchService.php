<?php

namespace Makuen\Searchtable\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchService
{
    public const All = 0;
    public const TableName = 1;
    public const ColumnName = 2;
    public const Comments = 3;

    public static function get(int $range = 0, string $content = ""): array
    {
        $res = [];
        $tables = DB::select("show tables");

        foreach ($tables as $row_table) {
            $table_name = current($row_table);

            $columns = DB::select("show full columns from {$table_name}");

            $columns = array_map(function ($row_column) {
                return (array)$row_column;
            }, $columns);

            if ($range === self::TableName && $content) { //搜表名
                if (!Str::contains($table_name, $content)) {
                    continue;
                }
            }

            if ($range == self::ColumnName && $content) { //搜列名
                $column_names = array_column($columns, "Field");
                $found_columns = array_filter($column_names, function ($column_name) use ($content) {
                    return Str::contains($column_name, $content);
                });

                if (!count($found_columns)) {
                    continue;
                }
            }

            if ($range == self::Comments && $content) { //搜说明
                $column_comments = array_column($columns, "Comment");
                $found_columns = array_filter($column_comments, function ($column_comment) use ($content) {
                    return Str::contains($column_comment, $content);
                });

                if (!count($found_columns)) {
                    continue;
                }
            }

            if ($range == self::All && $content) { //全部
                $column_names = array_column($columns, "Field");
                $column_comments = array_column($columns, "Comment");
                $found_names = array_filter($column_names, function ($column_name) use ($content) {
                    return Str::contains($column_name, $content);
                });
                $found_comments = array_filter($column_comments, function ($column_comment) use ($content) {
                    return Str::contains($column_comment, $content);
                });
                $found_table = Str::contains($table_name, $content);

                if (!count($found_names) && !count($found_comments) && !$found_table) {
                    continue;
                }
            }

            $tmp = [];
            $tmp["name"] = $table_name;
            $tmp["columns"] = $columns;

            array_push($res, $tmp);
        }

        return $res;
    }
}
