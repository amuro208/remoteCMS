<?php

class Profiler implements Doctrine\DBAL\Logging\SQLLogger
{
    public $start = null;

    private $ci;

    public function __construct()
    {
        $this->ci =& get_instance();
    }

    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, array $params = null, array $types = null)
    {
        $this->start = microtime(true);
        $this->ci->db->queries[] = "/* doctrine */ \n".$sql;
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
        $this->ci->db->query_times[] = microtime(true) - $this->start;
        log_message('debug',json_encode($this->ci->db));
    }
}