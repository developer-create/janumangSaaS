<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Ganesh Samiti Management
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                $this->load->helper("form");
                $error = $this->session->flashdata("error");
                if ($error) { ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata("error"); ?>                    
                </div>
                <?php } ?>
                <?php
                $success = $this->session->flashdata("success");
                if ($success) { ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata("success"); ?>
                </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors(
                            '<div class="alert alert-danger alert-dismissable">',
                            ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Filter Form -->
            <div class="col-xs-12">
                <form method="post" action="<?php echo base_url("ganeshsamiti/ganeshsamitiajax"); ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="year">वर्ष</label>
                                <select name="year" id="year" class="form-control">
                                    <option value="">Select Year</option>
                                    <?php
                                    // Generate year options
                                    $current_year = date("Y");
                                    for ($i = $current_year; $i >= $current_year - 10; $i--) {
                                        echo "<option value='{$i}'>{$i}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="block">ब्लॉक</label>
                                <select name="block" id="block" class="form-control">
                                    <option value="">Select Block</option>
                                    <?php
                                    $userid = $this->session->userdata("userId");
                                    $sessionBlockId = $this->session->userdata("blockId");
                                    if ($sessionBlockId != 0) {
                                        $userBlockIds = $this->db
                                            ->select("blockId")
                                            ->from("tbl_users")
                                            ->where("userId", $userid)
                                            ->get()
                                            ->row()->blockId;
                                    
                                        $blockIdsArray = explode(",", $userBlockIds);
                                        $this->db->where_in("block.id", $blockIdsArray);
                                    }
                                    $blocks = $this->db->get("block")->result();
                                    foreach ($blocks as $blk) {
                                        echo "<option value='{$blk->id}'>{$blk->name}</option>";
                                    }
                                    ?>  
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ganesh_samiti_name">गणेश समिति का नाम</label>
                                <select name="ganesh_samiti_name" id="ganesh_samiti_name" class="form-control">
                                    <option value="">Select Ganesh Samiti</option>
                                    <?php
                                    $ganesh_samitis = $this->db->select('DISTINCT ganesh_samiti_name')
                                                                ->from('ganesh_samiti')
                                                                ->where('status !=', 'Deleted')
                                                                ->order_by('ganesh_samiti_name', 'ASC')
                                                                ->get()->result();
                                    foreach ($ganesh_samitis as $samiti) {
                                        echo "<option value='{$samiti->ganesh_samiti_name}'>{$samiti->ganesh_samiti_name}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">स्थिति</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary form-control">Filter</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">गणेश समिति सूची</h3>
                        <a href="<?php echo base_url(); ?>ganeshsamiti/add" class="btn btn-info" style="float: right;">Add</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table id="ganeshSamitiTable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr style="color:white;font-size:15px;background-color:#020254;">
                                    <th style="width: 40px;">क्र.</th>
                                    <th style="width: 60px;">वर्ष</th>
                                    <th style="width: 100px;">गणेश समिति का नाम</th>
                                    <th style="width: 100px;">ब्लॉक</th>
                                    <th style="width: 60px;">सेक्टर</th>
                                    <th style="width: 100px;">माइक्रो सेक्टर नंबर</th>
                                    <th style="width: 100px;">माइक्रो सेक्टर नाम</th>
                                    <th style="width: 40px;">बूथ नंबर</th>
                                    <th style="width: 100px;">बूथ नाम</th>
                                    <th style="width: 80px;">पंचायत</th>
                                    <th style="width: 80px;">ग्राम</th>
                                    <th style="width: 80px;">फलिया</th>
                                    <th style="width: 100px;">सदस्य का नाम</th>
                                    <th style="width: 100px;">पिता का नाम</th>
                                    <th style="width: 40px;">उम्र</th>
                                    <th style="width: 80px;">पद</th>
                                    <th style="width: 80px;">मोबाइल नंबर</th>
                                    <th style="width: 100px;">रिमार्क</th>
                                    <th style="width: 100px;" class="text-center">क्रियाएं</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</div>

<style>
    button.dt-button.buttons-excel.buttons-html5 {
        left: 3px !important;
    }
    
    /* Ensure table headers and data cells are properly aligned */
    #ganeshSamitiTable th,
    #ganeshSamitiTable td {
        text-align: center;
        vertical-align: middle;
        padding: 8px 4px;
        border: 1px solid #ddd;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    #ganeshSamitiTable th {
        background-color: #020254 !important;
        color: white !important;
    }
    
    /* Specific column alignments */
    #ganeshSamitiTable td:nth-child(3),  /* गणेश समिति का नाम */
    #ganeshSamitiTable td:nth-child(7),  /* माइक्रो सेक्टर नाम */
    #ganeshSamitiTable td:nth-child(9),  /* बूथ नाम */
    #ganeshSamitiTable td:nth-child(13), /* सदस्य का नाम */
    #ganeshSamitiTable td:nth-child(14), /* पिता का नाम */
    #ganeshSamitiTable td:nth-child(18)  /* रिमार्क */
    {
        text-align: left;
        word-wrap: break-word;
        white-space: normal;
    }
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.colVis.min.js"></script>

<script>
var baseURL = "<?php echo base_url(); ?>"; // Define baseURL globally

$(document).ready(function() {
    const table = $('#ganeshSamitiTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?php echo base_url('ganeshsamiti/ganeshsamitidata'); ?>",
            type: "POST",
            data: function(d) {
                d.year = $('#year').val();
                d.block = $('#block').val();
                d.ganesh_samiti_name = $('#ganesh_samiti_name').val();
                d.status = $('#status').val();
            }
        },
        dom: '<"top"lfB>rt<"bottom"ip>',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Ganesh Samiti List'
            },
            {
                extend: 'colvis',
                text: 'Show/Hide Columns',
                titleAttr: 'Show/Hide Columns'
            }
        ],
        lengthMenu: [
            [10, 25, 50, 75, -1],
            [10, 25, 50, 75, "All"]
        ],
        order: [], // Prevent default ordering
        columnDefs: [
            {
                targets: '_all', // apply to all columns
                orderable: false // disable ordering
            }
        ],
        scrollX: true, // Enable horizontal scrolling
        autoWidth: false, // Disable auto width calculation
        fixedColumns: {
            leftColumns: 2 // Fix first 2 columns when scrolling
        }
    });

    // Filter functionality
    $('#year, #block, #ganesh_samiti_name, #status').on('change', function() {
        table.ajax.reload();
    });

    // Delete functionality with event delegation
    $(document).on('click', '.deleteGaneshSamiti', function(e) {
        e.preventDefault();
        var ganeshSamitiId = $(this).data('ganeshsamitiid');
        var hitURL = baseURL + "ganeshsamiti/delete";
        var currentRow = $(this).closest('tr');
        
        if (confirm("Are you sure you want to delete this record?")) {
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: hitURL,
                data: { ganeshSamitiId: ganeshSamitiId }
            }).done(function(data) {
                if (data.status == true) {
                    alert("Record deleted successfully");
                    table.ajax.reload(); // Reload DataTable
                } else {
                    alert("Record deletion failed: " + data.message);
                }
            }).fail(function() {
                alert("An error occurred while processing the request");
            });
        }
    });
});
</script>