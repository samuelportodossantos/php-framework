<?php 
class Migrate extends DB { 

    protected $table;
    protected $dbsa = DBSA;
    protected $columns = [];
    protected $query = "";
    private $fields = "";

    function __construct($table)
    {   
        $this->table = strtolower($table);
        parent::__construct($this->table);
    }

    private function createTable()
    {
        $con = parent::getConnection();
        $con->query($this->query);
    }

    protected function run ()
    {
        foreach($this->columns as $key => $column) {
            if ( $key >= count($this->columns) - 1 ) {
                $this->fields .= $column;
            } else {
                $this->fields .= "{$column}, ";
            }
        }
        $this->query .= "CREATE TABLE IF NOT EXISTS {$this->dbsa}.{$this->table} ($this->fields) CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;";
        $this->createTable();
    }

    protected function primary($fieldName)
    {
        $this->columns[] = "{$fieldName} INT NOT NULL PRIMARY KEY AUTO_INCREMENT";
    }

    protected function integer($fieldName, $default = 11)
    {
        $this->columns[] = "{$fieldName} INT($default)";
    }

    protected function longtext($fieldName)
    {
        $this->columns[] = "{$fieldName} LONGTEXT";
    }

    protected function double($fieldName)
    {
        $this->columns[] = "{$fieldName} DOUBLE";
    }

    protected function boolean($fieldName)
    {
        $this->columns[] = "{$fieldName} BOOLEAN";
    }

    protected function varchar($fieldName, $default = 255)
    {
        $this->columns[] = "{$fieldName} VARCHAR({$default})";
    }

    public function makeMigrations ()
    {   
        $ignore = ['.', '..', 'Migrate.php', 'DefaultMigration.php'];
        $migrations = dir(__DIR__);
        while( $file = $migrations->read()) {
            if ( !in_array($file, $ignore) ) {
                $class = strtolower(explode('Migration.', $file)[0]);
                $mig = new Migration();
                $mig->where('table_name', $class);
                $res = $mig->get();
                $migrated = 1;
                if (!$res) {
                   $mig->save([
                        'table_name' => $class,
                        'migrated' => true
                    ]);
                    $migrated = 0;
                } else {
                    if ( $res->migrated != 1 ) {
                        $migrated = 0;
                        $mig->update($res->id, ['migrated' => true]);
                    }
                }
                if ($migrated == 0) {
                    $class = ucfirst($class)."Migration";
                    (new $class);
                }
            }
        }
    }

}