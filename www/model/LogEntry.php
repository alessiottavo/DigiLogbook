<?php
class LogEntry {
    private $id;
    private $pilotId;
    private $aircraftId;
    private $departurePlace;
    private $departureTime;
    private $arrivalPlace;
    private $arrivalTime;
    private $multiEngine;
    private $totalTime;
    private $takeoffs;
    private $landings;
    private $pilotFunCommand;
    private $pilotFunCopilot;
    private $pilotFunDual;
    private $pilotFunInstructor;
    private $remarks;

    // Constructor to initialize properties
    public function __construct($pilotId, $aircraftId, $departurePlace, $departureTime, $arrivalPlace, $arrivalTime, $multiEngine, $totalTime, $takeoffs, $landings, $pilotFunCommand, $pilotFunCopilot, $pilotFunDual, $pilotFunInstructor, $remarks, $id = null) {
        $this->id = $id;
        $this->pilotId = $pilotId;
        $this->aircraftId = $aircraftId;
        $this->departurePlace = $departurePlace;
        $this->departureTime = $departureTime;
        $this->arrivalPlace = $arrivalPlace;
        $this->arrivalTime = $arrivalTime;
        $this->multiEngine = $multiEngine;
        $this->totalTime = $totalTime;
        $this->takeoffs = $takeoffs;
        $this->landings = $landings;
        $this->pilotFunCommand = $pilotFunCommand;
        $this->pilotFunCopilot = $pilotFunCopilot;
        $this->pilotFunDual = $pilotFunDual;
        $this->pilotFunInstructor = $pilotFunInstructor;
        $this->remarks = $remarks;
    }

    // Getters and setters
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPilotId() {
        return $this->pilotId;
    }

    public function setPilotId($pilotId) {
        $this->pilotId = $pilotId;
    }

    public function getAircraftId() {
        return $this->aircraftId;
    }

    public function setAircraftId($aircraftId) {
        $this->aircraftId = $aircraftId;
    }

    public function getDeparturePlace() {
        return $this->departurePlace;
    }

    public function setDeparturePlace($departurePlace) {
        $this->departurePlace = $departurePlace;
    }

    public function getDepartureTime() {
        return $this->departureTime;
    }

    public function setDepartureTime($departureTime) {
        $this->departureTime = $departureTime;
    }

    public function getArrivalPlace() {
        return $this->arrivalPlace;
    }

    public function setArrivalPlace($arrivalPlace) {
        $this->arrivalPlace = $arrivalPlace;
    }

    public function getArrivalTime() {
        return $this->arrivalTime;
    }

    public function setArrivalTime($arrivalTime) {
        $this->arrivalTime = $arrivalTime;
    }

    public function isMultiEngine() {
        return $this->multiEngine;
    }

    public function setMultiEngine($multiEngine) {
        $this->multiEngine = $multiEngine;
    }

    public function getTotalTime() {
        return $this->totalTime;
    }

    public function setTotalTime($totalTime) {
        $this->totalTime = $totalTime;
    }

    public function getTakeoffs() {
        return $this->takeoffs;
    }

    public function setTakeoffs($takeoffs) {
        $this->takeoffs = $takeoffs;
    }

    public function getLandings() {
        return $this->landings;
    }

    public function setLandings($landings) {
        $this->landings = $landings;
    }

    public function getPilotFunCommand() {
        return $this->pilotFunCommand;
    }

    public function setPilotFunCommand($pilotFunCommand) {
        $this->pilotFunCommand = $pilotFunCommand;
    }

    public function getPilotFunCopilot() {
        return $this->pilotFunCopilot;
    }

    public function setPilotFunCopilot($pilotFunCopilot) {
        $this->pilotFunCopilot = $pilotFunCopilot;
    }

    public function getPilotFunDual() {
        return $this->pilotFunDual;
    }

    public function setPilotFunDual($pilotFunDual) {
        $this->pilotFunDual = $pilotFunDual;
    }

    public function getPilotFunInstructor() {
        return $this->pilotFunInstructor;
    }

    public function setPilotFunInstructor($pilotFunInstructor) {
        $this->pilotFunInstructor = $pilotFunInstructor;
    }

    public function getRemarks() {
        return $this->remarks;
    }

    public function setRemarks($remarks) {
        $this->remarks = $remarks;
    }
}