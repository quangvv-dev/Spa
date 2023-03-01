<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChamCongController extends Controller
{
    public function store(Request $request){
        $data = "{\"NameMachine\":\"HN1\",\"Info\":[{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/6\/2023 1:58:07 PM\",\"IndRedID\":\"1\"},{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/6\/2023 2:10:11 PM\",\"IndRedID\":\"1\"},{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/6\/2023 2:10:19 PM\",\"IndRedID\":\"1\"},{\"MachineNumber\":\"1\",\"DateTimeRecord\":\"2\/7\/2023 8:54:42 AM\",\"IndRedID\":\"1\"}]}";
        $data = json_decode($data);
        $value['name_machine'] = $data->NameMachine;
        if(count($data->Info)){
//            foreach ($data->Info)
        }
    }
}
