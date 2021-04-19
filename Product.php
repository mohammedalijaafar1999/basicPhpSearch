<?php
include_once "./Database.php";
class Product
{

    private $productCode;
    private $productName;
    private $productLine;
    private $productScale;
    private $productVendor;
    private $productDescription;

    public static $rowsPerPage = 8;

    public function __construct()
    {
        $this->productCode = null;
        $this->productName = null;
        $this->productLine = null;
        $this->productScale = null;
        $this->productVendor = null;
        $this->productDescription = null;
    }

    /**
     * Get the value of productCode
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * Set the value of productCode
     *
     * @return  self
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;

        return $this;
    }

    /**
     * Get the value of productName
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set the value of productName
     *
     * @return  self
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get the value of productLine
     */
    public function getProductLine()
    {
        return $this->productLine;
    }

    /**
     * Set the value of productLine
     *
     * @return  self
     */
    public function setProductLine($productLine)
    {
        $this->productLine = $productLine;

        return $this;
    }

    /**
     * Get the value of productScale
     */
    public function getProductScale()
    {
        return $this->productScale;
    }

    /**
     * Set the value of productScale
     *
     * @return  self
     */
    public function setProductScale($productScale)
    {
        $this->productScale = $productScale;

        return $this;
    }

    /**
     * Get the value of productVendor
     */
    public function getProductVendor()
    {
        return $this->productVendor;
    }

    /**
     * Set the value of productVendor
     *
     * @return  self
     */
    public function setProductVendor($productVendor)
    {
        $this->productVendor = $productVendor;

        return $this;
    }

    /**
     * Get the value of productDescription
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }

    /**
     * Set the value of productDescription
     *
     * @return  self
     */
    public function setProductDescription($productDescription)
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function initWithId($id)
    {
        # code...
    }

    static public function getAll()
    {
        $conn = Database::getInstance();
        $mysqli = $conn->getConnection();

        $results = $mysqli->query("select SQL_CALC_FOUND_ROWS * from products");

        $objects = [];
        if ($results) {
            while ($row = $results->fetch_object()) {
                $objects[] = $row;
            }
            return $objects;
        } else {
            echo "Something went wrong";
            return false;
        }
    }

    // static public function basicSearch($query)
    // {
    //     $conn = Database::getInstance();
    //     $mysqli = $conn->getConnection();

    //     //$results = $mysqli->query("select * from products where productName = '$query'");
    //     $results = $mysqli->query("select * from products where match (productName, productCode) against('$query' IN NATURAL LANGUAGE MODE)");

    //     $objects = [];
    //     if ($results) {
    //         while ($row = $results->fetch_object()) {
    //             $objects[] = $row;
    //             echo $row->productCode . " - " . $row->productName . " - " . $row->productLine . "<br/>";
    //         }
    //         return $objects;
    //     } else {
    //         echo "Something went wrong";
    //         return false;
    //     }
    // }

    static public function getProductLines()
    {
        $conn = Database::getInstance();
        $mysqli = $conn->getConnection();

        $results = $mysqli->query("select * from productlines");
        $productLines = [];

        if ($results) {
            while ($row = $results->fetch_assoc()) {
                $productLines[] = $row["productLine"];
            }
            return $productLines;
        } else {
            return false;
        }
    }

    static public function advancedSearch($query = null, $productLine = null)
    {

        //get selected page
        $pageNum = 1;

        if (isset($_GET["page"]) && !empty($_GET["page"])) {
            $pageNum = intval($_GET["page"]);
        }

        //get instance
        $conn = Database::getInstance();
        $mysqli = $conn->getConnection();

        //basic query
        $sql = "select SQL_CALC_FOUND_ROWS * from products where 1=1";

        //add search query if provided
        if ($query != null) {
            $sql .= " and match (productName, productCode) against('$query' IN NATURAL LANGUAGE MODE)";
        }

        //add product line if provided
        if ($productLine != null) {
            $sql .= " and productLine = '$productLine'";
        }

        //calculate the rows per page
        $startRows = ($pageNum - 1) * Product::$rowsPerPage;
        $totalRowsPerPage = Product::$rowsPerPage;
        $sql .= " limit $startRows,$totalRowsPerPage";

        //to see the final sql result
        echo $sql . "<br><br>";

        //obvious stuff that don't need explanation
        $results = $mysqli->query($sql);

        $objects = [];
        if ($results) {
            while ($row = $results->fetch_object()) {
                $objects[] = $row;
                //echo $row->productCode . " - " . $row->productName . " - " . $row->productLine . "<br/>";
            }
            return $objects;
        } else {
            echo "Something went wrong";
            return false;
        }
    }

    static public function getSelectCount()
    {
        $conn = Database::getInstance();
        $mysqli = $conn->getConnection();

        $result = $mysqli->query("SELECT FOUND_ROWS();");

        $row = $result->fetch_row();

        return intval($row[0]);
    }
}
