<?php
include_once "./Product.php";
$results = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Basic Search</title>
</head>

<body>
    <form method="get">
        <input type="text" name="query" id="">

        <input type="submit" name="submit" id=""><br>
        <div class="radios">
            <input type="radio" name="prodLine" value=""> none <br>
            <?php
            $productLines = Product::getProductLines();
            for ($i = 0; $i < count($productLines); $i++) {
            ?>
                <input type="radio" name="prodLine" value="<?php echo $productLines[$i] ?>"><?php echo $productLines[$i] ?><br>
            <?php
            }
            ?>

        </div>
    </form>
    <br>

    <!-- <div class="card">
        <h3>Name: XXXXXX</h3>
        <p>Code: XXXXXX</p>
        <p>Line: XXXXXX</p>
    </div> -->

    <?php
    if (isset($_GET["submit"])) {

        $query = null;
        $prodLine = null;

        if (isset($_GET["query"]) && !empty($_GET["query"])) {
            $query = $_GET["query"];
        }

        if (isset($_GET["prodLine"]) && !empty($_GET["prodLine"])) {
            $prodLine = $_GET["prodLine"];
        }

        $results = Product::advancedSearch($query, $prodLine);

        if ($results != false) {
            foreach ($results as $row) {
    ?>
                <div class="card">
                    <h3>Name: <?php echo $row->productName ?></h3>
                    <p>Code: <?php echo $row->productCode ?></p>
                    <p>Line: <?php echo $row->productLine ?></p>
                </div>
            <?php
            }
        }
    }

    if (!isset($_GET["submit"])) {
        $results = Product::advancedSearch();
        if ($results != false) {
            foreach ($results as $row) {
            ?>
                <div class="card">
                    <h3>Name: <?php echo $row->productName ?></h3>
                    <p>Code: <?php echo $row->productCode ?></p>
                    <p>Line: <?php echo $row->productLine ?></p>
                </div>
    <?php
            }
        }
    }
    ?>

    <?php
    $rowsNum = Product::getSelectCount();
    $pagesNum = ceil($rowsNum / Product::$rowsPerPage);
    echo $pagesNum;

    for ($i = 1; $i <= $pagesNum; $i++) {
    ?>
        <a href="<?php echo $_SERVER['PHP_SELF'] .  '?' . http_build_query(array_merge($_GET, array("page" => $i))) ?>"><?php echo $i ?></a>
    <?php
    }
    ?>

</body>

</html>