<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdatePlaceAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = Place::all();

        foreach ($places as $place) {
            $fullname = explode('-', $place->name);

            // if (count($fullname) == 5) {
            //     $place->name = trim($fullname[0]);

            //     if (isset($fullname[1])) {
            //         $streetNumber = explode(',', $fullname[1]);

            //         $place->street = trim($streetNumber[0]);

            //         if (isset($streetNumber[1])) {
            //             $place->number = trim($streetNumber[1]);
            //         }
            //     }

            //     if (isset($fullname[2])) {
            //         $districtCity = explode(',', $fullname[2]);

            //         $place->district = trim($districtCity[0]);

            //         if (isset($districtCity[1])) {
            //             $place->city = trim($districtCity[1]);
            //         }
            //     }

            //     if (isset($fullname[3])) {
            //         $stateZipcode = explode(',', $fullname[3]);

            //         $place->state = trim($stateZipcode[0]);

            //         if (isset($stateZipcode[1])) {
            //             $place->zipcode = trim($stateZipcode[1]);
            //         }
            //     }

            //     if (isset($fullname[4])) {
            //         $place->zipcode = $place->zipcode . trim($fullname[4]);
            //     }

            //     $place->save();
            // }

            if (count($fullname) == 6) {
                $place->name = trim($fullname[0]) . ' - ' . trim($fullname[1]);

                if (isset($fullname[2])) {
                    $streetNumber = explode(',', $fullname[2]);

                    $place->street = trim($streetNumber[0]);

                    if (isset($streetNumber[1])) {
                        $place->number = trim($streetNumber[1]);
                    }
                }

                if (isset($fullname[3])) {
                    $districtCity = explode(',', $fullname[3]);

                    $place->district = trim($districtCity[0]);

                    if (isset($districtCity[1])) {
                        $place->city = trim($districtCity[1]);
                    }
                }

                if (isset($fullname[4])) {
                    $stateZipcode = explode(',', $fullname[4]);

                    $place->state = trim($stateZipcode[0]);

                    if (isset($stateZipcode[1])) {
                        $place->zipcode = trim($stateZipcode[1]);
                    }
                }

                if (isset($fullname[5])) {
                    $place->zipcode = $place->zipcode . trim($fullname[5]);
                }

                // dd($place->toArray());
                $place->save();
            }
        }
    }
}
