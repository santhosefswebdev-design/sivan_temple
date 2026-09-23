<?php 
if($view == true){
    $readonly = 'readonly';
}
?>
<style>
      .itemcountrr .value-button {
display: inline-block;
    border: 1px solid #ddd;
    margin: 0px;
    width: 25px;
    height: 25px;
    text-align: center;
    vertical-align: middle;
    padding: 0px 0px 8px 0px;
    background: #eee;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.itemcountrr .value-button:hover {
  cursor: pointer;
}

.itemcountrr #decrease {
  margin-right: 0px;
  border-radius: 4px 0 0 4px;
  margin-top:-2px;
}

.itemcountrr #increase {
  margin-left: 0px;
  border-radius: 0 4px 4px 0;
  margin-top:-2px;
}

.itemcountrr #input-wrap {
  margin: 0px;
  padding: 0px;
}

.itemcountrr input.number {
    text-align: center;
    border: none;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    margin: 0px;
    width: 35px;
    height: 25px;
}

.itemcountrr input[type=number]::-webkit-inner-spin-button,
.itemcountrr input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}


.addon_itemcountrr .value-button {
display: inline-block;
    border: 1px solid #ddd;
    margin: 0px;
    width: 25px;
    height: 25px;
    text-align: center;
    vertical-align: middle;
    padding: 0px 0px 8px 0px;
    background: #eee;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.addon_itemcountrr .value-button:hover {
  cursor: pointer;
}

.addon_itemcountrr #decrease {
  margin-right: 0px;
  border-radius: 4px 0 0 4px;
  margin-top:-2px;
}

.addon_itemcountrr #increase {
  margin-left: 0px;
  border-radius: 0 4px 4px 0;
  margin-top:-2px;
}

.addon_itemcountrr #input-wrap {
  margin: 0px;
  padding: 0px;
}

.addon_itemcountrr input.number {
    text-align: center;
    border: none;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    margin: 0px;
    width: 35px;
    height: 25px;
}

.addon_itemcountrr input[type=number]::-webkit-inner-spin-button,
.addon_itemcountrr input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}

<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>

