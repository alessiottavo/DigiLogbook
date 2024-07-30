<?php

require './repository/AircraftRepository.php';

class AircraftService {

    private $aircraftRepo;

    public function __construct() {
        $this->aircraftRepo = new AircraftRepository();
    }

    public function addAircraft($make, $registration, $highPerformance, $taildragger, $complex, $gearRetractable) {
        // Validate inputs
        if (empty($make) || empty($registration)) {
            throw new Exception("Make and registration are required.");
        }

        // Check if aircraft already exists
        if ($this->aircraftRepo->aircraftExists($registration)) {
            throw new Exception("An aircraft with this registration already exists.");
        }

        // Add the aircraft using the repository
        return $this->aircraftRepo->addAircraft($make, $registration, $highPerformance, $taildragger, $complex, $gearRetractable);
    }
}
