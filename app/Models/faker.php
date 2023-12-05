<?php

namespace Models;

require_once(__DIR__ . '/../../vendor/autoload.php');

use Faker\Factory;
use Models\UserModel;
use Models\EquipmentModel;
use Models\PropertiesTypeModel;
use Models\ServiceModel;

$faker = Factory::create('fr_FR');

for ($i = 0; $i < 3; $i++) {
    $lastname = $faker->lastName;
    $firstName = $faker->firstName;
    $phone = $faker->phoneNumber;
    $email = $faker->email;
    $password = $faker->password;
    UserModel::createUser($lastname, $firstName, $phone, $email, $password);
}

for ($i = 0; $i < 3; $i++) {
    $title = $faker->title;
    $description = $faker->text;
    $image = $faker->word . '.jpg';

    $price = $faker->randomFloat(2, 1, 1000);
    $location = $faker->address;
    $city = $faker->city;
    $propertyTypes = PropertiesTypeModel::getAllPropertiesType();
    $propertyTypeIDs = [];
    foreach ($propertyTypes as $propertyType) {
        $propertyTypeIDs[] = $propertyType['ID'];
    }
    $selectedPropertyTypeID = $faker->randomElement($propertyTypeIDs);
    $readallEquipment = EquipmentModel::getAllEquipment();
    $equipmentIDs = [];
    foreach ($readallEquipment as $equipment) {
        $equipmentIDs[] = $equipment['ID'];
    }
    $numberOfSelectedEquipments = $faker->numberBetween(1, count($equipmentIDs));
    $selectedEquipments = $faker->randomElements($equipmentIDs, $numberOfSelectedEquipments);
    $allServices = ServiceModel::getAllServices();
    $serviceNames = [];
    foreach ($allServices as $service) {
        $serviceNames[] = $service['ID'];
    }

    $numberOfSelectedServices = $faker->numberBetween(1, count($serviceNames));
    $selectedServices = $faker->randomElements($serviceNames, $numberOfSelectedServices);

    PropertiesModel::addProperties($title, $description, $image, $price, $location, $city, $selectedPropertyTypeID, $selectedEquipments, $selectedServices);
}
