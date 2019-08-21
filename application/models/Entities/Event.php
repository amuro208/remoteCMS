<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @Table(name="event")
 * @Entity
 */
class Event
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="projectCode", type="string", length=10, nullable=true)
     */
    private $projectcode;
    /**
     * @var string
     *
     * @Column(name="eventCode", type="string", length=10, nullable=true)
     */
    private $eventcode;

    /**
     * @var string
     *
     * @Column(name="siteCode", type="string", length=10, nullable=true)
     */
    private $sitecode;

    /**
     * @var string
     *
     * @Column(name="startDate", type="string", length=10, nullable=true)
     */
    private $startdate;

    /**
     * @var string
     *
     * @Column(name="endDate", type="string", length=10, nullable=true)
     */
    private $enddate;

    /**
     * @var \DateTime
     *
     * @Column(name="createDate", type="datetime", nullable=true)
     */
    private $createdate;

    /**
     * @var integer
     *
     * @Column(name="createUser", type="integer", nullable=true)
     */
    private $createuser;

    /**
     * @var \DateTime
     *
     * @Column(name="updateDate", type="datetime", nullable=true)
     */
    private $updatedate;

    /**
     * @var integer
     *
     * @Column(name="updateUser", type="integer", nullable=true)
     */
    private $updateuser;

    /**
     * @var string
     *
     * @Column(name="valid", type="string", length=1, nullable=true)
     */
    private $valid = 'Y';


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set eventcode
     *
     * @param string $eventcode
     * @return Event
     */
    public function setProjectcode($projectcode)
    {
        $this->projectcode = $projectcode;

        return $this;
    }

    /**
     * Get eventcode
     *
     * @return string
     */
    public function getProjectcode()
    {
        return $this->projectcode;
    }

    /**
     * Set eventcode
     *
     * @param string $eventcode
     * @return Event
     */
    public function setEventcode($eventcode)
    {
        $this->eventcode = $eventcode;

        return $this;
    }

    /**
     * Get eventcode
     *
     * @return string
     */
    public function getEventcode()
    {
        return $this->eventcode;
    }

    /**
     * Set sitecode
     *
     * @param string $sitecode
     * @return Event
     */
    public function setSitecode($sitecode)
    {
        $this->sitecode = $sitecode;

        return $this;
    }

    /**
     * Get sitecode
     *
     * @return string
     */
    public function getSitecode()
    {
        return $this->sitecode;
    }

    /**
     * Set startdate
     *
     * @param string $startdate
     * @return Event
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return string
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param string $enddate
     * @return Event
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return string
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Event
     */
    public function setCreatedate($createdate)
    {
        $this->createdate = $createdate;

        return $this;
    }

    /**
     * Get createdate
     *
     * @return \DateTime
     */
    public function getCreatedate()
    {
        return $this->createdate;
    }

    /**
     * Set createuser
     *
     * @param integer $createuser
     * @return Event
     */
    public function setCreateuser($createuser)
    {
        $this->createuser = $createuser;

        return $this;
    }

    /**
     * Get createuser
     *
     * @return integer
     */
    public function getCreateuser()
    {
        return $this->createuser;
    }

    /**
     * Set updatedate
     *
     * @param \DateTime $updatedate
     * @return Event
     */
    public function setUpdatedate($updatedate)
    {
        $this->updatedate = $updatedate;

        return $this;
    }

    /**
     * Get updatedate
     *
     * @return \DateTime
     */
    public function getUpdatedate()
    {
        return $this->updatedate;
    }

    /**
     * Set updateuser
     *
     * @param integer $updateuser
     * @return Event
     */
    public function setUpdateuser($updateuser)
    {
        $this->updateuser = $updateuser;

        return $this;
    }

    /**
     * Get updateuser
     *
     * @return integer
     */
    public function getUpdateuser()
    {
        return $this->updateuser;
    }

    /**
     * Set valid
     *
     * @param string $valid
     * @return Event
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return string
     */
    public function getValid()
    {
        return $this->valid;
    }
}
