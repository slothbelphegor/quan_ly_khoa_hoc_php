<?php

/**
 * Lớp xử lý kết nối CSDL
 * Bao gồm các thuộc tính và phương thức liên quan
 */
class Database
{
    protected $db_host;
    protected $db_name;
    protected $db_user;
    protected $db_pass;

    // Phuong thuc khoi tao
    public function __construct($db_host, $db_name, $db_user, $db_pass)
    {
        $this->db_host = $db_host;
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
    }

    // Phuong thuc ket noi CSDL
    public function getConn()
    {
        // Tao datasource name (dsn)
        $dsn = "mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8";

        // Tra ve doi tuong ket noi
        try {
            // xin ket noi
            $conn = new PDO($dsn, $this->db_user, $this->db_pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    /*public function query($sql, $conn) {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }
        
        public function fetch($stmt) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
        public function close($conn) {
            $conn = null;
        }
    */
}
