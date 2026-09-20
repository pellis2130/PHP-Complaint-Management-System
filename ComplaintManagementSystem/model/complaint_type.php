<?php

class ComplaintType
{
    private $complaintTypeId;
    private $typeName;
    private $description;
    private $active;

    public function __construct(
        $complaintTypeId = null,
        $typeName = '',
        $description = '',
        $active = 1
    ) {
        $this->complaintTypeId = $complaintTypeId;
        $this->typeName = $typeName;
        $this->description = $description;
        $this->active = $active;
    }

    public function getComplaintTypeId()
    {
        return $this->complaintTypeId;
    }

    public function getTypeName()
    {
        return $this->typeName;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setComplaintTypeId($complaintTypeId)
    {
        $this->complaintTypeId = $complaintTypeId;
    }

    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }
}

?>