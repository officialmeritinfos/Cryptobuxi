<?php
namespace App\Custom;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait GenerateUnique
{
    public function uniqueRef(){
        $id = (string )Str::uuid();
        $id = explode('-',$id);
        $id = $id[3];
        return Str::padLeft($id,'10','0');
    }

    public function createUniqueRef($table,$column){
        $id = $this->uniqueRef();
        return DB::table($table)->where($column,$id)->first() ? $this->createUniqueRef($table,$column):$id;
    }
}
