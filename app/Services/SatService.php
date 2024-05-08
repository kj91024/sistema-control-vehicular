<?php
namespace App\Services;
use App\Entities\Sat;
use App\Models\Sats;

class SatService{
    protected Sats $satModel;
    public function __construct(){
        $this->satModel = model("Sats");
    }
    public function existPlate($plate): ?Sat{
        return $this->satModel->where('plate', $plate)->first();
    }
}