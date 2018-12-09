<?php

class Install_model extends CI_Model
{
    public function create_db()
    {
        $query = "CREATE DATABASE IF NOT EXISTS wunderproject
                  COLLATE = utf8_general_ci";
        $this->db->query($query);
        $query = "USE wunderproject";
        $this->db->query($query);
    }

    public function create_tables()
    {
        $query = "CREATE TABLE IF NOT EXISTS users
                  (
                  id            INT(11) UNSIGNED    NOT NULL    AUTO_INCREMENT  PRIMARY KEY,
                  email_address VARCHAR(200)        NOT NULL    UNIQUE,
                  first_name    VARCHAR(50)         NOT NULL,
                  last_name     VARCHAR(50)         NOT NULL,
                  telephone     VARCHAR(22)         NOT NULL,
                  password      VARCHAR(32)         NOT NULL,

                  street        VARCHAR(50)         ,
                  house_number  VARCHAR(10)         ,
                  zip_code      VARCHAR(10)         ,
                  city          VARCHAR(50)         ,

                  account_owner VARCHAR(100)        ,
                  iban          VARCHAR(30)         ,

                  payment_data_id VARCHAR(300)      ,


                  active        ENUM('0', '1')      NOT NULL    DEFAULT '0',
                  INDEX (first_name, last_name)
                  )
                  ENGINE = InnoDB   CHARSET=utf8  COLLATE utf8_general_ci";
        $this->db->query($query);
    }
}

?>