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
        $place = $this->placeModel->find($id);
        $place->floor = json_decode($place->floor);
        return $place;
    }
    public function getPlaceByName(string $name): ?Place{
        return $this->placeModel->where('name', $name)->first();
    }
    public function createPlace(array $data): Place{
        $isUpdate = array_key_exists('id', $data);
        $place = $isUpdate
            ? $this->getPlaceById($data['id'])
            : new Place();

        $place->place_name = $data['place_name'];
        $place->place_address = $data['place_address'];
        $place->spaces = $data['spaces'];
        $place->floor = json_encode($data['floor']);

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
    public function deletePlace($id_place){
        $this->placeModel->delete($id_place);
        return true;
    }
    public function hasPlaceDefined(int $id_car){
        $sql = "SELECT *
                FROM (
                    SELECT *, ROW_NUMBER() OVER (ORDER BY id DESC) AS new_id
                    FROM records
                    WHERE type IN ('in', 'out')
                        AND id_car = {$id_car}
                        AND do = 1
                    ORDER BY id DESC
                ) AS R
                GROUP BY id_car
                HAVING R.type = 'in'";
        $result = $this->placeModel->query($sql)->getResult();
        $place = current($result);
        return !(empty($place->floor) || empty($place->letter) || empty($place->number));
    }
    public function getFloorLevelAvailable(int $id_place, $multiArray = false){
        $place = $this->getPlaceById($id_place);
        $floor = $place->floor;

        $places = [];

        $values = $floor[0];
        for ($l = $values->levels; $l >= 1; $l--) {
            foreach($values->place_letter as $pl){
                for ($i = 1; $i <= $values->places_quantity; $i++) {
                    $p = [];
                    $p['name'] = "Piso {$l} - ".$pl.$i;
                    $p['status'] = true;
                    if($multiArray) $places[$l][$pl][$i] = $p;
                    else            $places[$l.'|'.$pl.'|'.$i] = $p;
                }
                if(!$multiArray)
                    $places[] = 'disabled';
            }
        }

        $values = $floor[1];
        for ($l = 1; $l <= $values->levels; $l++) {
            foreach($values->place_letter as $pl){
                for ($i = 1; $i <= $values->places_quantity; $i++) {
                    $p = [];
                    $p['name'] = "Sótano {$l} - ".$pl.$i;
                    $p['status'] = true;
                    if($multiArray) $places[$l*-1][$pl][$i] = $p;
                    else            $places[($l*-1).'|'.$pl.'|'.$i] = $p;
                }
                if(!$multiArray)
                    $places[] = 'disabled';
            }
        }
        if(!$multiArray)
            array_pop($places);

        $sql = "SELECT R.*, cars.id_user, cars.plate
                FROM (
                    SELECT *
                    FROM (SELECT *, ROW_NUMBER() OVER (ORDER BY id DESC) AS new_id
                        FROM records
                        WHERE type IN ('in', 'out')
                            AND id_place = {$id_place}
                            AND do = 1
                        ORDER BY id DESC) AS R
                    GROUP BY id_car
                    HAVING R.type = 'in'
                ) as R
                JOIN cars ON cars.id = R.id_car";
        $result = $this->placeModel->query($sql)->getResult();
        foreach ($result as $value) {
            if(empty($value->floor) || empty($value->letter) || empty($value->number)) continue;
            if($multiArray) {
                $places[$value->floor][$value->letter][$value->number]['status'] = false;
                $places[$value->floor][$value->letter][$value->number]['plate'] = $value->plate;
                $places[$value->floor][$value->letter][$value->number]['id_user'] = $value->id_user;
            } else {
                $places[$value->floor.'|'.$value->letter.'|'.$value->number]['status'] = false;
                $places[$value->floor.'|'.$value->letter.'|'.$value->number]['plate'] = $value->plate;
                $places[$value->floor.'|'.$value->letter.'|'.$value->number]['id_user'] = $value->id_user;
            }
        }
        return $places;
    }
    public function getFloorLevelAvailableFull(?int $id_place = null){
        $places = $this->getPlacesAvailable($id_place);
        $places = array_map(function($place){
            $list = $this->getFloorLevelAvailable($place->id, true);
            $place->floor = $list;
            return $place;
        }, $places);

        if(!is_null($id_place)){
            foreach ($places as $place) {
                if($place->id == $id_place){
                    return $place;
                }
            }
        }
        return $places;
    }
    public function getPlacesAvailable(){
        $available = [];
        $sql = "SELECT places.*, count(id_place) as occuped, (spaces - count(id_place)) as free
                FROM (
                   SELECT *
                   FROM (
                            SELECT *, ROW_NUMBER() OVER (ORDER BY id DESC) AS new_id
                            FROM records
                            WHERE type IN ('in', 'out')
                                AND do = 1
                            ORDER BY id DESC
                        ) AS R 
                   GROUP BY id_car
                   HAVING R.type = 'in'
                ) AS R
                JOIN places ON R.id_place = places.id
                GROUP BY id_place";
        $parkingOccuped = $this->placeModel->query($sql)->getResult();
        $ids = array_column($parkingOccuped, 'id');

        $parkingWithoutOccuped = [];
        if(!empty($ids)){
            $parkingWithoutOccuped = $this->placeModel->whereNotIn('id', $ids)->findAll();
            $parkingWithoutOccuped = array_map(function($place){
                $place->free = $place->spaces;
                $place->occuped = 0;
                return $place;
            }, $parkingWithoutOccuped);
        }
        $available = array_merge($parkingOccuped, $parkingWithoutOccuped);
        return $available;
    }
    public function getPlaceAvailable(int $id_place){
        $places = $this->getPlacesAvailable();
        foreach($places as $place)
            if($place->id == $id_place) break;

        if($place->id != $id_place)
            return [];
        return $place;
    }
}