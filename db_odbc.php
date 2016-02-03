<?php

//DB ODBC Class @0-DD80A81E
/*
 * Database Management for PHP
 *
 * Copyright (c) 1998-2000 Cameron Taggart (cameront@wolfenet.com)
 *        Modified by Guarneri carmelo (carmelo@melting-soft.com)
 *        Modified by Vitaliy Radchuk  (vitaliy.radchuk@yessoftware.com)
 *           
 * db_odbc.php
 */ 

class DB_ODBC {
  public $DBHost     = "";
  public $DBDatabase = "";
  public $DBUser     = "";
  public $DBPassword = "";
  public $UseODBCCursor = 0;
  public $Options = array();
  public $Persistent = false;
  public $Uppercase  = false;

  public $Link_ID  = 0;
  public $Query_ID = 0;
  public $Record   = array();
  public $Row      = 0;
  
  public $Errno    = 0;
  public $Error    = "";

  public $Auto_Free = 1;     ## set this to 1 to automatically free results
  public $Connected = false;

  /* public: constructor */
  function DB_Sql($query = "") {
      $this->query($query);
  }

  function try_connect() {
    $this->Query_ID  = 0;
    if ($this->Persistent)
      $this->Link_ID = @odbc_pconnect($this->DBDatabase, $this->DBUser, $this->DBPassword, $this->UseODBCCursor);
    else
      $this->Link_ID = @odbc_connect($this->DBDatabase, $this->DBUser, $this->DBPassword, $this->UseODBCCursor);

    $this->Connected = $this->Link_ID ? true : false;
    return $this->Connected;
  }

  function connect() {
    if (!$this->Connected)
    {
      $this->Query_ID  = 0;
      if ($this->Persistent)
        $this->Link_ID=odbc_pconnect($this->DBDatabase, $this->DBUser, $this->DBPassword, $this->UseODBCCursor);
      else
        $this->Link_ID=odbc_connect($this->DBDatabase, $this->DBUser, $this->DBPassword, $this->UseODBCCursor);

      if (!$this->Link_ID) {
         $this->Halt("Cannot connect ot Database: " . odbc_errormsg());
         return false;
      }

      foreach ($this->Options as $option) {
        @odbc_setoption($this->Link_ID, $option[0], $option[1], $option[2]);
      }
      $this->Connected = true;
    }
  }
  
  function query($Query_String) {

    /* No empty queries, please, since PHP4 chokes on them. */
    if ($Query_String == "")
      /* The empty query string is passed on from the constructor,
       * when calling the class without a query, e.g. in situations
       * like these: '$db = new DB_Sql_Subclass;'
       */
      return 0;

    $this->connect();
    
#   printf("<br>Debug: query = %s<br>\n", $Query_String);

#   rei@netone.com.br suggested that we use this instead of the odbc_exec().
#   He is on NT, connecting to a Unix MySQL server with ODBC. -- KK
#    $this->Query_ID = odbc_prepare($this->Link_ID,$Query_String);
#    $this->Query_Ok = odbc_execute($this->Query_ID);

    $this->free_result(); 
        
    $this->Query_ID = odbc_exec($this->Link_ID,$Query_String);
    $this->Row = 0;
    odbc_binmode($this->Query_ID, 1);
    //odbc_longreadlen($this->Query_ID, 4096);
    
    if (!$this->Query_ID) {
      $this->Errno = 1;
      $this->Error = "General Error (The ODBC interface cannot return detailed error messages).";
      $this->Errors->addError("Database error: " . (odbc_errormsg() ? odbc_errormsg() : $this->Error));
    }
    return $this->Query_ID;
  }
  
  function execute($Procedure, $RS = 0) {
    $this->Query_ID = $this->query($Procedure);
    if ($this->Query_ID) {
      for ($i = 0; $i < $RS; $i++) {
        odbc_next_result($this->Query_ID);
      }
    }
    return $this->Query_ID;
  }
  
