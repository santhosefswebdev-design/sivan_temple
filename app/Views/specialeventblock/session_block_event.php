<?php $booking_calendar_range_year = booking_calendar_range_year($_SESSION['booking_range_year']); ?>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<style>
<?php 
if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>

.table-responsive{
        overflow-x: hidden;
    }
</style>

<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2> Templebooking <small>Temple Event / <b>Session block</b></small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"><!--<h2>Cash Donation</h2>--></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/sessionblock"><button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                        </div>
                        <form id="sessionblock_form" action="<?php echo base_url(); ?>/sessionblock/save" method="post">
                            <div class="body">
                                <input type="hidden" name="id" value="<?php echo $data['id'] ?? ''; ?>">
                                <div class="container-fluid">
                                    <div class="row clearfix">
                                        <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line focused">
                                                    <input type="date" name="sessionblock_date" id="sessionblock_date" class="form-control" value="<?php echo $data['date'] ?? ''; ?>" <?php echo $readonly; ?> required max="<?php echo $booking_calendar_range_year; ?>">
                                                    <label class="form-label">Event Date <span style="color: red;">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control show-tick" name="sessionblock_type" id="sessionblock_type" required>
                                                        <option value="">Select Event</option>
                                                        <option value="1" <?php echo (isset($data['event_type']) && $data['event_type'] == '1') ? 'selected' : ''; ?>>Hall Booking</option>
                                                        <option value="2" <?php echo (isset($data['event_type']) && $data['event_type'] == '2') ? 'selected' : ''; ?>>Ubayam</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($edit != true) { ?>
                                        <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="">
                                                <input type="checkbox" id="select_all_slots">
                                                    <label for="select_all_slots" class="form-label">ALL</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <div class="col-sm-4" id="slot_selection_container">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control search_box" name="slot_selection" id="slot_selection" required data-live-search="true">
                                                        <option value="0">Select Slot</option>
                                                        <?php if (isset($data)): ?>
                                                            <?php foreach($slot_details as $slot): ?>
                                                                <option class="slot-option" data-type="<?= $slot['slot_type']; ?>" value="<?= $slot['booking_slot_id']; ?>"
                                                                    <?= $data['booking_slot_id'] == $slot['booking_slot_id'] ? 'selected' : ''; ?>>
                                                                    <?= $slot['slot_name']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="all_slots_data" name="all_slots_data">
                                        <!-- <div class="col-sm-4">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <select class="form-control search_box" name="slot_selection" id="slot_selection" required data-live-search="true">
                                                        <option value="0">Select Slot</option>
                                                        <?php if (isset($data)): ?>
                                                            <?php foreach($slot_details as $slot): ?>
                                                                <option class="slot-option" data-type="<?= $slot['slot_type']; ?>" value="<?= $slot['booking_slot_id']; ?>"
                                                                    <?= $data['booking_slot_id'] == $slot['booking_slot_id'] ? 'selected' : ''; ?>>
                                                                    <?= $slot['slot_name']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-sm-6">
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input class="form-control" name="sessionblock_desc" id="sessionblock_desc"><?php echo $data['description'] ?? ''; ?></input>
                                                    <label class="form-label">Description</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($view != true) { ?>
                                            <div class="col-sm-12" align="center">
                                                <button type="submit" id="submit_all" class="btn btn-success btn-lg waves-effect">SAVE</button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

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
            </div><!-- /.modal-content -->
        </div>
    </div>
    </section>
    <link href="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>/assets/plugins/bootstrap-select/js/bootstrap-select.js"></script>


<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        var selectedEventType = document.getElementById('sessionblock_type').value;
        updateSlots(); 

        document.getElementById('sessionblock_type').addEventListener('change', updateSlots);
        document.getElementById('select_all_slots').addEventListener('change', handleAllCheckboxChange);
    });

    function updateSlots() {
        var selectedEventType = document.getElementById('sessionblock_type').value;
        var slotSelect = document.getElementById('slot_selection');
        var allCheckbox = document.getElementById('select_all_slots');
        
        if (allCheckbox.checked) {
            slotSelect.disabled = true;
            document.getElementById('slot_selection_container').style.display = 'none';
            gatherAllSlotsData(selectedEventType);
        } else {
            slotSelect.disabled = false;
            document.getElementById('slot_selection_container').style.display = 'block';
            
            $(slotSelect).empty().append('<option value="0">Select Slot</option>');

            var slots = <?php echo json_encode($slot_details); ?>;
            slots.forEach(function(slot) {
                if (selectedEventType === "" || slot.slot_type === selectedEventType) {
                    var isSelected = <?php echo json_encode($data['booking_slot_id'] ?? ''); ?> == slot.booking_slot_id;
                    var option = new Option(slot.slot_name, slot.booking_slot_id, isSelected, isSelected);
                    $(slotSelect).append(option);
                }
            });
    
            $(slotSelect).selectpicker('refresh');
        }
    }

    function handleAllCheckboxChange() {
        updateSlots();
    }

    function gatherAllSlotsData(selectedEventType) {
        var slots = <?php echo json_encode($slot_details); ?>;
        var allSlotsData = [];

        slots.forEach(function(slot) {
            if (slot.slot_type === selectedEventType) {
                allSlotsData.push({
                    date: slot.date,
                    event_type: selectedEventType,
                    booking_slot_id: slot.booking_slot_id,
                    description: slot.description
                });
            }
        });

        document.getElementById('all_slots_data').value = JSON.stringify(allSlotsData);
    }
