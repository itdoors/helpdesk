<div style="width:50%;float:left;display:inline-block;;">
<div class="history">
  <?php include_component('Fmodel', 'history',
    array(
      'model_id' => $department->getId(),
      'model_name' => History::MODEL_DEPARTMENTS
    )
  )?>
</div>


<table>
  <tr>
    <td width="100">MPK</td>
    <td><?php 
      echo 
      !$can_edit ? $department->getMpk() : 
      get_component('Fmodel','ajax_field_change',
      array(
        'where' => array(
          'id'=> $department->getId(),
        ),
        'model' => 'departments',
        'field' => 'mpk',
        'toString' =>'getMpk',
        'default' => $department->getMpk(),
        )
     )?></td>
  </tr>
  <tr>
    <td width="100"><?php echo __("Organization")?></td>
    <td><?php echo $department->getOrganization()?></td>
  </tr>
  <tr>
    <td width="100"><?php echo __("Region")?></td>
    <td><?php echo $department->getRegion()?></td>
  </tr>
  <tr>
    <td width="100"><?php echo __("City")?></td>
    <td><?php echo $department->getCity()?></td>
  </tr>
  <tr>
    <td width="100"><?php echo __("Address")?></td>
    <td><?php echo $department->getAddress() ?></td>
  </tr>
  <tr>
    <td width="100"><?php echo __("Status")?></td>
    <td><?php 
      echo 
      !$can_edit ? $department->getStatus() : 
      get_component('Fmodel','ajax_field_change',
      array(
        'where' => array(
          'id'=> $department->getId(),
        ),
        'model' => 'departments',
        'field' => 'status_id',
        'toString' =>'getStatusString',
        'default' => $department->getStatusString(),
        )
     )?></td>
  </tr>
  <tr>
    <td width="100"><?php echo __("Status date")?></td>
    <td><?php 
      echo 
      !$can_edit ? $department->getStatus() : 
      get_component('Fmodel','ajax_field_change',
      array(
        'where' => array(
          'id'=> $department->getId(),
        ),
        'model' => 'departments',
        'field' => 'status_date',
        'toString' =>'getStatusDate',
        'default' => $department->getStatusDate(),
        )
     )?></td>
  </tr>
  <tr>
    <td width="100"><?php echo __("Departments type")?></td>
    <td><?php 
      echo 
      !$can_edit ? $department->getDepartmentsType() : 
      get_component('Fmodel','ajax_field_change',
      array(
        'where' => array(
          'id'=> $department->getId(),
        ),
        'model' => 'departments',
        'field' => 'departments_type_id',
        'toString' =>'getDepartmentsType',
        'default' => $department->getDepartmentsType(),
        )
     )?></td>
  </tr>
  <tr>
    <td width="100"><?php echo __("Organization type")?></td>
    <td><?php echo $department->getOrganization() ? $department->getOrganization()->getOrganizationType() : ''?></td>
  </tr>
  
  <tr>
    <td width="100"><?php echo __("Description")?></td>
    <td><?php 
      echo 
      !$can_edit ? $department->getDescription() : 
      get_component('Fmodel','ajax_field_change',
      array(
        'where'=> array(
          'id'=> $department->getId(),
        ),
        'model' => 'departments',
        'field' => 'description',
        'toString' =>'getDescription',
        'default' => $department->getDescription(),
        )
     )?></td>
  </tr>
  <?php if ($sf_user->hasCredential('admin')) : ?>
    <tr>
      <td width="100"><?php echo __("Opermanager")?></td>
      <td><?php
        echo
        !$can_edit ? $department->getDescription() :
          get_component('Fmodel','ajax_field_change',
            array(
              'where'=> array(
                'id'=> $department->getId(),
              ),
              'model' => 'departments',
              'field' => 'opermanager_id',
              'toString' =>'getOpermanagerString',
              'default' => $department->getOpermanagerString(),
            )
          )?></td>
    </tr>
  <?php endif;?>

</table>

