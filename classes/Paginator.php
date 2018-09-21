<?php
  /**
  * Paginator
  *
  * Data for selecting a page of records
  */
  class Paginator {

    /**
    * @param integer $limit, number of records return
    *@var integer;
    */
    public $limit;

    /**
    * @param integer $offset, number of records to skip before the page
    *@var integer;
    */
    public $offset;

    /**
    * Previous page
    * @var integer
    */
    public $previous;

    /**
    * Next page
    * @var integer
    */
    public $next;

    /**
    * a Constructor
    *
    * @param integer $page, Page number
    * @param integer $records_per_page, number of records per page return
    *
    * @return void
    */
    public function __construct($page, $records_per_page, $total_records) {
      $this->limit = $records_per_page;
      $page = filter_var($page, FILTER_VALIDATE_INT, [
        'options' => [
          'default' => 1,
          'min_range' => 1
        ]
      ]);
      if($page > 1) {
        $this->previous = $page - 1;
      }

      $total_pages = ceil($total_records / $records_per_page);

      if($page < $total_pages) {
        $this->next = $page + 1;
      }
      $this->offset = $records_per_page * ($page - 1);
    }
  }
