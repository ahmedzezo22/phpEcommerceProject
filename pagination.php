<html>  
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" href="layout/css/front.css">
<title> Pagination </title>  
</head>  
<body>  
  
<?php  
  
    //database connection  
    $conn = mysqli_connect('localhost', 'root', '');  
    if (! $conn) {  
die("Connection failed" . mysqli_connect_error());  
    }  
    else {  
mysqli_select_db($conn, 'shops');  
    }  
  
    //define total number of results you want per page  
    $results_per_page = 6;  
  
    //find the total number of results stored in the database  
    $query = "select *from items";  
    $result = mysqli_query($conn, $query);  
    $number_of_result = mysqli_num_rows($result);  
  
    //determine the total number of pages available  
    $number_of_page = ceil ($number_of_result / $results_per_page);  
  
    //determine which page number visitor is currently on  
    if (!isset ($_GET['page']) ) {  
        $page = 1;  
    } else {  
        $page = $_GET['page'];  
    }  
  
    //determine the sql LIMIT starting number for the results on the displaying page  
    $page_first_result = ($page-1) * $results_per_page;  
  
    //retrieve the selected results from database   
    $query = "SELECT *FROM items LIMIT " . $page_first_result . ',' . $results_per_page;  
    $result = mysqli_query($conn, $query);  
      
    //display the retrieved result on the webpage
    ?><div class="container">
        <div class="row"><?php
    while ($row = mysqli_fetch_array($result)) {  
        echo '<div class="col-sm-6 col-md-4">';
            echo '<div class="thumbnail">';
             echo '<span>'.$row['price'].'</span>';
             if(empty($row['image'])){echo '<img src="layout/images/img.png">';}else{
            echo'<img src="uploades/'. $row['image'].'" class="img-responsive img-thumbnail center-block imgshow">';}
            echo '<div class="caption">';
            echo '<h3><a href="item.php?itemid='.$row['itemID'].'">'.$row['name'].'</a><h3>';
            echo '<p>' .$row['description'].'<p>';
             echo '<div class="date">' .$row['date'].'</div>';
             echo '</div>';
            echo '</div>';
            echo '</div>'; 
    }  
  
  
    //display the link of the pages in URL  
    for($page = 1; $page<= $number_of_page; $page++) {  
        echo '<a href = "pagination.php?page=' . $page . '" style="background:#f00;width:36px;display:inline-block; margin-right:5px;margin-top:50px;text-align:center;height:27px" >' . $page . ' </a>';  
    }  
  
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

</body>  
</html>  