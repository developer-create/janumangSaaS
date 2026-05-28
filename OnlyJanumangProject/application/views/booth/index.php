<style>
    button.dt-button.buttons-excel.buttons-html5 {
    left: 100px !important;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header"> 
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Booth Management
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Booth List</h3>  
                    <a href="<?php echo site_url('booth/create'); ?>"  class="btn btn-success"  style="float: right;">Add New booth</a>
                </div><!-- /.box-header -->
                
                <!-- Filter Section -->
                <div class="box-body" style="background-color: #f5f5f5; padding: 15px; margin-bottom: 15px;">
                    <form method="get" action="<?php echo site_url('booth'); ?>" class="form-inline" id="filterForm">
                        <div class="form-group" style="margin-right: 15px;">
                            <label for="filter_block" class="control-label">Block:</label>
                            <select name="filter_block" id="filter_block" class="form-control input-sm" style="width: 200px;">
                                <option value="">All Blocks</option>
                                <?php if (!empty($blocks)): foreach ($blocks as $block): ?>
                                <option value="<?php echo $block['id']; ?>" <?php echo (isset($filter_block) && $filter_block == $block['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($block['name']); ?>
                                </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        
                        <div class="form-group" style="margin-right: 15px;">
                            <label for="filter_year" class="control-label">Year:</label>
                            <select name="filter_year" id="filter_year" class="form-control input-sm" style="width: 150px;">
                                <option value="">All Years</option>
                                <?php if (!empty($years)): foreach ($years as $year): ?>
                                <option value="<?php echo $year['year']; ?>" <?php echo (isset($filter_year) && $filter_year == $year['year']) ? 'selected' : ''; ?>>
                                    <?php echo $year['year']; ?>
                                </option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-filter"></i> Filter</button>
                        <a href="<?php echo site_url('booth'); ?>" class="btn btn-default btn-sm" style="margin-left: 10px;">Reset</a>
                    </form>
                </div>
                
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="feedbackTa">
                    <thead>
                      <tr style="color:white;font-size:15px;background:#020254;"> 
            <th>ID</th>
            <th>Name</th>
            <th>Booth Number</th>
            <th>Block Name</th>
            <th>Year</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($booths as $booth): ?>
        <tr>
            <td><?php echo $booth['id']; ?></td>
            <td><?php echo $booth['name']; ?></td>
            <td><?php echo $booth['bnumber']; ?></td>
            <td><?php echo $booth['block_name']; ?></td>
            <td><span class="badge bg-blue"><?php echo $booth['year']; ?></span></td>
            <td>
                <a href="<?php echo site_url('booth/edit/'.$booth['id']); ?>"  class="btn btn-info"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo site_url('booth/delete/'.$booth['id']); ?>"  class="btn btn-danger" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                </div>
              </div><!-- /.box -->
            </div>
        </div>
    </section> 
</div> 

<!-- DataTables and related plugins -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
$(document).ready(function() {
    var qt_id = "<?php echo $this->uri->segment(3)?>";
    $('#feedbackTa').DataTable({
        "processing": true, // Show processing indicator 
        "serverSide": false, // Enable server-side processing
        // "ajax": {
        //     "url": "<?php echo base_url('question/serveydatanew') ?>", // Update with your controller function URL
        //     "type": "GET",
        //     "data": function(d) {
        //         d.qt_id = qt_id; // Add qt_id to the request
        //     }
        // },
        // "columns": [
        //     { "data": "id" },
        //     { "data": "name" },
        //     { "data": "mobile" },
        //     { "data": "qc_id" },
        //     { "data": "zc_id" },
        //     { "data": "qt_id" },
        //     // Generate columns for all 40 answers dynamically
 
        //     { "data": "created_at" },
        //     { "data": "action", "orderable": false, "searchable": false }
        // ],
                // dom: 'Bfrtip',

        "dom": '<"top"lfB>rt<"bottom"ip>', // Control layout: l=lengthMenu, f=filter, B=buttons, t=table, i=info, p=pagination
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Feedback List'
            }
        ],
        "paging": true, // Enable pagination
        "searching": true, // Enable searching
        "ordering": false, // Disable ordering
        "info": true, // Display info about table
        "lengthMenu": [ // Add lengthMenu to allow user to select number of entries to display
            [10, 25, 50, 75, -1], // Page length options
            [10, 25, 50, 75, "All"] // Text for the options
        ]
    });
});
</script>
