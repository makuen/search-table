<?php

\Route::get("search-table", "Makuen\\Searchtable\\Controllers\\SearchtableController@index");
\Route::post("search-table", "Makuen\\Searchtable\\Controllers\\SearchtableController@search");
