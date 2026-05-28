<style>
    button.dt-button.buttons-excel.buttons-html5 {
    left: 100px !important;
}
</style>
<div class="content-wrapper">
    <section class="content-header"> 
      <h1>
        <i class="fa fa-user-circle-o" aria-hidden="true"></i> District Management
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">District List</h3>  
                    <a href="<?php echo site_url('district/create'); ?>"  class="btn btn-success"  style="float: right;">Add New District</a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="districtTable">
                    <thead>
                      <tr style="color:white;font-size:15px;background:#020254;"> 
                          <th>ID</th>
                          <th>Name</th>
                          <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($districts as $district): ?>
                    <tr>
                        <td><?php echo $district['id']; ?></td>
                        <td><?php echo $district['name']; ?></td>
                        <td>
                            <a href="<?php echo site_url('district/edit/'.$district['id']); ?>"  class="btn btn-info"><i class="fa fa-pencil"></i></a>
                            <a href="<?php echo site_url('district/delete/'.$district['id']); ?>"  class="btn btn-danger" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></a>
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
    $('#districtTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'District List'
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