</script> -->








<script>
    document.addEventListener('DOMContentLoaded', function() {
        updateSlotsEdit(); 
        
        document.getElementById('sessionblock_type').addEventListener('change', updateSlots);
        document.getElementById('select_all_slots').addEventListener('change', handleAllCheckboxChange);
    });

    function updateSlots() {
        var selectedEventType = document.getElementById('sessionblock_type').value;
        var slotSelect = document.getElementById('slot_selection');
        var allCheckbox = document.getElementById('select_all_slots');
        
        if (allCheckbox.checked) {
            slotSelect.disabled = true;
            document.getElementById('slot_selection_container').style.display = 'none';
            gatherAllSlotsData(selectedEventType);
        } else {
            slotSelect.disabled = false;
            document.getElementById('slot_selection_container').style.display = 'block';
            
            $(slotSelect).empty().append('<option value="0">Select Slot</option>');
    
            var slots = <?php echo json_encode($slot_details); ?>;
            slots.forEach(function(slot) {
                if (selectedEventType === "" || slot.slot_type === selectedEventType) {
                    var isSelected = <?php echo json_encode($data['booking_slot_id'] ?? ''); ?> == slot.booking_slot_id;
                    var option = new Option(slot.slot_name, slot.booking_slot_id, isSelected, isSelected);
                    $(slotSelect).append(option);
                }
            });
    
            $(slotSelect).selectpicker('refresh');
        }
    }

    function updateSlotsEdit() {
        var selectedEventType = document.getElementById('sessionblock_type').value;
        var slotSelect = document.getElementById('slot_selection');

        $(slotSelect).empty().append('<option value="0">Select Slot</option>');

        var slots = <?php echo json_encode($slot_details); ?>;
        slots.forEach(function(slot) {
            if (selectedEventType === "" || slot.slot_type === selectedEventType) {
                var isSelected = <?php echo json_encode($data['booking_slot_id'] ?? ''); ?> == slot.booking_slot_id;
                var option = new Option(slot.slot_name, slot.booking_slot_id, isSelected, isSelected);
                $(slotSelect).append(option);
            }
        });

        $(slotSelect).selectpicker('refresh');
    }

    function handleAllCheckboxChange() {
        updateSlots();
    }

    function gatherAllSlotsData(selectedEventType) {
        var slots = <?php echo json_encode($slot_details); ?>;
        var allSlotsData = [];

        slots.forEach(function(slot) {
            if (slot.slot_type === selectedEventType) {
                allSlotsData.push({
                    date: slot.date,
                    event_type: selectedEventType,
                    booking_slot_id: slot.booking_slot_id,
                    description: slot.description
                });
            }
        });
        document.getElementById('all_slots_data').value = JSON.stringify(allSlotsData);
    }