</style>
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Annathanam<small>Booking / <b>Add Package </b></small></h2>
        </div>
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <div class="row">
                            <div class="col-md-8"><!--<h2>Hall</h2>--></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/annathanam_new/package"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div>
                        </div>
                    </div>
                    
                    <form action="<?php echo base_url(); ?>/annathanam_new/save_package" method="POST" enctype="multipart/form-data">
                        <div class="body">
                            <?php if(!empty($_SESSION['succ'])) { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="suc-alert">
                                        <span class="suc-closebtn"
                                            onclick="this.parentElement.style.display='none';">&times;</span>
                                        <p>
                                            <?php echo $_SESSION['succ']; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if(!empty($_SESSION['fail'])) { ?>
                                <div class="row" style="padding: 0 30%;" id="content_alert">
                                    <div class="alert">
                                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                                        <p>
                                            <?php echo $_SESSION['fail']; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                            <input type="hidden" name="id" value="<?php echo $data['id'];?>">
                            <div class="container-fluid">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <!-- <input type="text"  class="form-control" name="name" value="<?php echo $data['name_eng'];?>" <?php echo $readonly; ?>> -->
                                                <input type="text" class="form-control" name="name_eng" value="<?php echo !empty($data['name_eng']) ? $data['name_eng'] : ''; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Name in English <span style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <!-- <input type="text"  class="form-control" name="name" value="<?php echo $data['name_tamil'];?>" <?php echo $readonly; ?>> -->
                                                <input type="text" class="form-control" name="name_tamil" value="<?php echo !empty($data['name_tamil']) ? $data['name_tamil'] : ''; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Name in Tamil <span style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <!-- <input type="text"  class="form-control" name="description" value="<?php echo $data['description'];?>" <?php echo $readonly; ?>> -->
                                                <input type="text" class="form-control" name="description" value="<?php echo !empty($data['description']) ? $data['description'] : ''; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Description</label>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <select class="form-control search_box" data-live-search="true" data-live-search-style="startsWith" name="ledger_id" id="ledger_id">
                                                <option value="">Select Ledger</option>
                                                <?php
                                                if(!empty($ledgers))
                                                {
                                                    foreach($ledgers as $ledger)
                                                    {
                                                ?>
                                                    <option value="<?php echo $ledger["id"]; ?>"<?php if(!empty($data['ledger_id'])){ if($data['ledger_id'] == $ledger["id"]){ echo "selected"; }} ?>><?php echo $ledger['left_code'] . '/' . $ledger['right_code'] . " - ".$ledger["name"]; ?> </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <!-- <input type="text"  class="form-control" name="amount" value="<?php echo $data['amount'];?>" <?php echo $readonly; ?>> -->
                                                <input type="text" class="form-control" name="amount" value="<?php echo !empty($data['amount']) ? $data['amount'] : ''; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Amount</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-2">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="veg_count" value="<?php echo !empty($data['veg_count']) ? $data['veg_count'] : ''; ?>" <?php echo $readonly; ?>>
                                                <label class="form-label">Vegetable Count <span style="color: red;"> *</span></label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <select class="form-control" name="status" <?php echo $readonly; ?>>
                                                    <option>-- Select Status --</option>
                                                    <!-- <option value="1" <?php if($data['status'] == '1'){ echo "selected"; } ?>>Active</option>
                                                    <option value="2" <?php if($data['status'] == '2'){ echo "selected"; } ?>>Inactive</option> -->
                                                    <option value="1" <?php if(!empty($data['status']) && $data['status'] == '1'){ echo "selected"; } ?>>Active</option>
                                                    <option value="2" <?php if(!empty($data['status']) && $data['status'] == '2'){ echo "selected"; } ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                    <?php if ($view != true) { ?>
                                    <div class="col-sm-4">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label" style="display: contents;">Image</label>
                                                <input type="file" id="imgInp" name="package_image" accept="image/png,image/jpeg,image/jpg"
                                                    class="form-control" <?php echo $readonly; ?>>
                                                <!--<label class="form-label">Image</label>-->
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                        <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="">
                                                    <?php if (!empty ($data['image'])) { ?>
                                                        <a target="_blank" href="<?php echo base_url(); ?>/uploads/package/<?php echo $data['image']; ?>">
                                                            <img id="img_pre" src="<?php echo base_url(); ?>/uploads/package/<?php echo $data['image']; ?>"
                                                                width="200" height="160"></img>
                                                        </a>
                                                    <?php } else { ?>
                                                        <!--<a id="img_anchor" target="_blank" href="#"> -->
                                                        <img id="img_pre" src="#" width="200" height="160"></img>
                                                        <!--</a>  -->
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <br>
                                </div><br>
                                <hr>
                                <h3>Annathanam Items<small><b></b></small></h3>
                                <?php if($view != true) { ?>  
                                    <div class="row clearfix">
                                        <div class="col-sm-5">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" id="annathanamDropdown">
                                                        <option value="">-- Select Service --</option>
                                                        <?php if(!empty($annathanam_items) && is_array($annathanam_items)) { ?>
                                                            <?php foreach($annathanam_items as $item) { ?>
                                                                <option value="<?php echo $item['id']; ?>"><?php echo $item['name_eng']." / ".$item['name_tamil']; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2" align="left">
                                            <div class="form-group form-float">
                                                <a class="btn btn-info" id="add_annathanam_item" onclick="addAnnathanamItem()">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- <div class="row" style="">
                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table" id="annathanam_items_table" style="background: #fff; border: none; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th width="85%">Service</th>
                                                        <th width="15%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($items)) { ?>
                                                        <?php foreach ($items as $item) { ?>
                                                            <?php if ($item['add_on'] == 0) { ?>
                                                                <tr id="itemRow<?php echo $item['id']; ?>">
                                                                    <td>
                                                                        <input type="hidden" name="pack_items[]" value='{"item_id":"<?php echo $item['item_id']; ?>","add_on":0}'>
                                                                        <?php echo $item['name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <a onclick="removeAnnathanamItem('itemRow<?php echo $item['id']; ?>')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tbody>

                                            </table>
                                        </div>
                                        <input type="hidden" id="pack_items" name="pack_items">
                                    </div>
                                </div> -->
                                <div class="row" style="">
                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table" id="annathanam_items_table" style="background: #fff; border: none; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th width="85%">Service</th>
                                                        <th width="15%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                            
                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" id="pack_items" name="pack_items">
                                    </div>
                                </div>

                                <br>
                                <h3>Annathanam Add-on Items<small><b></b></small></h3>
                                <?php if($view != true) { ?>
                                    <div class="row clearfix">
                                        <div class="col-sm-5">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control" id="annathanamAddonDropdown">
                                                        <option value="">-- Select Addon --</option>
                                                        <?php if(!empty($annathanam_addon_items) && is_array($annathanam_addon_items)) { ?>
                                                            <?php foreach($annathanam_addon_items as $item) { ?>
                                                                <option value="<?php echo $item['id']; ?>"><?php echo $item['name_eng']." / ".$item['name_tamil']; ?></option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2" align="left">
                                            <div class="form-group form-float">
                                                <a class="btn btn-info" id="add_annathanam_addon" onclick="addAnnathanamAddonItem()">Add</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!-- <div class="row" style="">
                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table" id="annathanam_addon_items_table" style="background: #fff; border: none; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th width="85%">Addon</th>
                                                        <th width="15%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($items)) { ?>
                                                        <?php foreach ($items as $item) { ?>
                                                            <?php if ($item['add_on'] == 1) { ?>
                                                                <tr id="addonItemRow<?php echo $item['id']; ?>">
                                                                    <td>
                                                                        <input type="hidden" name="addon_pack_items[]" value='{"item_id":"<?php echo $item['item_id']; ?>","add_on":1}'>
                                                                        <?php echo $item['name']; ?>
                                                                    </td>
                                                                    <td>
                                                                        <a onclick="removeAnnathanamAddonItem('addonItemRow<?php echo $item['id']; ?>')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </tbody>

                                            </table>
                                        </div>
                                        <input type="hidden" id="addon_pack_items" name="addon_pack_items">
                                    </div>
                                </div> -->
                                <div class="row" style="">
                                    <div class="col-sm-6">
                                        <div class="table-responsive">
                                            <table class="table" id="annathanam_addon_items_table" style="background: #fff; border: none; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th width="85%">Addon</th>
                                                        <th width="15%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                
                                                </tbody>
                                            </table>
                                        </div>
                                        <input type="hidden" id="addon_pack_items" name="addon_pack_items">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <?php if($view != true) { ?>
                        <div class="col-sm-12" align="center" style="background-color: white;padding-bottom: 1%;">
                            <button type="submit" onclick="validations()" class="btn btn-success btn-lg waves-effect">SAVE</button>
                            <button type="button" id="clear" class="btn btn-primary btn-lg waves-effect">CLEAR</button> 
                        </div>
                    <?php } ?>
                <div id="alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-body p-4">
                                <div class="text-center">
                                    <i class="dripicons-information h1 text-info"></i>
                                    <table>
                                        <tr><span id="spndeddelid"><b></b></span>&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-info my-3" data-dismiss="modal"> &times;</button></tr>
                                    </table>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
var itemCount = <?php echo !empty($items) ? count($items) : 0; ?>;
var addonItemCount = <?php echo !empty($items) ? count($items) : 0; ?>;

var items = <?php echo json_encode($items); ?>;
var annathanamItems = <?php echo json_encode($annathanam_items); ?>;
var annathanamAddonItems = <?php echo json_encode($annathanam_addon_items); ?>;

function getItemNameById(id, itemsArray) {
    for (var i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i].id == id) {
            return itemsArray[i].name;
        }
    }
    return null;
}

function isItemInTable(itemId, tableId) {
    var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var existingItemId = row.cells[0].getElementsByTagName('input')[0].value;
        if (JSON.parse(existingItemId).item_id == itemId) {
            return true;
        }
    }
    return false;
}

function getItemDetailsById(itemId, itemsArray) {
    for (var i = 0; i < itemsArray.length; i++) {
        if (itemsArray[i].id === itemId) {
            return itemsArray[i];
        }
    }
    return null; // Return null if item is not found
}

function addItemsToTable() {
    var itemsTable = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
    var addonItemsTable = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    
    items.forEach(function(item) {
        var row, cell1, cell2, itemName;
        if (item.add_on == 0) {
            var itemDetails = getItemDetailsById(item.item_id, annathanamItems);
            itemName = itemDetails.name_eng + ' / ' + itemDetails.name_tamil;
            row = itemsTable.insertRow();
            row.id = 'itemRow' + itemCount;

            cell1 = row.insertCell(0);
            cell2 = row.insertCell(1);

            cell1.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + item.item_id + '","add_on":0}\'>' + itemName;
            cell2.innerHTML = '<a onclick="removeAnnathanamItem(\'itemRow' + itemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

            itemCount++;
        } else if (item.add_on == 1) {
            var addonItemDetails = getItemDetailsById(item.item_id, annathanamAddonItems);
            itemName = addonItemDetails.name_eng + ' / ' + addonItemDetails.name_tamil;
            row = addonItemsTable.insertRow();
            row.id = 'addonItemRow' + addonItemCount;

            cell1 = row.insertCell(0);
            cell2 = row.insertCell(1);

            cell1.innerHTML = '<input type="hidden" name="addon_pack_items[]" value=\'{"item_id":"' + item.item_id + '","add_on":1}\'>' + itemName;
            cell2.innerHTML = '<a onclick="removeAnnathanamAddonItem(\'addonItemRow' + addonItemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

            addonItemCount++;
        }
    });
}


// Function to add items to the table
// function addItemsToTable() {
//     var itemsTable = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
//     var addonItemsTable = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    
//     items.forEach(function(item) {
//         var row, cell1, cell2, itemName;
//         if (item.add_on == 0) {
//             itemName = getItemNameById(item.item_id, annathanamItems);
//             row = itemsTable.insertRow();
//             row.id = 'itemRow' + itemCount;

//             cell1 = row.insertCell(0);
//             cell2 = row.insertCell(1);

//             cell1.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + item.item_id + '","add_on":0}\'>' + itemName;
//             cell2.innerHTML = '<a onclick="removeAnnathanamItem(\'itemRow' + itemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

//             itemCount++;
//         } else if (item.add_on == 1) {
//             itemName = getItemNameById(item.item_id, annathanamAddonItems);
//             row = addonItemsTable.insertRow();
//             row.id = 'addonItemRow' + addonItemCount;

//             cell1 = row.insertCell(0);
//             cell2 = row.insertCell(1);

//             cell1.innerHTML = '<input type="hidden" name="addon_pack_items[]" value=\'{"item_id":"' + item.item_id + '","add_on":1}\'>' + itemName;
//             cell2.innerHTML = '<a onclick="removeAnnathanamAddonItem(\'addonItemRow' + addonItemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

//             addonItemCount++;
//         }
//     });
// }

function addAnnathanamItem() {
    var select = document.getElementById('annathanamDropdown');
    var tableId = 'annathanam_items_table';
    var selectedItemId = select.options[select.selectedIndex].value;
    var selectedText = select.options[select.selectedIndex].text;

    if (selectedItemId !== "" && !isItemInTable(selectedItemId, tableId)) {
        var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        var row = table.insertRow();
        row.id = 'itemRow' + itemCount;

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);

        cell1.innerHTML = '<input type="hidden" name="pack_items[]" value=\'{"item_id":"' + selectedItemId + '","add_on":0}\'>' + selectedText;
        cell2.innerHTML = '<a onclick="removeAnnathanamItem(\'itemRow' + itemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

        itemCount++;
        updatePackItems();
        select.selectedIndex = 0;
    } else {
        alert("This item is already added.");
    }
}

function removeAnnathanamItem(rowId) {
    var row = document.getElementById(rowId);
    row.parentNode.removeChild(row);
    updatePackItems();
}

function updatePackItems() {
    var table = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
    var items = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var itemId = row.cells[0].getElementsByTagName('input')[0].value;
        items.push(JSON.parse(itemId));
    }
    document.getElementById('pack_items').value = JSON.stringify(items);
}

function addAnnathanamAddonItem() {
    var select = document.getElementById('annathanamAddonDropdown');
    var tableId = 'annathanam_addon_items_table';
    var selectedItemId = select.options[select.selectedIndex].value;
    var selectedText = select.options[select.selectedIndex].text;

    if (selectedItemId !== "" && !isItemInTable(selectedItemId, tableId)) {
        var table = document.getElementById(tableId).getElementsByTagName('tbody')[0];
        var row = table.insertRow();
        row.id = 'addonItemRow' + addonItemCount;

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);

        cell1.innerHTML = '<input type="hidden" name="addon_pack_items[]" value=\'{"item_id":"' + selectedItemId + '","add_on":1}\'>' + selectedText;
        cell2.innerHTML = '<a onclick="removeAnnathanamAddonItem(\'addonItemRow' + addonItemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

        addonItemCount++;
        updateAddonPackItems();
        select.selectedIndex = 0;
    } else {
        alert("This addon is already added.");
    }
}

function removeAnnathanamAddonItem(rowId) {
    var row = document.getElementById(rowId);
    row.parentNode.removeChild(row);
    updateAddonPackItems();
}

function updateAddonPackItems() {
    var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
    var items = [];
    for (var i = 0, row; row = table.rows[i]; i++) {
        var itemId = row.cells[0].getElementsByTagName('input')[0].value;
        items.push(JSON.parse(itemId));
    }
    document.getElementById('addon_pack_items').value = JSON.stringify(items);
}

// Initialize pack_items and addon_pack_items
document.addEventListener('DOMContentLoaded', function () {
    addItemsToTable();
    updatePackItems();
    updateAddonPackItems();
});


</script>

<!-- <script>
    var itemCount = 0;

    function addAnnathanamItem() {
        var select = document.getElementById('annathanamDropdown');
        var table = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
        var selectedItemId = select.options[select.selectedIndex].value;
        var selectedText = select.options[select.selectedIndex].text;

        if (selectedItemId !== "") {
            var row = table.insertRow();
            row.id = 'itemRow' + itemCount;

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);

            cell1.innerHTML = '<input type="hidden" name="annathanam_items[' + itemCount + '][id]" value="' + selectedItemId + '">' + selectedText;
            cell2.innerHTML = '<a onclick="removeAnnathanamItem(\'itemRow' + itemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

            itemCount++;
            updatePackItems();
            select.selectedIndex = 0;
        }
    }

    function removeAnnathanamItem(rowId) {
        var row = document.getElementById(rowId);
        row.parentNode.removeChild(row);
        updatePackItems();
    }

    function updatePackItems() {
        var table = document.getElementById('annathanam_items_table').getElementsByTagName('tbody')[0];
        var items = [];
        for (var i = 0, row; row = table.rows[i]; i++) {
            var itemId = row.cells[0].getElementsByTagName('input')[0].value;
            items.push({ item_id: itemId,  add_on: 0});
        }
        document.getElementById('pack_items').value = JSON.stringify(items);
    }
</script>

<script>
    var addonItemCount = 0;

    function addAnnathanamAddonItem() {
        var select = document.getElementById('annathanamAddonDropdown');
        var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
        var selectedItemId = select.options[select.selectedIndex].value;
        var selectedText = select.options[select.selectedIndex].text;

        if (selectedItemId !== "") {
            var row = table.insertRow();
            row.id = 'addonItemRow' + addonItemCount;

            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);

            cell1.innerHTML = '<input type="hidden" name="addon_items[' + addonItemCount + '][id]" value="' + selectedItemId + '">' + selectedText;
            cell2.innerHTML = '<a onclick="removeAnnathanamAddonItem(\'addonItemRow' + addonItemCount + '\')" style="color: red; font-weight: bold; cursor: pointer;"> X </a>';

            addonItemCount++;
            updateAddonPackItems();
            select.selectedIndex = 0;
        }
    }

    function removeAnnathanamAddonItem(rowId) {
        var row = document.getElementById(rowId);
        row.parentNode.removeChild(row);
        updateAddonPackItems();
    }

    function updateAddonPackItems() {
        var table = document.getElementById('annathanam_addon_items_table').getElementsByTagName('tbody')[0];
        var items = [];
        for (var i = 0, row; row = table.rows[i]; i++) {
            var itemId = row.cells[0].getElementsByTagName('input')[0].value;
            items.push({ item_id: itemId,  add_on: 1 });
        }
        document.getElementById('addon_pack_items').value = JSON.stringify(items);
    }
</script> -->



<!-- <script>
function addCommissionEntry() {
    var staffSelect = document.getElementById('staff_id');
    var staffName = staffSelect.options[staffSelect.selectedIndex].text;
    var staffId = staffSelect.value;
    var commission = document.getElementById('commission_amount').value;

    if (staffId === "" || commission === "") {
        alert("Please select a staff and enter the commission amount.");
        return;
    }

    var table = document.getElementById("commission_table").getElementsByTagName('tbody')[0];
    var newRow = table.insertRow(table.rows.length);

    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    var cell3 = newRow.insertCell(2);

    cell1.innerHTML = `<input type="hidden" name="staff_id[]" value="${staffId}">${staffName}`;
    cell2.innerHTML = `<input type="hidden" name="commission_amount[]" value="${commission}">${commission}`;
    cell3.innerHTML = '<button type="button" onclick="removeCommissionEntry(this)">Remove</button>';

    staffSelect.selectedIndex = 0; // Reset the dropdown after adding
    document.getElementById('commission_amount').value = ""; // Clear the input for the next entry
}

function removeCommissionEntry(elem) {
    var row = elem.parentNode.parentNode;
    row.parentNode.removeChild(row);
}
</script> -->

<script>
	$("#clear").click(function(){
	   $("input").val("");
	});
</script>


<script>
// Initialize rowCounter based on the existing number of rows
var rowCounter = parseInt($("#package_service_row_count").val()) || 0;

$("#add_pack").click(function () {
    var service_id = $("#service_id").val();
    var service_id_text = $("#service_id option:selected").text();
    var quantity = parseInt($("#quantity").val());

    if (service_id != '' && !isNaN(quantity) && quantity > 0) {
        var existingRow = null;

        // Check if the service already exists in the table
        $("#package_services_table tbody tr").each(function() {
            var existingServiceId = $(this).find('input[name*="[service_id]"]').val();
            if (existingServiceId == service_id) {
                existingRow = $(this);
                return false; // break the loop
            }
        });

        if (existingRow) {
            var quantityInput = existingRow.find('input[name*="[quantity]"]');
            var currentQuantity = parseInt(quantityInput.val()) || 0;
            quantityInput.val(currentQuantity + quantity);
            existingRow.find("td:eq(1)").html('<div class="itemcountrr"><div class="value-button" id="decrease" onclick="decreaseValue(' + existingRow.attr('id').replace('rmv_packservrow', '') + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="services[' + existingRow.attr('id').replace('rmv_packservrow', '') + '][quantity]" min="1" id="quantity' + existingRow.attr('id').replace('rmv_packservrow', '') + '" value="' + (currentQuantity + quantity) + '" class="quantity-input" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="qtykeyup(' + existingRow.attr('id').replace('rmv_packservrow', '') + ')" /><div class="value-button" id="increase" onclick="increaseValue(' + existingRow.attr('id').replace('rmv_packservrow', '') + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div>');
        } else {
            var html = '<tr id="rmv_packservrow' + rowCounter + '">';
            html += '<td width="75%"><input type="hidden" style="border: none;" readonly="" name="services[' + rowCounter + '][service_id]" value="' + service_id + '">' + service_id_text + '</td>';
            html += '<td width="10%"><div class="itemcountrr"><div class="value-button" id="decrease" onclick="decreaseValue(' + rowCounter + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="services[' + rowCounter + '][quantity]" min="1" id="quantity' + rowCounter + '" value="' + quantity + '" class="quantity-input" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="qtykeyup(' + rowCounter + ')" /><div class="value-button" id="increase" onclick="increaseValue(' + rowCounter + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div></td>';
            html += '<td style="width: 15%;"><a onclick="rmv_pack_serv(' + rowCounter + ')" style="color:red;font-weight:bold;cursor: pointer;"> X </a><input type="hidden" class="package_category" value="' + service_id + '"></td>';
            html += '</tr>';
            $("#package_services_table tbody").append(html);
            rowCounter++;
        }

        // Clear inputs after adding
        $("#service_id").val('');
        $("#quantity").val('');
        $("#service_id").selectpicker("refresh");

        sum_amount();
    } else {
        alert("Please select a service and enter a valid quantity.");
    }
});

function increaseValue(cnt) {
    var quantity = $("#quantity" + cnt);
    var currentVal = parseInt(quantity.val());
    if (!isNaN(currentVal)) {
        quantity.val(currentVal + 1);
        updateAmount(cnt);
    } else {
        quantity.val(1);
    }
    sum_amount();
}

function decreaseValue(cnt) {
    var quantity = $("#quantity" + cnt);
    var currentVal = parseInt(quantity.val());
    if (!isNaN(currentVal) && currentVal > 1) {
        quantity.val(currentVal - 1);
        updateAmount(cnt);
    } else {
        quantity.val(1);
    }
    sum_amount();
}

function qtykeyup(cnt) {
    var quantity = $("#quantity" + cnt);
    var currentVal = parseInt(quantity.val());
    if (!isNaN(currentVal) && currentVal >= 0) {
        updateAmount(cnt);
    } else {
        quantity.val(1);
    }
    sum_amount();
}



function rmv_pack_serv(id) {
    $("#rmv_packservrow" + id).remove();
    sum_amount();
}














var addon_rowCounter = parseInt($("#addon_package_service_row_count").val()) || 0;

$("#addon_add_pack").click(function () {
    var addon_service_id = $("#addon_service_id").val();
    var addon_service_id_text = $("#addon_service_id option:selected").text();
    var addon_quantity = parseInt($("#addon_quantity").val());

    if (addon_service_id != '' && !isNaN(addon_quantity) && addon_quantity > 0) {
        var addon_existingRow = null;

        // Check if the service already exists in the table
        $("#addon_package_services_table tbody tr").each(function() {
            var addon_existingServiceId = $(this).find('input[name*="[service_id]"]').val();
            if (addon_existingServiceId == addon_service_id) {
                addon_existingRow = $(this);
                return false; // break the loop
            }
        });

        if (addon_existingRow) {
            var addon_quantityInput = addon_existingRow.find('input[name*="[quantity]"]');
            var addon_currentQuantity = parseInt(addon_quantityInput.val()) || 0;
            addon_quantityInput.val(addon_currentQuantity + addon_quantity);
            addon_existingRow.find("td:eq(1)").html('<div class="addon_itemcountrr"><div class="value-button" id="addon_decrease" onclick="addon_decreaseValue(' + addon_existingRow.attr('id').replace('addon_rmv_packservrow', '') + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="addon_services[' + addon_existingRow.attr('id').replace('addon_rmv_packservrow', '') + '][quantity]" min="1" id="addon_quantity' + addon_existingRow.attr('id').replace('addon_rmv_packservrow', '') + '" value="' + (addon_currentQuantity + addon_quantity) + '" class="addon_quantity-input" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="addon_qtykeyup(' + addon_existingRow.attr('id').replace('addon_rmv_packservrow', '') + ')" /><div class="value-button" id="addon_increase" onclick="addon_increaseValue(' + addon_existingRow.attr('id').replace('addon_rmv_packservrow', '') + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div>');
        } else {
            var html = '<tr id="addon_rmv_packservrow' + addon_rowCounter + '">';
            html += '<td width="75%"><input type="hidden" style="border: none;" readonly="" name="addon_services[' + addon_rowCounter + '][service_id]" value="' + addon_service_id + '">' + addon_service_id_text + '</td>';
            html += '<td width="10%"><div class="addon_itemcountrr"><div class="value-button" id="addon_decrease" onclick="addon_decreaseValue(' + addon_rowCounter + ')" value="Decrease Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">-</div><input type="number" name="addon_services[' + addon_rowCounter + '][quantity]" min="1" id="addon_quantity' + addon_rowCounter + '" value="' + addon_quantity + '" class="addon_quantity-input" style="text-align: center;border: none;border-top: 1px solid #ddd;border-bottom: 1px solid #ddd;margin: 0px;width: 35px;height: 25px;" onkeyup="addon_qtykeyup(' + addon_rowCounter + ')" /><div class="value-button" id="addon_increase" onclick="addon_increaseValue(' + addon_rowCounter + ')" value="Increase Value" style="font-weight: bold;font-size: 16px; cursor: pointer;">+</div></div></td>';
            html += '<td style="width: 15%;"><a onclick="addon_rmv_pack_serv(' + addon_rowCounter + ')" style="color:red;font-weight:bold;cursor: pointer;"> X </a><input type="hidden" class="addon_package_category" value="' + addon_service_id + '"></td>';
            html += '</tr>';
            $("#addon_package_services_table tbody").append(html);
            addon_rowCounter++;
        }

        // Clear inputs after adding
        $("#addon_service_id").val('');
        $("#addon_quantity").val('');
        $("#addon_service_id").selectpicker("refresh");

        sum_amount();
    } else {
        alert("Please select a service and enter a valid quantity.");
    }
});

function addon_increaseValue(addon_cnt) {
    var addon_quantity = $("#addon_quantity" + addon_cnt);
    var addon_currentVal = parseInt(addon_quantity.val());
    if (!isNaN(addon_currentVal)) {
        addon_quantity.val(addon_currentVal + 1);
        updateAmount(addon_cnt);
    } else {
        addon_quantity.val(1);
    }
    sum_amount();
}

function addon_decreaseValue(addon_cnt) {
    var addon_quantity = $("#addon_quantity" + addon_cnt);
    var addon_currentVal = parseInt(addon_quantity.val());
    if (!isNaN(addon_currentVal) && addon_currentVal > 1) {
        addon_quantity.val(addon_currentVal - 1);
        updateAmount(addon_cnt);
    } else {
        addon_quantity.val(1);
    }
    sum_amount();
}

function addon_qtykeyup(addon_cnt) {
    var addon_quantity = $("#addon_quantity" + addon_cnt);
    var addon_currentVal = parseInt(addon_quantity.val());
    if (!isNaN(addon_currentVal) && addon_currentVal >= 0) {
        updateAmount(addon_cnt);
    } else {
        addon_quantity.val(1);
    }
    sum_amount();
}



function addon_rmv_pack_serv(id) {
    $("#addon_rmv_packservrow" + id).remove();
    sum_amount();
}


$('#package_type').on('change', function(){
    $('#package_services_table tbody').html('');
    $('#addon_package_services_table tbody').html('');
});
// $('#package_type').change(function(){
//     var val = $(this).val();
//     $("#service_id").html('<option>-- Select Service --</option>');
//     $("#service_id").selectpicker("refresh");
                     
//     $("#addon_service_id").html('<option>-- Select Addon Service --</option>');
//     $("#addon_service_id").selectpicker("refresh");
                     
//     $.ajax
//         ({
//             type:"POST",
//             url: "<?php echo base_url();?>/master/get_service",
//             data:{id: val},
// 			dataType: "json",
//             success:function(response)
// 			{
//                 console.log(response);
//                 if(response.row.length > 0 ){
//                     var html = '<option>-- Select Service --</option>';
//                     response.row.forEach(function(value, key){
//                         html += '<option value="' + value.id + '">' + value.name + '</option>';
//                     });
//                     console.log(html);
//                     $('#service_id').html(html);
//                     $("#service_id").selectpicker("refresh");

//                     var addon_html = '<option>-- Select Addon Service --</option>';
//                     response.addon_row.forEach(function(value, key){
//                         addon_html += '<option value="' + value.id + '">' + value.name + '</option>';
//                     });
//                     $('#addon_service_id').html(addon_html);
//                     $("#addon_service_id").selectpicker("refresh");
//                 }
               
                
//                 //$('#service_id').prop('selectedIndex',0);
//                 //$("#service_id").selectpicker("refresh");
// 			}
//         })
// });
</script>
<script>
    $(document).ready(function() {
    function populateServices(packageTypeId) {
        var val = packageTypeId;
        $("#service_id").html('<option>-- Select Service --</option>');
        $("#service_id").selectpicker("refresh");

        $("#addon_service_id").html('<option>-- Select Addon Service --</option>');
        $("#addon_service_id").selectpicker("refresh");

        $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>/master/get_service",
            data: { id: val },
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.row.length > 0) {
                    var html = '<option>-- Select Service --</option>';
                    response.row.forEach(function(value, key) {
                        html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    console.log(html);
                    $('#service_id').html(html);
                    $("#service_id").selectpicker("refresh");

                    var addon_html = '<option>-- Select Addon Service --</option>';
                    response.addon_row.forEach(function(value, key) {
                        addon_html += '<option value="' + value.id + '">' + value.name + '</option>';
                    });
                    $('#addon_service_id').html(addon_html);
                    $("#addon_service_id").selectpicker("refresh");
                }
            }
        });
    }

    $('#package_type').change(function() {
        var val = $(this).val();
        populateServices(val);
    });

    var initialPackageType = $('#package_type').val();
    if (initialPackageType) {
        populateServices(initialPackageType);
    }
});

</script>    
<script>
    function validations(){
        $.ajax
            ({
            type:"POST",
            url: "<?php echo base_url(); ?>/annathanam_new/validation",
            data: $("form").serialize(),
            success:function(data)
            {
                obj = jQuery.parseJSON(data);
                console.log(obj);
                if(obj.err != ''){
                    $('#alert-modal').modal('show', {backdrop: 'static'});
                    $("#spndeddelid").text(obj.err);
                }else{
                    $('input[type=submit]').prop('disabled', true);
                    $("#loader").show();
                    $("form").submit();
                }
            }
        })
            
    }
</script>