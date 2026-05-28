<div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header"> 
      <h1>
        <i class="fa fa-briefcase" aria-hidden="true"></i> Subtype Of Work Management
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Subtype Of Work List</h3>  
                    <a href="<?php echo site_url('subtypeofwork/create'); ?>"  class="btn btn-success"  style="float: right;">Add New Subtype Of Work</a>

                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="subtypeOfWorkTable">
                    <thead>
                      <tr style="color:white;font-size:15px;background-color:#020254;"> 
            <th>ID</th>
            <th>Type Of Work</th>
            <th>Sub Type Of Work</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($subtype_of_works as $subtype): ?> 
        <tr>
            <td><?php echo $subtype['id']; ?></td>
            <td><?php echo !empty($subtype['work_type_name']) ? $subtype['work_type_name'] : 'N/A'; ?></td>
            <td><?php echo $subtype['name']; ?></td>
            <td>
                <a href="<?php echo site_url('subtypeofwork/edit/'.$subtype['id']); ?>"  class="btn btn-info"><i class="fa fa-pencil"></i></a>
                <a href="<?php echo site_url('subtypeofwork/delete/'.$subtype['id']); ?>"  class="btn btn-danger" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></a>
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
    $('#subtypeOfWorkTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Subtype Of Work List'
            }
        ],
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]]
    });
});
</script>

