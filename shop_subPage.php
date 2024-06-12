


<script>
var set_city_id='<?php echo $_GET['city_id'];?>';

function call_page(set_city)
{
  var new_url="search=yes";//used it in front of index.php
  
  if(set_city!=null)set_city_id=set_city;
	var city_id=set_city_id	;
	//alert(city_id);
	if(city_id!="" && city_id!=null && city_id!==undefined)new_url+="&city_id="+city_id;
	
	var villa_area = "";
	$('input[name="villa_area"]:checked').each(function() {
      villa_area+=$(this).val()+",";
  });
  villa_area=villa_area.replace(/^,|,$/g, '');
	//alert(villa_area);
	if(villa_area!="" && villa_area!=null && villa_area!==undefined)new_url+="&villa_area="+villa_area;
	
	

  
  var minPrice = $('#rangeInputmin').val();
  if(minPrice!="" && minPrice!=null && minPrice!==undefined)new_url+="&minPrice="+minPrice;
  
  
  var maxPrice = $('#rangeInputmax').val();
  if(maxPrice!="" && maxPrice!=null && maxPrice!==undefined)new_url+="&maxPrice="+maxPrice;
  
  
  var villa_title = $('#villa_title').val();
  if(villa_title!="" && villa_title!=null && villa_title!==undefined)new_url+="&villa_title="+villa_title;
  
  var villa_order_view = $('#villa_order_view').val();
  if(villa_order_view!="" && villa_order_view!=null && villa_order_view!==undefined)new_url+="&villa_order_view="+villa_order_view;
  
  
  //alert(new_url);

	$.ajax({
		type:"POST",
		url:"shop_subPage_AJAX.php?"+new_url,
		data:{},
		contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    	processData: false, // NEEDED, DON'T OMIT THIS
		success: function(response) {
      $("#div_area_show_item").html(response);
	 	}
	});

  
}

</script>

<script>
function handleKeyPress(event) {
  // Check if the pressed key is Enter (key code 13)
  if (event.keyCode === 13) {
    // Execute your function here, for example:
    call_page(null);
  }
}

</script>






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

<div class="container-fluid villa py-0">
    <div class="container py-5" dir="rtl">
        <div class="tab-class text-center">
             <div class="row g-4">

                <div class="col-lg-12 text-end">
                    <ul class="nav nav-pills d-inline-flex text-center mb-5" dir="rtl">
                        <li class="nav-item" onclick="call_page('all');">
                            <a class="d-flex m-2 py-2 bg-light rounded-pill <?php if(empty($city_id))echo "active";?>" data-bs-toggle="pill" >
                                <span class="text-dark" style="width: 130px;">كل المدن</span>
                            </a>
                        </li>
                        <?php
                        $sql="SELECT * FROM city WHERE 1 AND delete_area=0 ORDER BY sort ASC";
                        //echo $sql;
                        $query = mysqli_query($connect, $sql);
                        while ($row = mysqli_fetch_array($query)) 
                        {
                        ?>
                        <li class="nav-item" onclick="call_page(<?php echo $row['id'];?>);">
                            <a class="d-flex py-2 m-2 bg-light rounded-pill <?php if($city_id==$row['id'])echo "active";?>" data-bs-toggle="pill">
                                <span class="text-dark" style="width: 130px;"><?php echo $row['name'];?></span>
                            </a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-xl-9">
                        <div class="input-group w-100 mx-auto d-flex" dir="rtl">
                            <input type="search" class="form-control p-3" placeholder="بحث عن فيلا" aria-describedby="search-icon-1" style="border-radius:0 10px 10px 0 !important;" id="villa_title" onkeyup="handleKeyPress(event)" value="<?php echo htmlspecialchars($villa_title);?>" >
                            <span id="search-icon-1" class="input-group-text p-3" style="border-radius:10px 0px 0px 10px !important;"><i class="fa fa-search"></i></span>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="bg-light pe-3 py-3 rounded d-flex justify-content-between mb-4">
                            <label for="villa_order_view">ترتيب العرض:</label>
                            <select id="villa_order_view" onchange="call_page(null);" class="border-0 form-select-sm bg-light ms-3" >
                                <option value="max_id" <?php if($villa_order_view=="max_id")echo "selected";?>>الاحدث</option>
                                <option value="min_id" <?php if($villa_order_view=="min_id")echo "selected";?>>الاقدم</option>
                                <option value="max_price" <?php if($villa_order_view=="max_price")echo "selected";?>>اعلى سعر</option>
                                <option value="min_price" <?php if($villa_order_view=="min_price")echo "selected";?>>اقل سعر</option>
                                
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3">
                        <div class="row g-4">
                          <div class="col-lg-12">
                                <a href="index.php?search=yes" style="float:center;"  class="btn btn-primary border-2 border-secondary py-2 px-3 rounded-pill text-white m-6">
                                  <span class="">إلغاء البحث</span> 
                                </a>
                                <br>
                          </div>
            
                            <div class="col-lg-12">
                                <div class="mb-3" >
                                    <h4>المساحة</h4>
                                        <div class="form-check text-start" >
                                            <input type="checkbox" class="form-check-input bg-primary border-0" id="villa_area1" name="villa_area" value="1" style="float:right;" onclick="call_page(null);" <?php if(strpos($_GET['villa_area'], "1") !== false)echo "checked";?> >
                                            <label class="form-check-label" for="villa_area1" style="float:right;margin-right:20px;">كبير</label>
                                        </div>
                                        <div class="form-check text-start" >
                                            <input type="checkbox" class="form-check-input bg-primary border-0" id="villa_area2" name="villa_area" value="2" style="float:right;" onclick="call_page(null);" <?php if(strpos($_GET['villa_area'], "2") !== false)echo "checked";?> >
                                            <label class="form-check-label" for="villa_area2" style="float:right;margin-right:20px;">متوسط</label>
                                        </div>
                                        <div class="form-check text-start" >
                                            <input type="checkbox" class="form-check-input bg-primary border-0" id="villa_area3" name="villa_area" value="3" style="float:right;" onclick="call_page(null);" <?php if(strpos($_GET['villa_area'], "3") !== false)echo "checked";?> >
                                            <label class="form-check-label" for="villa_area3" style="float:right;margin-right:20px;">صغير</label>
                                        </div>
                                        
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3" >
                                    <h4 class="mb-2">من سعر</h4>
                                    <input type="range" id="rangeInputmin" name="rangeInputmin" min="0" max="10000"  value="<?php echo $minPrice;?>" oninput="amountmin.value=rangeInputmin.value" onchange="call_page(null);" style="color:#85B6C2;" >
                                    <output id="amountmin" name="amountmin" for="rangeInputmin"><?php echo $minPrice;?></output>
                                </div>
                                <div class="mb-3" >
                                    <h4 class="mb-2">الى سعر</h4>
                                    <input type="range" id="rangeInputmax" name="rangeInputmax" min="0" max="10000" value="<?php echo $maxPrice;?>" oninput="amountmax.value=rangeInputmax.value" onchange="call_page(null);" style="color:#85B6C2;" >
                                    <output id="amountmax" name="amountmax" for="rangeInputmax"><?php echo $maxPrice;?></output>
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            
                        </div>
                    </div>
                    <div class="col-lg-9">

                        <div id="div_area_show_item" class="row g-4 justify-content-center">
                        <?php include "shop_subPage_AJAX.php";?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>

  .img-villa {
      width: 300px !important; /* Set your desired fixed width */
  }

  .villa-item {
      border: 1px solid #ccc; /* Set border properties as needed */
  }

</style>





