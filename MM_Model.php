<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MM_Model extends CI_Model
{

    protected  $_table;
    protected  $_key;


    public function __construct(){
        parent::__construct();
    }

    /**
     * @param $id - id of the record to return.
     * @return mixed - return result
     */

    public function get($id){
        $sql = "SELECT * FROM " . $this->_table . " WHERE " . $this->_key . "= ?;";
        $query = $this->db->query($sql,$id);
        return $query->result();
    }

    /**
     * @param $id - Id of the record to update
     * @param $args - the fields to update.
     * @return mixed - return result.
     */

    public function update($id,$args){
        $data = $this->fieldsBuilder($args);
        $values = $data['values'];
        $values[] = $id;
        $sql = "UPDATE " . $this->_table . "SET " . $data['fields'] . " WHERE " . $this->_key . " = ?";
        $query = $this->db->query($sql,$values);
        return $query->result();
    }

    /**
     * @param $id - record to delete
     * @return mixed
     */

    public function delete($id){
        $sql = "DELETE FROM " . $this->_table . " WHERE  " . $this->_key . "= ? ;";
        $query = $this->db->query($sql,$id);
        return $query->result();
    }

    /**
     * @param $args - an array of key value pairs to to build an insert or update string.
     * @return array - Return an associative array with feilds string and the value to enter.
     */

    private function fieldsBuilder($args)
    {
        $data = array();
        $fields = '';
        $fieldCount = count($args);
        $i = 1;
        foreach ($args as $key => $value) {

            if ($i == $fieldCount) {
                $fields = $fields . " `" . $key . "` = ?";
            } else {
                $fields = $fields . " `" . $key . "` = ?,";
            }

            $data[] = $value;
            $i++;
        }

        return array('fields' => $fields, 'values' => $data);

    }


}