<?php include_partial('entity/show_general_organization_info', array('organization' => $department->getOrganization()))?>  

 </div>
 <div style="float:left;width:50%;display:inline-block;">

 <input type="text" id="coordinates" value="<?php echo $department->getCoordinates()?>"/> 
<?php if ($can_edit):?>
  <input  value="Сохранить" type="submit" id="save_coordinates" data-id="<?php echo $department->getId()?>" data-url="<?php echo url_for('ajaxdata/save_coordinates')?>"/> 
<?php endif;?>
<div id="save_status"></div>

<script type="text/javascript">
$('#save_coordinates').live('click', function (e){
  e.preventDefault();
  var self = $(this);
  var url = $(this).data('url');
  var id = $(this).data('id');
  var coordinates = $('#coordinates').val();
  $.ajax({
    url: url,
    type: 'POST',
    data: {
      id: id,
      coordinates: coordinates
    },
    beforeSend: function (){
      $('#save_status').html('Saving Coordinates...');
    },
    success: function ()
    {
      $('#save_status').html('Coordinates saved successfully ');
    }
  });
})
</script>

<script type="text/javascript">

var ddLatLng;

var GM;

var geocoder;

var map;

var GMMarker;

function codeAddress() {

        var address = document.getElementById("address1").value;

        geocoder.geocode( { "address": address}, function(results, status) {

          if (status == google.maps.GeocoderStatus.OK) {

            map.setCenter(results[0].geometry.location);

            GMMarker.setPosition(results[0].geometry.location);

            var new_location = results[0].geometry.location;
            //console.log(new_coordinates);
            var new_coordinates = new_location.jb + ',' + new_location.kb;
            
            document.getElementById("coordinates").value=new_coordinates;//Сохраняем значение в поле

          } else {

            alert("Geocode was not successful for the following reason: " + status);

          }

        });

      };

//Callback функция для GM

function initialize(){

  ddLatLng = document.getElementById("coordinates").value;//Координаты

  //Если координаты не заданны, то задаём дефолт

  if(ddLatLng == "") {ddLatLng = "50.450912,30.522637";document.getElementById("coordinates").value=ddLatLng;}

  ddLatLng = ddLatLng.split(",");

  geocoder = new google.maps.Geocoder();

    GM = google.maps;

    var myOptions = {

        zoom: 15,

        center: new GM.LatLng(ddLatLng[0],ddLatLng[1]),

        mapTypeId: GM.MapTypeId.ROADMAP,

        streetViewControl: false,

        scrollwheel: false

    };

    map = new GM.Map(document.getElementById("ddGMap"), myOptions);

    //Добавляем маркер на карту

    GMMarker = new GM.Marker({

        position: new GM.LatLng(ddLatLng[0],ddLatLng[1]),

        map: map,

        draggable: true

    });

    //При перетаскивании маркера

    GM.event.addListener(GMMarker, "drag", function(event){

        var position = event.latLng;//Координаты

        document.getElementById("coordinates").value=position.lat() + "," + position.lng();//Сохраняем значение в поле

    });

    //При клике на карте

    GM.event.addListener(map, "click", function(event){

        var position = event.latLng;//Новые координаты

        GMMarker.setPosition(position);//Меняем позицию маркера

        map.setCenter(position);//Центрируем карту на маркере

        document.getElementById("coordinates").value=position.lat() + "," + position.lng();//Сохраняем значение в поле

    });

   

};

 

</script>

 

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&callback=initialize"></script>

 

 

 

<input type="text" name="coordinates" value="" id="coordinates"  style="display:none;" />

 

<label for="address">Адреса: <span>введіть адресу, натисніть Знайти</label><br />

<input type="text" value="" name="address" id="address1" style="width:80%" />

<input type="button" value="Найти" onclick="codeAddress()" />

<div id="ddGMap" style="width:100%;height:400px;margin:7px;"></div>

<?php include_partial('entity/show_general_contacts', array('department' => $department, 'can_edit' => $can_edit))?>

</div>

    







