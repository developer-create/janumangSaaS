<style>
    button.dt-button.buttons-excel.buttons-html5 {
    left: 100px !important;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header"> 
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i>Panchayat Management
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Panchayat List</h3>  
                    <a href="<?php echo site_url('panchayat/create'); ?>"  class="btn btn-success"  style="float: right;">Add New panchayat</a>
                </div><!-- /.box-header -->
                
                <!-- Filter Section -->
                <div class="box-body" style="background-color: #f5f5f5; padding: 15px; margin-bottom: 15px;">
                    <form method="GET" action="<?php echo site_url('panchayat'); ?>" id="filterForm">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="block_id">Block:</label>
                                    <select id="block_id" name="block_id" class="form-control">
                                        <option value="">-- Select Block --</option>
                                        <option value="all" <?php echo ($selected_block == 'all') ? 'selected' : ''; ?>>All Blocks</option>
                                        <?php if(!empty($blocks)): ?>
                                            <?php foreach($blocks as $block): ?>
                                                <option value="<?php echo $block['id']; ?>" <?php echo ($selected_block == $block['id']) ? 'selected' : ''; ?>>
                                                    <?php echo $block['name']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="year">Year:</label>
                                    <select id="year" name="year" class="form-control">
                                        <option value="">-- Select Year --</option>
                                        <option value="all" <?php echo ($selected_year == 'all') ? 'selected' : ''; ?>>All Years</option>
                                        <?php if(!empty($years)): ?>
                                            <?php foreach($years as $yr): ?>
                                                <option value="<?php echo $yr['year']; ?>" <?php echo ($selected_year == $yr['year']) ? 'selected' : ''; ?>>
                                                    <?php echo $yr['year']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <a href="<?php echo site_url('panchayat'); ?>" class="btn btn-default">
                                            <i class="fa fa-refresh"></i> Reset Filters
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="feedbackTa">
                    <thead>
                      <tr style="color:white;font-size:15px;background-color:#020254;"> 
            <th>ID</th>
            <th>Name</th>
            <th>Year</th>
            <th>Block Name</th>
            <th>Booth Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($panchayats)): ?>
            <?php foreach ($panchayats as $panchayat): ?>
            <tr>
                <td><?php echo $panchayat['id']; ?></td>
                <td><?php echo $panchayat['name']; ?></td>
                <td><?php echo $panchayat['year']; ?></td>
                <td><?php echo $panchayat['block_name']; ?></td>
                <td><?php echo $panchayat['booth_name']; ?></td>
                
                <td>
                    
                    <a href="<?php echo site_url('panchayat/edit/'.$panchayat['id']); ?>"  class="btn btn-info"><i class="fa fa-pencil"></i></a>
                    <a href="<?php echo site_url('panchayat/delete/'.$panchayat['id']); ?>"  class="btn btn-danger" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                    <i class="fa fa-info-circle"></i> No panchayats found matching your filters.
                </td>
            </tr>
        <?php endif; ?>
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
    
    // Auto-submit filter form when dropdown changes
    $('#block_id, #year').on('change', function() {
        $('#filterForm').submit();
    });
    
    $('#feedbackTa').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Panchayat List'
            }
        ],
        "paging": true,
        "searching": true,
        "ordering": false,
        "info": true,
        "lengthMenu": [
            [10, 25, 50, 75, -1],
            [10, 25, 50, 75, "All"]
        ]
    });
});
</script>
