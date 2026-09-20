<?php

class TechnicianNote
{
    private $noteId;
    private $complaintId;
    private $technicianId;
    private $noteText;
    private $dateCreated;

    public function __construct(
        $noteId = null,
        $complaintId = null,
        $technicianId = null,
        $noteText = '',
        $dateCreated = null
    ) {
        $this->noteId = $noteId;
        $this->complaintId = $complaintId;
        $this->technicianId = $technicianId;
        $this->noteText = $noteText;
        $this->dateCreated = $dateCreated;
    }

    public function getNoteId()
    {
        return $this->noteId;
    }

    public function getComplaintId()
    {
        return $this->complaintId;
    }

    public function getTechnicianId()
    {
        return $this->technicianId;
    }

    public function getNoteText()
    {
        return $this->noteText;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function setNoteId($noteId)
    {
        $this->noteId = $noteId;
    }

    public function setComplaintId($complaintId)
    {
        $this->complaintId = $complaintId;
    }

    public function setTechnicianId($technicianId)
    {
        $this->technicianId = $technicianId;
    }

    public function setNoteText($noteText)
    {
        $this->noteText = $noteText;
    }

    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }
}

?>