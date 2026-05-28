<style>
    button.dt-button.buttons-excel.buttons-html5 {
    left: 100px !important;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header"> 
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> Samiti Management
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Samiti List</h3>  
                    <a href="<?php echo site_url('samiti/create'); ?>"  class="btn btn-success"  style="float: right;">Add New Samiti</a>
                </div><!-- /.box-header -->
                
                <!-- Filter Form -->
                <div class="box-body">
                    <form method="post" action="<?php echo site_url('samiti'); ?>" class="form-inline">
                        <div class="form-group" style="margin-right: 15px;">
                            <label for="block_id">Block:</label>
                            <select name="block_id" id="block_id" class="form-control" style="width: 200px;">
                                <option value="">All Blocks</option>
                                <?php if (!empty($blocks)): ?>
                                    <?php foreach ($blocks as $block): ?>
                                        <option value="<?php echo $block['id']; ?>" <?php echo ($filter_block_id == $block['id']) ? 'selected' : ''; ?>>
                                            <?php echo $block['name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="form-group" style="margin-right: 15px;">
                            <label for="year">Year:</label>
                            <select name="year" id="year" class="form-control" style="width: 150px;">
                                <option value="">All Years</option>
                                <?php for ($y = date('Y'); $y >= 2020; $y--): ?>
                                    <option value="<?php echo $y; ?>" <?php echo ($filter_year == $y) ? 'selected' : ''; ?>>
                                        <?php echo $y; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div class="form-group" style="margin-right: 15px;">
                            <label for="month">Month:</label>
                            <select name="month" id="month" class="form-control" style="width: 150px;">
                                <option value="">All Months</option>
                                <option value="1" <?php echo ($filter_month == 1) ? 'selected' : ''; ?>>January</option>
                                <option value="2" <?php echo ($filter_month == 2) ? 'selected' : ''; ?>>February</option>
                                <option value="3" <?php echo ($filter_month == 3) ? 'selected' : ''; ?>>March</option>
                                <option value="4" <?php echo ($filter_month == 4) ? 'selected' : ''; ?>>April</option>
                                <option value="5" <?php echo ($filter_month == 5) ? 'selected' : ''; ?>>May</option>
                                <option value="6" <?php echo ($filter_month == 6) ? 'selected' : ''; ?>>June</option>
                                <option value="7" <?php echo ($filter_month == 7) ? 'selected' : ''; ?>>July</option>
                                <option value="8" <?php echo ($filter_month == 8) ? 'selected' : ''; ?>>August</option>
                                <option value="9" <?php echo ($filter_month == 9) ? 'selected' : ''; ?>>September</option>
                                <option value="10" <?php echo ($filter_month == 10) ? 'selected' : ''; ?>>October</option>
                                <option value="11" <?php echo ($filter_month == 11) ? 'selected' : ''; ?>>November</option>
                                <option value="12" <?php echo ($filter_month == 12) ? 'selected' : ''; ?>>December</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="<?php echo site_url('samiti'); ?>" class="btn btn-default">Reset</a>
                    </form>
                </div>
                
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="feedbackTa">
                    <thead>
                      <tr style="color:white;font-size:15px;background-color:#020254;"> 
            <th>ID</th>
            <th>Name</th>
            <th>Block</th>
            <th>Year</th>
            <th>Month</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($samitis as $samiti): ?>
        <tr>
            <td><?php echo $samiti['id']; ?></td>
            <td><?php echo $samiti['name']; ?></td>
            <td><?php echo isset($samiti['block_name']) ? $samiti['block_name'] : 'N/A'; ?></td>
            <td><?php echo isset($samiti['year']) && !empty($samiti['year']) ? $samiti['year'] : 'N/A'; ?></td>
            <td><?php echo isset($samiti['month']) && !empty($samiti['month']) ? $samiti['month'] : 'N/A'; ?></td>
            <td>
                <a href="<?php echo site_url('samiti/edit/'.$samiti['id']); ?>"  class="btn btn-info"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo site_url('samiti/delete/'.$samiti['id']); ?>"  class="btn btn-danger" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></a>
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
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Samiti List'
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
