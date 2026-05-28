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
        <i class="fa fa-inbox" aria-hidden="true"></i> Inward Register (जावक पंजी)
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
    <h3 class="box-title">Inward Register List</h3>  
    <div style="float: right;">
        <a href="<?php echo site_url('inwardregister/create'); ?>" class="btn btn-success">
            <i class="fa fa-plus"></i> Add New Register
        </a>
    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="inwardRegisterTable">
                    <thead>
                      <tr style="color:white;font-size:15px;background-color:#020254;">
                        <th>Sr No</th>
                        <th>Unique ID</th>
                        <th>Issue No</th>
                        <th>Issue Date</th>
                        <th>Letter Name</th>
                        <th>Letter Received Date</th>
                        <th>From Whom Received</th>
                        <th>Letter Description</th>
                        <th>Reply To Number</th>
                        <th>Our Reply Number</th>
                        <th>Forwarded Letter No</th>
                        <th>Subject</th>
                        <th>File Number</th>
                        <th>Section</th>
                        <th>Sent To</th>
                        <th>Remarks</th>
                        <th>Added By</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($registers)): ?>
                      <?php foreach ($registers as $key => $register): ?>
                        <tr>
                          <td><?php echo $key+1; ?></td>
                          <td><strong><?php echo isset($register['unique_id']) ? $register['unique_id'] : '-'; ?></strong></td>
                          <td><?php echo $register['issue_no']; ?></td>
                          <td><?php echo date('d-m-Y', strtotime($register['issue_date'])); ?></td>
                          <td><?php echo substr($register['letter_name'], 0, 40) . (strlen($register['letter_name']) > 40 ? '...' : ''); ?></td>
                          <td><?php echo date('d-m-Y', strtotime($register['letter_received_date'])); ?></td>
                          <td><?php echo substr($register['from_whom_received'], 0, 30) . (strlen($register['from_whom_received']) > 30 ? '...' : ''); ?></td>
                          <td><?php echo substr($register['received_letter_description'], 0, 30) . (strlen($register['received_letter_description']) > 30 ? '...' : ''); ?></td>
                          <td><?php echo $register['reply_to_number'] ? $register['reply_to_number'] : '-'; ?></td>
                          <td><?php echo $register['our_reply_number'] ? $register['our_reply_number'] : '-'; ?></td>
                          <td><?php echo $register['forwarded_letter_number'] ? $register['forwarded_letter_number'] : '-'; ?></td>
                          <td><?php echo substr($register['subject'], 0, 30) . (strlen($register['subject']) > 30 ? '...' : ''); ?></td>
                          <td><?php echo $register['file_number'] ? $register['file_number'] : '-'; ?></td>
                          <td><?php echo $register['section'] ? $register['section'] : '-'; ?></td>
                          <td><?php echo $register['sent_to'] ? $register['sent_to'] : '-'; ?></td>
                          <td><?php echo substr($register['remarks'] ? $register['remarks'] : '', 0, 20); ?></td>
                          <td>
                            <?php
                              $uid = $register['created_by'];
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
                            <a href="<?php echo site_url('inwardregister/edit/'.$register['id']); ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>
                            <a href="<?php echo site_url('inwardregister/delete/'.$register['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr><td colspan="18" class="text-center">No records found</td></tr>
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
    var table = $('#inwardRegisterTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'Inward Register List'
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
