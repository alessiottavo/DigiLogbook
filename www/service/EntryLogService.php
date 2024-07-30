<?php

require './repository/LogEntriesRepository.php';

class EntryLogService {

    private $logEntriesRepo;

    public function __construct() {
        $this->logEntriesRepo = new LogEntriesRepository();
    }

    public function addLogEntry(LogEntry $entry) {
        // Convert times to DateTime objects
        $departureTime = new DateTime($entry->getDepartureTime());
        $arrivalTime = new DateTime($entry->getArrivalTime());
        
        // Calculate total time in hours
        $timeInterval = $departureTime->diff($arrivalTime);
        $calculatedTotalTime = $timeInterval->h * 60 + ($timeInterval->i);
        // Validation
        if ($arrivalTime <= $departureTime) {
            throw new Exception("Arrival time must be after departure time.");
        }

        if ($calculatedTotalTime != $entry->getTotalTime()) {
            throw new Exception("Total time does not match the difference between departure and arrival times.");
        }

        $totalPilotFunTime = $entry->getPilotFunCommand() + $entry->getPilotFunCopilot() + $entry->getPilotFunDual() + $entry->getPilotFunInstructor();
        if ($totalPilotFunTime != $entry->getTotalTime()) {
            throw new Exception("The sum of command, copilot, dual, and instructor times must equal total time.");
        }

        // Add the entry using the repository
        return $this->logEntriesRepo->addEntryFromLogEntry($entry);
    }

    public function deleteAllEntries($pilotId) {
        $this->logEntriesRepo->deleteAllEntries($pilotId);
    }
}
