<?php
declare(strict_types=1);

namespace Makuen\Searchtable\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Makuen\Searchtable\Services\SearchService;

class SearchtableController extends Controller
{
    public function index()
    {
        $res = SearchService::get();

        return view("Searchtable::index", compact("res"));
    }

    public function search(): \Illuminate\Http\JsonResponse
    {
        $range = (int)request("range", SearchService::All);
        $content = request("content", "");

        $data = SearchService::get($range, $content);

        return response()->json(["data" => $data]);
    }
}
