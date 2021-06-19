<?php

namespace Makuen\Searchtable\Commands;

use Illuminate\Console\Command;
use Makuen\Searchtable\Services\SearchService;

class SearchTable extends Command
{
    protected $signature = "search:table {--only-table} {--only-column} {--only-comment}";

    protected $description = "查找数据库表";

    public function handle()
    {
        $range = SearchService::All;
        if ($this->option("only-table")) {
            $range = SearchService::TableName;
        } else if ($this->option("only-column")) {
            $range = SearchService::ColumnName;
        } else if ($this->option("only-comment")) {
            $range = SearchService::Comments;
        }

        $content = $this->ask("输入查找内容");

        $data = SearchService::get($range, $content);

        $this->hLine();

        foreach ($data as $table) {
            echo "表名:{$table['name']}";
            $this->hLine();

            echo "字段";
            $this->vLine();
            echo "类型";
            $this->vLine();
            echo "Null";
            $this->vLine();
            echo "Default";
            $this->vLine();
            echo "说明";
            $this->hLine();

            foreach ($table["columns"] as $column) {
                echo $column["Field"];
                $this->vLine();
                echo $column["Type"];
                $this->vLine();
                echo $column["Null"];
                $this->vLine();
                echo $column["Default"];
                $this->vLine();
                echo $column["Comment"];
                $this->hLine();
            }

            $this->br();
            $this->br();
            $this->br();
        }

    }

    private function hLine()
    {
        $this->br();
        echo "------------------------------------------------------";
        $this->br();
    }

    private function vLine()
    {
        echo "    |    ";
    }

    private function br()
    {
        echo "\r\n";
    }
}
