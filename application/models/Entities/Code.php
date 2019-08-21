<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Code
 *
 * @Table(name="code")
 * @Entity
 */
class Code
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
     * @Column(name="category", type="string", length=45, nullable=true)
     */
    private $category;

    /**
     * @var string
     *
     * @Column(name="code", type="string", length=45, nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Column(name="note", type="string", length=45, nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @Column(name="reserve1", type="string", length=64, nullable=true)
     */
    private $reserve1;

    /**
     * @var string
     *
     * @Column(name="reserve2", type="string", length=64, nullable=true)
     */
    private $reserve2;

    /**
     * @var string
     *
     * @Column(name="reserve3", type="string", length=64, nullable=true)
     */
    private $reserve3;

    /**
     * @var string
     *
     * @Column(name="reserve4", type="string", length=64, nullable=true)
     */
    private $reserve4;

    /**
     * @var string
     *
     * @Column(name="reserve5", type="string", length=64, nullable=true)
     */
    private $reserve5;

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
     * Set category
     *
     * @param string $category
     * @return Code
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Code
     */
    public function setCode($code)
    {
        $this->code = $code;
    
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Code
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Code
     */
    public function setNote($note)
    {
        $this->note = $note;
    
        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set reserve1
     *
     * @param string $reserve1
     * @return Code
     */
    public function setReserve1($reserve1)
    {
        $this->reserve1 = $reserve1;
    
        return $this;
    }

    /**
     * Get reserve1
     *
     * @return string 
     */
    public function getReserve1()
    {
        return $this->reserve1;
    }

    /**
     * Set reserve2
     *
     * @param string $reserve2
     * @return Code
     */
    public function setReserve2($reserve2)
    {
        $this->reserve2 = $reserve2;
    
        return $this;
    }

    /**
     * Get reserve2
     *
     * @return string 
     */
    public function getReserve2()
    {
        return $this->reserve2;
    }

    /**
     * Set reserve3
     *
     * @param string $reserve3
     * @return Code
     */
    public function setReserve3($reserve3)
    {
        $this->reserve3 = $reserve3;
    
        return $this;
    }

    /**
     * Get reserve3
     *
     * @return string 
     */
    public function getReserve3()
    {
        return $this->reserve3;
    }

    /**
     * Set reserve4
     *
     * @param string $reserve4
     * @return Code
     */
    public function setReserve4($reserve4)
    {
        $this->reserve4 = $reserve4;
    
        return $this;
    }

    /**
     * Get reserve4
     *
     * @return string 
     */
    public function getReserve4()
    {
        return $this->reserve4;
    }

    /**
     * Set reserve5
     *
     * @param string $reserve5
     * @return Code
     */
    public function setReserve5($reserve5)
    {
        $this->reserve5 = $reserve5;
    
        return $this;
    }

    /**
     * Get reserve5
     *
     * @return string 
     */
    public function getReserve5()
    {
        return $this->reserve5;
    }

    /**
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Code
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
     * @return Code
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
     * @return Code
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
     * @return Code
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
     * @return Code
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
