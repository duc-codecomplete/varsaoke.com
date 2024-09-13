<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Support\Facades\File;
use Log;

class HomeController extends Controller
{
    public function index()
    {
        $amount = request()->amount ?? 0;
        // $start = request()->start ?? null;
        // $end = request()->end ?? null;
        $key = request()->key ?? "";
        $order = request()->order ?? 0;
        $data = Transaction::query();
        if ($amount != 0) {
            switch ($amount) {
                case 1:
                    $data = $data->whereBetween('amount', [0, 100000]);
                    break;
                case 2:
                    $data = $data->whereBetween('amount', [100000, 500000]);
                    break;
                case 3:
                    $data = $data->whereBetween('amount', [500000, 1000000]);
                    break;
                case 4:
                    $data = $data->whereBetween('amount', [1000000, 5000000]);
                    break;
                case 5:
                    $data = $data->whereBetween('amount', [5000000, 10000000]);
                    break;
                case 6:
                    $data = $data->whereBetween('amount', [10000000, 50000000]);
                    break;
                case 7:
                    $data = $data->whereBetween('amount', [50000000, 100000000]);
                    break;
                case 8:
                    $data = $data->where('amount', ">", 100000000);
                    break;

                default:
                    # code...
                    break;
            }
        }
        if ($key) {
            $data = $data->where("content", 'like', '%' . $key . '%')->orWhere("mgd", 'like', '%' . $key . '%');
        }
        if ($order != 0) {
            if ($order == 1) {
                $data = $data->orderByDesc("amount");
            } else {
                $data = $data->orderBy("amount");
            }
        }
        $data = $data->paginate(100);
        return view("home", ["data" => $data]);
    }

    public function clone ()
    {
        $fileNames = [];
        $path = public_path('data');
        $files = \File::allFiles($path);

        foreach ($files as $file) {
            array_push($fileNames, pathinfo($file)['filename'] . ".json");
        }

        natsort($fileNames);
        $files = (collect($fileNames)->values());
        $index = 1;
        foreach ($files as $key) {
            Log::info("Start ..." . $index);
            $string = file_get_contents("data/" . $key);
            $json_file = json_decode($string, true);
            $trans = [];
            foreach ($json_file as $keyx) {
                array_push($trans, [
                    "date" => $keyx["data"],
                    "mgd" => $keyx["mgd"],
                    "amount" => $keyx["amount"],
                    "content" => $keyx["nd"],
                ]);
                //Log::info($keyx);
            }
            $index++;
            Transaction::insert($trans);
            Log::info("Done ..." . $index);
        }
        return 2;

    }
}
