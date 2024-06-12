<?php
include "config.php";
?>

<?php
$minPrice=0;
$maxPrice=0;
if(!empty($_GET['villa_title']))
{ 
  $villa_title=mysqli_real_escape_string($connect, $_GET['villa_title']);
  $where_villa_title=" AND villas.title LIKE '%$villa_title%' ";
}
if(!empty($_GET['city_id']) && $_GET['city_id']!="all")
{
  $city_id=intval($_GET['city_id']);
  $where_city_id=" AND villas.city_id =$city_id ";
}
if(!empty($_GET['villa_area']))
{
  $villa_area=mysqli_real_escape_string($connect, $_GET['villa_area']);
  $where_villa_area=" AND villas.area IN ($villa_area) ";
}


if(!empty($_GET['minPrice']))
{
  $minPrice=round(floatval($_GET['minPrice']),2);
  $where_minPrice=" AND villas.price <= $minPrice ";
}
if(!empty($_GET['maxPrice']))
{
  $maxPrice=round(floatval($_GET['maxPrice']),2);
  $where_maxPrice=" AND villas.price >= $maxPrice ";
}

if(!empty($_GET['villa_order_view']))
{
  $villa_order_view=$_GET['villa_order_view'];
  if($_GET['villa_order_view']=="min_id")$orderBy=" ORDER BY villas.id ASC ";
  else if($_GET['villa_order_view']=="max_id")$orderBy=" ORDER BY villas.id DESC ";
  else if($_GET['villa_order_view']=="min_price")$orderBy=" ORDER BY villas.price ASC ";
  else if($_GET['villa_order_view']=="max_price")$orderBy=" ORDER BY villas.price DESC ";
  
}


?>



<style>
    .star {
        font-size: 27px;
        cursor: pointer;
        color: grey;
    }
    .star.checked {
        color: gold;
    }
</style>



<?php
$sql="SELECT 
            villas.*,
            city.name as city_name,
            concat(first_name,' ',family_name) AS user_name 
            FROM villas 
            LEFT JOIN city ON city.id=villas.city_id 
            LEFT JOIN users ON users.id=villas.by_user_id  
            WHERE 1 
            $where_villa_title
            $where_city_id
            $where_villa_area
            $where_minPrice
            $where_maxPrice
            AND villas.del=0 
            $orderBy
            ";
//echo $sql;
$query = mysqli_query($connect, $sql);
while($row = mysqli_fetch_array($query))
{
  
  $desc=mb_substr(trim($row['description'],'.'),0,77);
  $words = explode(' ',$desc); // Split the string into an array of words
  $last_word_index = count($words) - 1; // Get the index of the last word
  if(strlen(implode(' ', $words))>=77)
  {
    array_pop($words); // Remove the last word
  }
  $desc = implode(' ', $words); // Reconstruct the string
  if(strlen($desc)>77)
  {
    $desc="$desc ...";
  }
  
  
  
  $title=mb_substr(trim($row['title'],'.'),0,44);
  $words = explode(' ',$title); // Split the string into an array of words
  $last_word_index = count($words) - 1; // Get the index of the last word
  if(strlen(implode(' ', $words))>=44)
  {
    array_pop($words); // Remove the last word
  }
  $title = implode(' ', $words); // Reconstruct the string
  if(strlen($title)>44)
  {
    $title="$title ...";
  }


?>

                         
<div class="col-md-6 col-lg-6 col-xl-12">
    <div class="row rounded  villa-item d-flex flex-row "> <!-- Added border -->
        <div class="villa-img col-lg-5">
            <?php if(!empty($row['img'])): ?>
                <img src="DRIVE/<?php echo htmlspecialchars($row['img']); ?>" class="img-fluid mb-3 mt-3 rounded  img-villa" style="height:222px;" alt="<?php echo htmlspecialchars($title); ?>"> <!-- Added img-villa class -->
            <?php else: ?>
                <img src="assets/img/empty.png" class="img-fluid w-100 rounded-top  img-villa" style="height:222px;"  alt="No Image Available"> <!-- Added img-villa class -->
            <?php endif; ?>
            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"><?php echo htmlspecialchars($row['city_name']); ?></div>
        </div>
        <div class="col-lg-7 p-4  flex-grow-1" style="border-right:1px solid #bbb;">
            <h5><?php echo htmlspecialchars($title); ?></h5>
            <ul class="list-unstyled">
                <li><?php echo htmlspecialchars($desc); ?></li>
                <li><strong>السعر لليوم الواحد:</strong> <strong style="color:red;"><?php echo htmlspecialchars($row['price']); ?>₪</strong></li>
                <li></li>
            </ul>
            <div>
            التقييم: 
                <?php
                $sql="
                  SELECT AVG(renter_evaluation) as evaluation_rate  FROM `reservation_list` WHERE 1 AND villa_id=$row[id] 
                  ";
                //echo $sql;
                $q_rate = mysqli_query($connect, $sql);
                $r_rate = mysqli_fetch_array($q_rate);
                $evaluation_rate=$r_rate['evaluation_rate'];
                ?>
                <div style="margin-top:2px;"  dir="rtl">
                    <span class="star <?php if($evaluation_rate>=1)echo "checked";?>" onclick="set_evaluation(<?php echo $row['order_id'];?>,1);">★</span>
                    <span class="star <?php if($evaluation_rate>=2)echo "checked";?>" onclick="set_evaluation(<?php echo $row['order_id'];?>,2);">★</span>
                    <span class="star <?php if($evaluation_rate>=3)echo "checked";?>" onclick="set_evaluation(<?php echo $row['order_id'];?>,3);">★</span>
                    <span class="star <?php if($evaluation_rate>=4)echo "checked";?>" onclick="set_evaluation(<?php echo $row['order_id'];?>,4);">★</span>
                    <span class="star <?php if($evaluation_rate>=5)echo "checked";?>" onclick="set_evaluation(<?php echo $row['order_id'];?>,5);">★</span>
                </div>
            
            </div>
            <a href="villa_details.php?villa_id=<?php echo $row['id']; ?>" class="btn border border-secondary rounded-pill px-3 text-primary" style="float:left !important;"><i class="fa fa-laptop"></i> تفاصيل</a>
        </div>
    </div>
</div>


    
  <?php
  }
  ?>  
    


