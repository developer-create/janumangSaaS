<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <style>
        
        table.dataTable thead>tr>th.sorting:after, table.dataTable thead>tr>th.sorting_asc:after, table.dataTable thead>tr>th.sorting_desc:after, table.dataTable thead>tr>th.sorting_asc_disabled:after, table.dataTable thead>tr>th.sorting_desc_disabled:after, table.dataTable thead>tr>td.sorting:after, table.dataTable thead>tr>td.sorting_asc:after, table.dataTable thead>tr>td.sorting_desc:after, table.dataTable thead>tr>td.sorting_asc_disabled:after, table.dataTable thead>tr>td.sorting_desc_disabled:after{

color:#000000 !important;
    opacity: 60 !important;
}

table.dataTable thead>tr>th.sorting:before, table.dataTable thead>tr>th.sorting_asc:before, table.dataTable thead>tr>th.sorting_desc:before, table.dataTable thead>tr>th.sorting_asc_disabled:before, table.dataTable thead>tr>th.sorting_desc_disabled:before, table.dataTable thead>tr>td.sorting:before, table.dataTable thead>tr>td.sorting_asc:before, table.dataTable thead>tr>td.sorting_desc:before, table.dataTable thead>tr>td.sorting_asc_disabled:before, table.dataTable thead>tr>td.sorting_desc_disabled:before{

color:#000000 !important;
    opacity: 60 !important;
}
    </style>
    <section class="content-header"> 
      <h1>
        <i class="fa fa-file-text" aria-hidden="true"></i> In Docs Management (जावक दस्तावेज़)
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
    <h3 class="box-title">In Docs List</h3>  
    <div style="float: right;">
        <a href="<?php echo site_url('indocs/create'); ?>" class="btn btn-success">
            <i class="fa fa-plus"></i> Add New In Doc
        </a>
    </div>
                </div>
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="inDocsTable">
                    <thead>
                      <tr style="color:white;font-size:15px;background-color:#020254;">
                        <th>Sr No</th>
                        <th>Unique ID</th>
                        <th>Issue No</th>
                        <th>Month/Date</th>
                        <th>Name & Address</th>
                        <th>Place</th>
                        <th>Subject</th>
                        <th>Documents Count</th>
                        <th>Reference Issue No</th>
                        <th>Received Issue No</th>
                        <th>File Head No</th>
                        <th>Stamp Received (₹)</th>
                        <th>Remarks</th>
                        <th>Added By</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($docs)): ?>
                      <?php foreach ($docs as $key => $doc): ?>
                        <tr>
                          <td><?php echo $key+1; ?></td>
                          <td><strong><?php echo isset($doc['unique_id']) ? $doc['unique_id'] : '-'; ?></strong></td>
                          <td><?php echo $doc['issue_no']; ?></td>
                          <td><?php echo date('d-m-Y', strtotime($doc['month_date'])); ?></td>
                          <td><?php echo substr($doc['name_address'], 0, 50) . (strlen($doc['name_address']) > 50 ? '...' : ''); ?></td>
                          <td><?php echo $doc['place']; ?></td>
                          <td><?php echo $doc['subject']; ?></td>
                          <td><?php echo $doc['documents_count']; ?></td>
                          <td><?php echo $doc['reference_issue_no']; ?></td>
                          <td><?php echo $doc['received_issue_no']; ?></td>
                          <td><?php echo $doc['file_head_no']; ?></td>
                          <td><?php echo $doc['stamp_received'] ? '₹' . number_format($doc['stamp_received'], 2) : '-'; ?></td>
                          <td><?php echo substr($doc['remarks'], 0, 30) . (strlen($doc['remarks']) > 30 ? '...' : ''); ?></td>
                          <td>
                            <?php
                              $uid = $doc['created_by'];
                              if ($uid) {
                                  $cc = $this->db->query("SELECT name FROM tbl_users WHERE userId='$uid'");
                                  $user = $cc->row();
                                  if ($user) {
                                      echo $user->name;
                                  }
                              }
                            ?>
                          </td>
                          <td>
                            <a href="<?php echo site_url('indocs/edit/'.$doc['id']); ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                            <a href="<?php echo site_url('indocs/delete/'.$doc['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr><td colspan="15" class="text-center">No records found</td></tr>
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
    var table = $('#inDocsTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'In Docs List'
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