  function next_record() {
    if (!$this->Query_ID) 
      return 0;

    $this->Record = array();
    $stat = odbc_fetch_row($this->Query_ID);
    if (!$stat) {
      if ($this->Auto_Free)
      {
        $this->free_result();
      };
    } else {
      $this->Row++;
      // add to Record[<key>]
      $count = odbc_num_fields($this->Query_ID);
      for ($i=1; $i<=$count; $i++)
      {
        $field_value = odbc_result($this->Query_ID, $i );
        $fieldname = ($this->Uppercase) ? strtoupper(odbc_field_name($this->Query_ID, $i)) : odbc_field_name($this->Query_ID, $i);
        $this->Record[$fieldname] = $field_value;
        $this->Record[$i - 1] = $field_value;
      }
    }
    return $stat;
  }

  function seek($pos) {
    $i = 0;
    while($i < $pos && @odbc_fetch_row($this->Query_ID)) $i++;
    $this->Row += $i;
    return true;
  }

  function metadata($table) {
    $count = 0;
    $id    = 0;
    $res   = array();

    $this->connect();
    $id = odbc_exec($this->Link_ID, "select * from $table");
    if (!$id) {
      $this->Errno = 1;
      $this->Error = "General Error (The ODBC interface cannot return detailed error messages).";
      $this->Errors->addError("Metadata query failed: " . (odbc_errormsg() || $this->Error));
      return 0;
    }
    $count = odbc_num_fields($id);
    
    for ($i=1; $i<=$count; $i++) {
      $res[$i]["table"] = $table;
      $name             = odbc_field_name ($id, $i);
      $res[$i]["name"]  = $name;
      $res[$i]["type"]  = odbc_field_type ($id, $name);
      $res[$i]["len"]   = 0;  // can we determine the width of this column?
      $res[$i]["flags"] = ""; // any optional flags to report?
    }
    if (is_resource($id)) {    
      @odbc_free_result($id);
    }
    return $res;
  }
  
  function affected_rows() {
    return odbc_num_rows($this->Query_ID);
  }
  
  function num_rows() {
    # Many ODBC drivers donï¿½t support odbc_num_rows() on SELECT statements.
    $num_rows = odbc_num_rows($this->Query_ID);
  //printf ($num_rows."<br>");

    # This is a workaround. It is intended to be ugly.
    if ($num_rows < 0) {
      $i=10;
      while (odbc_fetch_row($this->Query_ID, $i)) 
        $i*=10;

      $j=0;
      while ($i!=$j) {
        $k= $j+intval(($i-$j)/2);
        if (odbc_fetch_row($this->Query_ID, $k))
          $j=$k;
        else 
          $i=$k;
        if (($i-$j)==1) {
          if (odbc_fetch_row($this->Query_ID, $i)) 
            $j=$i;
          else 
            $i=$j; 
        };
        //printf("$i $j $k <br>");
      };
      $num_rows=$i;
    }

    return $num_rows;
  }
  
  function num_fields() {
    return count($this->Record)/2;
  }

  function nf() {
    return $this->num_rows();
  }
  
  function np() {
    print $this->num_rows();
  }
  
  function f($Field_Name) {
    if($this->Uppercase) $Field_Name = strtoupper($Field_Name);
    return $this->Record && array_key_exists($Field_Name, $this->Record) ? $this->Record[$Field_Name] : "";
  }
  
  function p($Field_Name) {
    print $this->f($Field_Name);
  }

  function free_result() {
    if (is_resource($this->Query_ID)) {    
      @odbc_free_result($this->Query_ID);
    }
    $this->Query_ID = 0;
  }

  function close()
  {
    if ($this->Query_ID) {
      $this->free_result();
    }
    /*
    For better perfomance, now php(by docs) must close connection when script finished
    if ($this->Connected) {
      odbc_close($this->Link_ID);
      $this->Connected = false;
    }
    */
  }
      
  function close_all()
  {
    odbc_close_all ();
  }  
  
  function halt($msg) {
    printf("</td></tr></table><b>Database error:</b> %s<br>\n", $msg);
    printf("<b>ODBC Error</b><br>\n");
    die("Session halted.");
  }
      
  function esc($value) {
    $this->halt("Escaping not implemented");     
  }

}

//End DB ODBC Class


?>