</script>








<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        updateSlotsEdit(); 
        
        document.getElementById('sessionblock_type').addEventListener('change', updateSlots);
        document.getElementById('select_all_slots').addEventListener('change', handleAllCheckboxChange);
    });

    function updateSlots() {
        var selectedEventType = document.getElementById('sessionblock_type').value;
        var slotSelect = document.getElementById('slot_selection');
        var allCheckbox = document.getElementById('select_all_slots');
        
        if (allCheckbox.checked) {
            slotSelect.disabled = true;
            document.getElementById('slot_selection_container').style.display = 'none';
            gatherAllSlotsData(selectedEventType);
        } else {
            slotSelect.disabled = false;
            document.getElementById('slot_selection_container').style.display = 'block';
            
            $(slotSelect).empty().append('<option value="0">Select Slot</option>');
    
            var slots = <?php echo json_encode($slot_details); ?>;
            slots.forEach(function(slot) {
                if (selectedEventType === "" || slot.slot_type === selectedEventType) {
                    var isSelected = <?php echo json_encode($data['booking_slot_id'] ?? ''); ?> == slot.booking_slot_id;
                    var option = new Option(slot.slot_name, slot.booking_slot_id, isSelected, isSelected);
                    $(slotSelect).append(option);
                }
            });
    
            $(slotSelect).selectpicker('refresh');
        }
    }

        function updateSlotsEdit() {
            var selectedEventType = document.getElementById('sessionblock_type').value;
            var slotSelect = document.getElementById('slot_selection');

            $(slotSelect).empty().append('<option value="0">Select Slot</option>');

            var slots = <?php echo json_encode($slot_details); ?>;
            slots.forEach(function(slot) {
                if (selectedEventType === "" || slot.slot_type === selectedEventType) {
                    var isSelected = <?php echo json_encode($data['booking_slot_id'] ?? ''); ?> == slot.booking_slot_id;
                    var option = new Option(slot.slot_name, slot.booking_slot_id, isSelected, isSelected);
                    $(slotSelect).append(option);
                }
            });

            $(slotSelect).selectpicker('refresh');
        }

    function handleAllCheckboxChange() {
        updateSlots();
    }

    // function handleAllCheckboxChange() {
    //     var selectedEventType = document.getElementById('sessionblock_type').value;
    //     var selectAllCheckbox = document.getElementById('select_all_slots');
    //     var slotSelectionContainer = document.getElementById('slot_selection_container');

    //     if (selectAllCheckbox.checked) {
    //         slotSelectionContainer.style.display = 'none';
    //         gatherAllSlotsData(selectedEventType);
    //     } else {
    //         slotSelectionContainer.style.display = 'block';
    //         updateSlots();
    //     }
        
    // }

    function gatherAllSlotsData(selectedEventType) {
        var slots = <?php echo json_encode($slot_details); ?>;
        var allSlotsData = [];

        slots.forEach(function(slot) {
            if (slot.slot_type === selectedEventType) {
                allSlotsData.push({
                    date: slot.date,
                    event_type: selectedEventType,
                    booking_slot_id: slot.booking_slot_id,
                    description: slot.description
                });
            }
        });
        document.getElementById('all_slots_data').value = JSON.stringify(allSlotsData);
    }
</script> -->







