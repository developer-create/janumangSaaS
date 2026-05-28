<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Edit Voter Details</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <?php
                    $this->load->helper("form");
                    $error = $this->session->flashdata("error");
                    if ($error) {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata("error"); ?>
                    </div>
                    <?php } ?>
                    
                    <form action="<?php echo site_url('voter/update/'.$voter['id']); ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $voter['name']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="father_name">Father Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="father_name" name="father_name" value="<?php echo $voter['father_name']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo $voter['mobile_no']; ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="age">Age: <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="age" name="age" value="<?php echo $voter['age']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="full_address">Full Address: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="full_address" name="full_address" rows="2" required><?php echo $voter['full_address']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="block_id">Block Name: <span class="text-danger">*</span></label>
                                        <select class="form-control" id="block_id" name="block_id" required>
                                            <option value="">Select Block</option>
                                            <?php foreach ($blocks as $block): ?>
                                                <option value="<?php echo $block->id; ?>" <?php echo ($voter['block_id'] == $block->id) ? 'selected' : ''; ?>><?php echo $block->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_id">Booth Name: <span class="text-danger">*</span></label>
                                        <select class="form-control" id="booth_id" name="booth_id">
                                            <option value="">Select Booth</option>
                                            <?php if (!empty($booths)): ?>
                                                <?php foreach ($booths as $booth): ?>
                                                    <option value="<?php echo $booth['id']; ?>" bnumbervalue="<?php echo $booth['bnumber']; ?>" <?php echo ($voter['booth_id'] == $booth['id']) ? 'selected' : ''; ?>><?php echo $booth['name']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_no">Booth No: <span class="text-danger">*</span></label>
                                        <select class="form-control" id="booth_no" name="booth_no">
                                            <option value="">Select Booth No</option>
                                            <?php if (!empty($booths)): ?>
                                                <?php 
                                                $selectedBooth = null;
                                                foreach ($booths as $booth) {
                                                    if ($booth['id'] == $voter['booth_id']) {
                                                        $selectedBooth = $booth;
                                                        break;
                                                    }
                                                }
                                                if ($selectedBooth): ?>
                                                    <option value="<?php echo $selectedBooth['bnumber']; ?>" selected><?php echo $selectedBooth['bnumber']; ?></option>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="panchayat_id">Panchayat: <span class="text-danger">*</span></label>
                                        <select class="form-control" id="panchayat_id" name="panchayat_id">
                                            <option value="">Select Panchayat</option>
                                            <?php if (!empty($panchayats)): ?>
                                                <?php foreach ($panchayats as $panchayat): ?>
                                                    <option value="<?php echo $panchayat['id']; ?>" <?php echo ($voter['panchayat_id'] == $panchayat['id']) ? 'selected' : ''; ?>><?php echo $panchayat['name']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="village_id">Village: <span class="text-danger">*</span></label>
                                        <select class="form-control" id="village_id" name="village_id">
                                            <option value="">Select Village</option>
                                            <?php if (!empty($villages)): ?>
                                                <?php foreach ($villages as $village): ?>
                                                    <option value="<?php echo $village['id']; ?>" <?php echo ($voter['village_id'] == $village['id']) ? 'selected' : ''; ?>><?php echo $village['name']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="falia_majra">Falia/ Majra:</label>
                                        <input type="text" class="form-control" id="falia_majra" name="falia_majra" value="<?php echo $voter['falia_majra']; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cast">Cast:</label>
                                        <select class="form-control" id="cast" name="cast">
                                            <option value="">Select Cast</option>
                                            <?php if (!empty($cast_options)): ?>
                                                <?php foreach ($cast_options as $cast): ?>
                                                    <option value="<?php echo $cast['cast_name']; ?>" <?php echo ($voter['cast'] == $cast['cast_name']) ? 'selected' : ''; ?>>
                                                        <?php echo $cast['cast_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sub_cast">Sub-Cast:</label>
                                        <select class="form-control" id="sub_cast" name="sub_cast">
                                            <option value="">Select Sub-Cast</option>
                                            <?php if (!empty($sub_cast_options)): ?>
                                                <?php foreach ($sub_cast_options as $sub_cast): ?>
                                                    <option value="<?php echo $sub_cast['sub_cast_name']; ?>" <?php echo ($voter['sub_cast'] == $sub_cast['sub_cast_name']) ? 'selected' : ''; ?>>
                                                        <?php echo $sub_cast['sub_cast_name']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="voter_id_epic">Voter ID (Epic) No: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="voter_id_epic" name="voter_id_epic" value="<?php echo $voter['voter_id_epic']; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="voter_image">Image (Voter ID):</label>
                                        <input type="file" class="form-control" id="voter_image" name="voter_image" accept="image/*">
                                        <small class="text-muted">Leave empty to keep current image</small>
                                        <?php if (!empty($voter['voter_image'])): ?>
                                            <div style="margin-top: 10px;">
                                                <img src="<?php echo base_url('uploads/voters/' . $voter['voter_image']); ?>" alt="Current Image" style="max-width: 150px; max-height: 150px;">
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="submit" value="Update" class="btn btn-primary">
                            <a href="<?php echo site_url('voter'); ?>" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </section>
</div>

<script>
$(document).ready(function () {
    var base_url = "<?php echo base_url(); ?>";
    var selectedBlockId = "<?php echo $voter['block_id']; ?>";
    var selectedBoothId = "<?php echo $voter['booth_id']; ?>";
    var selectedPanchayatId = "<?php echo $voter['panchayat_id']; ?>";
    var selectedVillageId = "<?php echo $voter['village_id']; ?>";
    
    // Block change - load booths
    $("#block_id").change(function () {
        const blockId = $(this).val();
        $("#booth_id").empty().append('<option value="">Select Booth</option>');
        $("#booth_no").empty().append('<option value="">Select Booth No</option>');
        $("#panchayat_id").empty().append('<option value="">Select Panchayat</option>');
        $("#village_id").empty().append('<option value="">Select Village</option>');

        if (blockId) {
            $.ajax({
                url: base_url + "api/get_booths_by_block",
                type: "POST",
                data: { block_id: blockId },
                dataType: "json",
                success: function (response) {
                    if (!response.error) {
                        $.each(response.booths, function (index, booth) {
                            var selected = (booth.id == selectedBoothId) ? 'selected' : '';
                            $("#booth_id").append('<option bnumbervalue="' + booth.bnumber + '" value="' + booth.id + '" ' + selected + '>' + booth.name + "</option>");
                        });
                        if (selectedBoothId) {
                            $("#booth_id").trigger('change');
                        }
                    } else {
                        alert(response.message);
                    }
                },
            });
        }
    });

    // Booth change - load panchayats and set booth number
    $("#booth_id").change(function () {
        const boothId = $(this).val();
        const bnumbervalue = $(this).find("option:selected").attr("bnumbervalue");

        $("#panchayat_id").empty().append('<option value="">Select Panchayat</option>');
        $("#village_id").empty().append('<option value="">Select Village</option>');

        if (boothId) {
            // Set booth number
            $("#booth_no").empty().append('<option value="' + bnumbervalue + '">' + bnumbervalue + '</option>');
            
            $.ajax({
                url: base_url + "api/get_panchayats_by_booth",
                type: "POST",
                data: { booth_id: boothId },
                dataType: "json",
                success: function (response) {
                    if (!response.error) {
                        $.each(response.panchayats, function (index, panchayat) {
                            var selected = (panchayat.id == selectedPanchayatId) ? 'selected' : '';
                            $("#panchayat_id").append('<option value="' + panchayat.id + '" ' + selected + '>' + panchayat.name + "</option>");
                        });
                        if (selectedPanchayatId) {
                            $("#panchayat_id").trigger('change');
                        }
                    } else {
                        alert(response.message);
                    }
                },
            });
        }
    });

    // Panchayat change - load villages
    $("#panchayat_id").change(function () {
        const panchayatId = $(this).val();
        $("#village_id").empty().append('<option value="">Select Village</option>');

        if (panchayatId) {
            $.ajax({
                url: base_url + "api/get_villages_by_panchayat",
                type: "POST",
                data: { panchayat_id: panchayatId },
                dataType: "json",
                success: function (response) {
                    if (!response.error) {
                        $.each(response.villages, function (index, village) {
                            var selected = (village.id == selectedVillageId) ? 'selected' : '';
                            $("#village_id").append('<option value="' + village.id + '" ' + selected + '>' + village.name + "</option>");
                        });
                    } else {
                        alert(response.message);
                    }
                },
            });
        }
    });

    // Cast change - load sub-casts
    $("#cast").change(function () {
        const castName = $(this).val();
        const currentSubCast = "<?php echo isset($voter['sub_cast']) ? $voter['sub_cast'] : ''; ?>";
        
        $("#sub_cast").empty().append('<option value="">Select Sub-Cast</option>');
        
        if (castName) {
            // Find the cast_id based on cast_name
            var castId = null;
            <?php if (!empty($cast_options)): ?>
                var castOptions = <?php echo json_encode($cast_options); ?>;
                castOptions.forEach(function(cast) {
                    if (cast.cast_name === castName) {
                        castId = cast.id;
                    }
                });
            <?php endif; ?>
            
            if (castId) {
                $.ajax({
                    url: base_url + "voter/get_sub_cast_options",
                    type: "POST",
                    data: { cast_id: castId },
                    dataType: "json",
                    success: function (response) {
                        if (response && response.length > 0) {
                            $.each(response, function (index, subCast) {
                                var selected = (subCast.sub_cast_name === currentSubCast) ? 'selected' : '';
                                $("#sub_cast").append('<option value="' + subCast.sub_cast_name + '" ' + selected + '>' + subCast.sub_cast_name + "</option>");
                            });
                        }
                    },
                    error: function() {
                        console.log("Error loading sub-cast options");
                    }
                });
            }
        }
    });

    // Trigger initial load if block is selected
    if (selectedBlockId) {
        $("#block_id").trigger('change');
    }
    
    // Trigger cast change if cast is selected to load sub-casts
    var initialCast = $("#cast").val();
    if (initialCast) {
        $("#cast").trigger('change');
    }
});
</script>

