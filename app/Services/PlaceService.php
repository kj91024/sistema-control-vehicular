<?php
namespace App\Services;
use App\Entities\Place;
use App\Models\Places;

class PlaceService{
    protected Places $placeModel;
    public function __construct(){
        $this->placeModel = model('Places');
    }
    public function getPlaceById(int $id): ?Place{
        return $this->placeModel->find($id);
    }
    public function getPlaceByName(string $name): ?Place{
        return $this->placeModel->where('name', $name)->first();
    }
    public function createPlace(array $data): Place{
        $isUpdate = array_key_exists('id', $data);
        $place = $isUpdate
            ? $this->getPlaceById($data['id'])
            : new Place();

        $place->name = $data['name'];
        $place->address = $data['address'];
        $place->spaces = $data['spaces'];

        if($place->hasChanged()){
            $this->placeModel->save($place);
            $place->id = $isUpdate
                    ? $place->id
                    : $this->placeModel->getInsertID();
        }
        return $place;
    }
    public function getPlaceList(): array{
        return $this->placeModel->findAll();
    }
    public function getFreeSpace(){

    }
    public function getTotalSpace(){

    }
    public function getSpace(){
        $spaces = [];
        $psaces['free'] = $this->getFreeSpace();
        $psaces['total'] = $this->getTotalSpace();
        return $spaces;
    }
}