<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        updateSlots(); 

        document.getElementById('sessionblock_type').addEventListener('change', updateSlots);
    });

    function updateSlots() {
        var selectedEventType = document.getElementById('sessionblock_type').value;
        var slotSelect = document.getElementById('slot_selection');

        $(slotSelect).empty().append('<option value="0">Select Slot</option>');

        var slots = <?php echo json_encode($slot_details); ?>;
        slots.forEach(function(slot) {
            if (selectedEventType === "" || slot.slot_type === selectedEventType) {
                var isSelected = <?php echo json_encode($data['booking_slot_id'] ?? ''); ?> == slot.booking_slot_id;
                var option = new Option(slot.slot_name, slot.booking_slot_id, isSelected, isSelected);
                $(slotSelect).append(option);
            }
        });

        $(slotSelect).selectpicker('refresh');
    }
</script> -->








<!-- <script>
document.getElementById('sessionblock_type').addEventListener('change', function() {
    var selectedEventType = this.value;
    var slotSelect = document.getElementById('slot_selection');

    $(slotSelect).val('0').selectpicker('refresh');
    $(slotSelect).data('selectpicker').$newElement.off('loaded.bs.select');

    $(slotSelect).find('.slot-option').each(function() {
        var optionType = $(this).data('type').toString();
        if (selectedEventType === "" || optionType === selectedEventType) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
    $(slotSelect).selectpicker('refresh');
    $(slotSelect).data('selectpicker').$newElement.on('loaded.bs.select', function () {
    });
});
</script> -->


<!-- <script>
$(document).ready(function() {
    var slot_details = <?php echo json_encode($slot_details); ?>;
    var initialSlotId = "<?php echo $data['booking_slot_id'] ?? ''; ?>";
    var initialType = "<?php echo $data['event_type'] ?? ''; ?>";
    console.log("Slot Details:", slot_details);
    console.log("Initial Slot ID:", initialSlotId);
    console.log("Initial Type:", initialType);

    function populateSlots(selectedType, selectedSlotId) {
        var filteredSlots = slot_details.filter(slot => slot.slot_type === selectedType);
        $('#slot_name').empty();
        $('#slot_name').append('<option value="">Select Slot</option>');

        filteredSlots.forEach(function(slot) {
            var isSelected = (slot.booking_slot_id === selectedSlotId) ? ' selected="selected"' : '';
            $('#slot_name').append($('<option' + isSelected + '>', { 
                value: slot.booking_slot_id,
                text: slot.slot_name 
            }));
        });
        $('#slot_name').selectpicker('refresh');

        var selectedText = $('#slot_name').find('option:selected').text();
        $('#slot_name').selectpicker('val', selectedText); // Updates visible part
    }

    $('#sessionblock_type').change(function() {
        populateSlots($(this).val(), '');
    });

    if (initialSlotId && initialType) {
        populateSlots(initialType, initialSlotId);
    } else if (initialType) {
        // Ensure the slot list is populated even if there is no initial slot id selected
        populateSlots(initialType, '');
    }
});
</script> -->



<!-- <script>
$(document).ready(function() {
    var slot_details = <?php echo json_encode($slot_details); ?>;
    var initialSlotId = "<?php echo $data['booking_slot_id'] ?? ''; ?>";
    var initialType = "<?php echo $data['event_type'] ?? ''; ?>";
    console.log("Initial slot details loaded:", slot_details); 

    function populateSlots(selectedType, selectedSlotId) {
        var filteredSlots = slot_details.filter(slot => slot.slot_type === selectedType);
        $('#slot_name').empty();
        $('#slot_name').append('<option value="">Select Slot</option>');

        filteredSlots.forEach(function(slot) {
            var isSelected = slot.booking_slot_id == selectedSlotId ? ' selected' : '';
            $('#slot_name').append($('<option' + isSelected + '>', { 
                value: slot.booking_slot_id,
                text : slot.slot_name 
            }));
        });
        $('#slot_name').selectpicker('refresh');
    }

    // Populate slots on session block type change
    $('#sessionblock_type').change(function() {
        populateSlots($(this).val(), '');
    });

    // Initial population of slots if editing
    if (initialSlotId && initialType) {
        populateSlots(initialType, initialSlotId);
    }
});
</script> -->


<!-- <script>
$(document).ready(function() {

    var slot_details = <?php echo json_encode($slot_details); ?>;
    console.log("Initial slot details loaded:", slot_details); 

    $('#sessionblock_type').change(function() {
        var selectedType = $(this).val(); 
        var filteredSlots = slot_details.filter(slot => slot.slot_type === selectedType); 
        $('#slot_name').empty(); 
        $('#slot_name').append('<option value="">Select Slot</option>'); 

        filteredSlots.forEach(function(slot) {
            $('#slot_name').append($('<option>', { 
                value: slot.booking_slot_id,
                text : slot.slot_name 
            }));
        });
        $('#slot_name').selectpicker('refresh');

        console.log("Options after update:", $('#slot_name').children().map(function() { return $(this).val() + ': ' + $(this).text(); }).get());
    });
});
</script> -->




<!-- BACKUP:
<script>
    document.addEventListener('DOMContentLoaded', function() {
        updateSlots(); 
        
        document.getElementById('sessionblock_type').addEventListener('change', updateSlots);
        document.getElementById('select_all_slots').addEventListener('change', handleAllCheckboxChange);
    });

    function updateSlots() {
        var selectedEventType = document.getElementById('sessionblock_type').value;
        var slotSelect = document.getElementById('slot_selection');
        var allCheckbox = document.getElementById('select_all_slots');
        
        if (allCheckbox.checked) {
            slotSelect.disabled = true;
            document.getElementById('slot_selection_container').style.display = 'none';
            gatherAllSlotsData(selectedEventType);
        } else {
            slotSelect.disabled = false;
            document.getElementById('slot_selection_container').style.display = 'block';
            
            $(slotSelect).empty().append('<option value="0">Select Slot</option>');
    
            var slots = <?php echo json_encode($slot_details); ?>;
            slots.forEach(function(slot) {
                if (selectedEventType === "" || slot.slot_type === selectedEventType) {
                    var isSelected = <?php echo json_encode($data['booking_slot_id'] ?? ''); ?> == slot.booking_slot_id;
                    var option = new Option(slot.slot_name, slot.booking_slot_id, isSelected, isSelected);
                    $(slotSelect).append(option);
                }
            });
    
            $(slotSelect).selectpicker('refresh');
        }
        function updateSlots() {
            var selectedEventType = document.getElementById('sessionblock_type').value;
            var slotSelect = document.getElementById('slot_selection');

            $(slotSelect).empty().append('<option value="0">Select Slot</option>');

            var slots = <?php echo json_encode($slot_details); ?>;
            slots.forEach(function(slot) {
                if (selectedEventType === "" || slot.slot_type === selectedEventType) {
                    var isSelected = <?php echo json_encode($data['booking_slot_id'] ?? ''); ?> == slot.booking_slot_id;
                    var option = new Option(slot.slot_name, slot.booking_slot_id, isSelected, isSelected);
                    $(slotSelect).append(option);
                }
            });

            $(slotSelect).selectpicker('refresh');
        }
        
    }

    function handleAllCheckboxChange() {
        updateSlots();
    }

    function gatherAllSlotsData(selectedEventType) {
        var slots = <?php echo json_encode($slot_details); ?>;
        var allSlotsData = [];

        slots.forEach(function(slot) {
            if (slot.slot_type === selectedEventType) {
                allSlotsData.push({
                    date: slot.date,
                    event_type: selectedEventType,
                    booking_slot_id: slot.booking_slot_id,
                    description: slot.description
                });
            }
        });
        document.getElementById('all_slots_data').value = JSON.stringify(allSlotsData);
    }
</script> -->