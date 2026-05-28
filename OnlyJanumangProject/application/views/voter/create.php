<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Enter Voter Details</h3>
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
                    
                    <?php if (validation_errors()): ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php
                    $success = $this->session->flashdata("success");
                    if ($success) {
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata("success"); ?>
                    </div>
                    <?php } ?>
                    
                    <form action="<?php echo site_url('voter/store'); ?>" method="post" enctype="multipart/form-data">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="father_name">Father Name: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="father_name" name="father_name" value="<?php echo set_value('father_name'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobile_no">Mobile No: <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" value="<?php echo set_value('mobile_no'); ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="age">Age: <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="age" name="age" value="<?php echo set_value('age'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="full_address">Full Address: <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="full_address" name="full_address" rows="2" required><?php echo set_value('full_address'); ?></textarea>
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
                                                <option value="<?php echo $block->id; ?>" <?php echo set_select('block_id', $block->id); ?>><?php echo $block->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_id">Booth Name: <span class="text-danger">*</span></label>
                                        <select class="form-control" id="booth_id" name="booth_id" disabled>
                                            <option value="">Select Booth</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="booth_no">Booth No: <span class="text-danger">*</span></label>
                                        <select class="form-control" id="booth_no" name="booth_no" disabled>
                                            <option value="">Select Booth No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="panchayat_id">Panchayat: <span class="text-danger">*</span></label>
                                        <select class="form-control" id="panchayat_id" name="panchayat_id" disabled>
                                            <option value="">Select Panchayat</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="village_id">Village: <span class="text-danger">*</span></label>
                                        <select class="form-control" id="village_id" name="village_id" disabled>
                                            <option value="">Select Village</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="falia_majra">Falia/ Majra:</label>
                                        <input type="text" class="form-control" id="falia_majra" name="falia_majra" value="<?php echo set_value('falia_majra'); ?>">
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
                                                    <option value="<?php echo $cast['cast_name']; ?>" <?php echo set_select('cast', $cast['cast_name']); ?>>
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
                                                    <option value="<?php echo $sub_cast['sub_cast_name']; ?>" <?php echo set_select('sub_cast', $sub_cast['sub_cast_name']); ?>>
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
                                        <input type="text" class="form-control" id="voter_id_epic" name="voter_id_epic" value="<?php echo set_value('voter_id_epic'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="voter_image">Image (Voter ID):</label>
                                        <input type="file" class="form-control" id="voter_image" name="voter_image" accept="image/*">
                                        <small class="text-muted">Allowed types: JPG, PNG, GIF. Max size: 2MB</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <input type="submit" value="Submit" class="btn btn-primary">
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
    
    // Block change - load booths
    $("#block_id").change(function () {
        const blockId = $(this).val();
        if (blockId) {
            $("#booth_id").prop("disabled", false).prop("required", true).empty().append('<option value="">Select Booth</option>');
        } else {
            $("#booth_id").prop("disabled", true).prop("required", false).empty().append('<option value="">Select Booth</option>');
        }
        $("#booth_no").prop("disabled", true).prop("required", false).empty().append('<option value="">Select Booth No</option>');
        $("#panchayat_id").prop("disabled", true).prop("required", false).empty().append('<option value="">Select Panchayat</option>');
        $("#village_id").prop("disabled", true).prop("required", false).empty().append('<option value="">Select Village</option>');

        if (blockId) {
            $.ajax({
                url: base_url + "api/get_booths_by_block",
                type: "POST",
                data: { block_id: blockId },
                dataType: "json",
                success: function (response) {
                    if (!response.error) {
                        $.each(response.booths, function (index, booth) {
                            $("#booth_id").append('<option bnumbervalue="' + booth.bnumber + '" value="' + booth.id + '">' + booth.name + "</option>");
                        });
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

        if (boothId) {
            $("#panchayat_id").prop("disabled", false).prop("required", true).empty().append('<option value="">Select Panchayat</option>');
            // Set booth number
            $("#booth_no").prop("disabled", false).prop("required", true).empty().append('<option value="' + bnumbervalue + '">' + bnumbervalue + '</option>');
            
            $.ajax({
                url: base_url + "api/get_panchayats_by_booth",
                type: "POST",
                data: { booth_id: boothId },
                dataType: "json",
                success: function (response) {
                    if (!response.error) {
                        $.each(response.panchayats, function (index, panchayat) {
                            $("#panchayat_id").append('<option value="' + panchayat.id + '">' + panchayat.name + "</option>");
                        });
                    } else {
                        alert(response.message);
                    }
                },
            });
        } else {
            $("#panchayat_id").prop("disabled", true).prop("required", false).empty().append('<option value="">Select Panchayat</option>');
            $("#booth_no").prop("disabled", true).prop("required", false).empty().append('<option value="">Select Booth No</option>');
        }
        $("#village_id").prop("disabled", true).prop("required", false).empty().append('<option value="">Select Village</option>');
    });

    // Panchayat change - load villages
    $("#panchayat_id").change(function () {
        const panchayatId = $(this).val();
        
        if (panchayatId) {
            $("#village_id").prop("disabled", false).prop("required", true).empty().append('<option value="">Select Village</option>');
            $.ajax({
                url: base_url + "api/get_villages_by_panchayat",
                type: "POST",
                data: { panchayat_id: panchayatId },
                dataType: "json",
                success: function (response) {
                    if (!response.error) {
                        $.each(response.villages, function (index, village) {
                            $("#village_id").append('<option value="' + village.id + '">' + village.name + "</option>");
                        });
                    } else {
                        alert(response.message);
                    }
                },
            });
        } else {
            $("#village_id").prop("disabled", true).prop("required", false).empty().append('<option value="">Select Village</option>');
        }
    });
    
    // Cast change - load sub-casts
    $("#cast").change(function () {
        const castName = $(this).val();
        
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
                                $("#sub_cast").append('<option value="' + subCast.sub_cast_name + '">' + subCast.sub_cast_name + "</option>");
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
});
</script>

