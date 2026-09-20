<?php

class Complaint
{
    private $complaintId;
    private $customerId;
    private $productId;
    private $complaintTypeId;
    private $technicianId;
    private $description;
    private $status;
    private $dateCreated;
    private $resolutionDate;
    private $resolutionNotes;
    private $dateUpdated;

    public function __construct(
        $complaintId = null,
        $customerId = null,
        $productId = null,
        $complaintTypeId = null,
        $technicianId = null,
        $description = '',
        $status = 'Open',
        $dateCreated = null,
        $resolutionDate = null,
        $resolutionNotes = null,
        $dateUpdated = null
    ) {
        $this->complaintId = $complaintId;
        $this->customerId = $customerId;
        $this->productId = $productId;
        $this->complaintTypeId = $complaintTypeId;
        $this->technicianId = $technicianId;
        $this->description = $description;
        $this->status = $status;
        $this->dateCreated = $dateCreated;
        $this->resolutionDate = $resolutionDate;
        $this->resolutionNotes = $resolutionNotes;
        $this->dateUpdated = $dateUpdated;
    }

    public function getComplaintId()
    {
        return $this->complaintId;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getComplaintTypeId()
    {
        return $this->complaintTypeId;
    }

    public function getTechnicianId()
    {
        return $this->technicianId;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function getResolutionDate()
    {
        return $this->resolutionDate;
    }

    public function getResolutionNotes()
    {
        return $this->resolutionNotes;
    }

    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    public function setComplaintId($complaintId)
    {
        $this->complaintId = $complaintId;
    }

    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function setComplaintTypeId($complaintTypeId)
    {
        $this->complaintTypeId = $complaintTypeId;
    }

    public function setTechnicianId($technicianId)
    {
        $this->technicianId = $technicianId;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    public function setResolutionDate($resolutionDate)
    {
        $this->resolutionDate = $resolutionDate;
    }

    public function setResolutionNotes($resolutionNotes)
    {
        $this->resolutionNotes = $resolutionNotes;
    }

    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }
}

?>