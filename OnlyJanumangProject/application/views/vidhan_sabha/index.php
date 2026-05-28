<style>
    button.dt-button.buttons-excel.buttons-html5 {
    left: 100px !important;
}
</style>
<div class="content-wrapper">
    <section class="content-header"> 
      <h1>
        <i class="fa fa-building" aria-hidden="true"></i> Vidhan Sabha Management
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Vidhan Sabha List</h3>  
                    <a href="<?php echo site_url('vidhan_sabha/create'); ?>"  class="btn btn-success"  style="float: right;">Add New Vidhan Sabha</a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="vidhanSabhaTable">
                    <thead>
                      <tr style="color:white;font-size:15px;background:#020254;"> 
                          <th>ID</th>
                          <th>Vidhan Sabha Name</th>
                          <th>District</th>
                          <th>Year</th>
                          <th>Created By</th>
                          <th>Added By</th>
                          <th>Created Time</th>
                          <th>Updated Time</th>
                          <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($vidhan_sabhas as $vidhan_sabha): ?>
                    <tr>
                        <td><?php echo $vidhan_sabha['id']; ?></td>
                        <td><?php echo htmlspecialchars($vidhan_sabha['vidhan_sabha_name']); ?></td>
                        <td><?php echo isset($vidhan_sabha['district_name']) && $vidhan_sabha['district_name'] ? htmlspecialchars($vidhan_sabha['district_name']) : '-'; ?></td>
                        <td><span class="badge bg-blue"><?php echo isset($vidhan_sabha['year']) ? $vidhan_sabha['year'] : '2024'; ?></span></td>
                        <td><?php echo $vidhan_sabha['created_by_name']; ?></td>
                        <td><?php echo $vidhan_sabha['added_by_name']; ?></td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($vidhan_sabha['created_time'])); ?></td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($vidhan_sabha['updated_time'])); ?></td>
                        <td>
                            <a href="<?php echo site_url('vidhan_sabha/edit/'.$vidhan_sabha['id']); ?>"  class="btn btn-info"><i class="fa fa-pencil"></i></a>
                            <a href="<?php echo site_url('vidhan_sabha/delete/'.$vidhan_sabha['id']); ?>"  class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Vidhan Sabha?');"><i class="fa fa-trash"></i></a>
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
    $('#vidhanSabhaTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Vidhan Sabha List'
            }
        ],
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [
            [10, 25, 50, 75, -1],
            [10, 25, 50, 75, "All"]
        ],
        "columnDefs": [
            { "orderable": false, "targets": 8 } // Disable ordering on Actions column
        ]
    });
});
</script>
