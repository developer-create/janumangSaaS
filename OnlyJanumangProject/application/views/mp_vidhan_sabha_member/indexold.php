<style>
    button.dt-button.buttons-excel.buttons-html5 {
    left: 100px !important;
}
</style>
<link rel="stylesheet" href="<?php echo base_url('assets/css/samiti-filters.css'); ?>">
<div class="content-wrapper">
    <section class="content-header"> 
      <h1>
        <i class="fa fa-users" aria-hidden="true"></i> MP Vidhan Sabha Member Management
      </h1>
    </section>
    <section class="content"> 
        <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">MP Vidhan Sabha Member List</h3>  
                    <div style="float: right;">
                        <a href="<?php echo site_url('mp_vidhan_sabha_member/bulk_upload'); ?>" class="btn btn-info" style="margin-right: 5px;">
                            <i class="fa fa-upload"></i> Bulk Upload
                        </a>
                        <a href="<?php echo site_url('mp_vidhan_sabha_member/create'); ?>" class="btn btn-success">
                            <i class="fa fa-plus"></i> Add New Member
                        </a>
                    </div>
                </div><!-- /.box-header -->
                
                <!-- Filters Section -->
                <div class="filter-section">
                    <form method="get" action="<?php echo site_url('mp_vidhan_sabha_member'); ?>" id="filterForm">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label for="filter_district">जिला (District)</label>
                                <select name="filter_district" id="filter_district">
                                    <option value="">-- All Districts --</option>
                                    <?php if (!empty($districts)): foreach ($districts as $dist): ?>
                                    <option value="<?php echo $dist['id']; ?>" <?php echo (isset($filter_district) && $filter_district == $dist['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($dist['name']); ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label for="filter_block">ब्लॉक (Block)</label>
                                <select name="filter_block" id="filter_block">
                                    <option value="">-- All Blocks --</option>
                                    <?php if (!empty($blocks)): foreach ($blocks as $blk): ?>
                                    <option value="<?php echo $blk['id']; ?>" <?php echo (isset($filter_block) && $filter_block == $blk['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($blk['name']); ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label for="filter_vidhan_sabha">विधान सभा (Vidhan Sabha)</label>
                                <select name="filter_vidhan_sabha" id="filter_vidhan_sabha">
                                    <option value="">-- All Vidhan Sabha --</option>
                                    <?php if (!empty($vidhan_sabhas)): foreach ($vidhan_sabhas as $vs): ?>
                                    <option value="<?php echo $vs['id']; ?>" <?php echo (isset($filter_vidhan_sabha) && $filter_vidhan_sabha == $vs['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($vs['vidhan_sabha_name']); ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label for="filter_month">महीना (Month)</label>
                                <select name="filter_month" id="filter_month">
                                    <option value="">-- All Months --</option>
                                    <option value="1" <?php echo (isset($filter_month) && $filter_month == '1') ? 'selected' : ''; ?>>January</option>
                                    <option value="2" <?php echo (isset($filter_month) && $filter_month == '2') ? 'selected' : ''; ?>>February</option>
                                    <option value="3" <?php echo (isset($filter_month) && $filter_month == '3') ? 'selected' : ''; ?>>March</option>
                                    <option value="4" <?php echo (isset($filter_month) && $filter_month == '4') ? 'selected' : ''; ?>>April</option>
                                    <option value="5" <?php echo (isset($filter_month) && $filter_month == '5') ? 'selected' : ''; ?>>May</option>
                                    <option value="6" <?php echo (isset($filter_month) && $filter_month == '6') ? 'selected' : ''; ?>>June</option>
                                    <option value="7" <?php echo (isset($filter_month) && $filter_month == '7') ? 'selected' : ''; ?>>July</option>
                                    <option value="8" <?php echo (isset($filter_month) && $filter_month == '8') ? 'selected' : ''; ?>>August</option>
                                    <option value="9" <?php echo (isset($filter_month) && $filter_month == '9') ? 'selected' : ''; ?>>September</option>
                                    <option value="10" <?php echo (isset($filter_month) && $filter_month == '10') ? 'selected' : ''; ?>>October</option>
                                    <option value="11" <?php echo (isset($filter_month) && $filter_month == '11') ? 'selected' : ''; ?>>November</option>
                                    <option value="12" <?php echo (isset($filter_month) && $filter_month == '12') ? 'selected' : ''; ?>>December</option>
                                </select>
                            </div>
                            
                            <div class="filter-group">
                                <label for="filter_year">वर्ष (Year)</label>
                                <select name="filter_year" id="filter_year">
                                    <option value="">-- All Years --</option>
                                    <?php for ($y = 2020; $y <= 2030; $y++): ?>
                                    <option value="<?php echo $y; ?>" <?php echo (isset($filter_year) && $filter_year == $y) ? 'selected' : ''; ?>><?php echo $y; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            
                            <div class="filter-buttons">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                                <a href="<?php echo site_url('mp_vidhan_sabha_member'); ?>" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover" id="memberTable">
                    <thead>
                      <tr style="color:white;font-size:15px;background:#020254;"> 
                          <th>ID</th>
                          <th>Month</th>
                          <th>Date</th>
                          <th>Name</th>
                          <th>Position</th>
                          <th>Mobile No</th>
                          <th>District</th>
                          <th>Block</th>
                          <th>Panchayat</th>
                          <th>Village</th>
                          <th>Vidhan Sabha</th>
                          <th>BG</th>
                          <th>BC</th>
                          <th>ER</th>
                          <th>BR</th>
                          <th>IP</th>
                          <th>SC</th>
                          <th>SA</th>
                          <th>YC</th>
                          <th>AP</th>
                          <th>FP</th>
                          <th>PP</th>
                          <th>WC</th>
                          <th>PA</th>
                          <th>PC</th>
                          <th>AK</th>
                          <th>FM</th>
                          <th>ZP</th>
                          <th>VP</th>
                          <th>SR</th>
                          <th>IN</th>
                          <th>EO</th>
                          <th>GS</th>
                          <th>US</th>
                          <th>PW</th>
                          <th>NL</th>
                          <th>FR</th>
                          <th>SO</th>
                          <th>ST</th>
                          <th>OB</th>
                          <th>SMW</th>
                          <th>SMTW</th>
                          <th>IT</th>
                          <th>TEST</th>
                          <th>DYC</th>
                          <th>DCC</th>
                          <th>OBC</th>
                          <th>CELL</th>
                          <th>MP</th>
                          <th>DT</th>
                          <th>DP</th>
                          <th>AVP</th>
                          <th>MEET</th>
                          <th>MEDIA</th>
                          <th>MLA,X MLA</th>
                          <th>VECH</th>
                          <th>IT CELL EXP</th>
                          <th>INFO</th>
                          <th>NSUI</th>
                          <th>IMP</th>
                          <th>ADVISE</th>
                          <th>REF</th>
                          <th>Remark</th>
                          <th>Created By</th>
                          <th>Created Time</th>
                          <th>Year</th>
                          <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?php echo $member['id']; ?></td>
                        <td><?php echo !empty($member['month']) ? htmlspecialchars($member['month']) : '-'; ?></td>
                        <td><?php echo !empty($member['date']) ? htmlspecialchars($member['date']) : '-'; ?></td>
                        <td><?php echo htmlspecialchars($member['name']); ?></td>
                        <td><?php echo htmlspecialchars($member['position']); ?></td>
                        <td><?php echo htmlspecialchars($member['mobile_no']); ?></td>
                        <td><?php echo isset($member['district_name']) && $member['district_name'] ? htmlspecialchars($member['district_name']) : '-'; ?></td>
                        <td><?php echo isset($member['block_name']) && $member['block_name'] ? htmlspecialchars($member['block_name']) : '-'; ?></td>
                        <td><?php echo isset($member['panchayat_name']) && $member['panchayat_name'] ? htmlspecialchars($member['panchayat_name']) : '-'; ?></td>
                        <td><?php echo isset($member['village_name']) && $member['village_name'] ? htmlspecialchars($member['village_name']) : '-'; ?></td>
                        <td><?php echo isset($member['vidhan_sabha_name']) && $member['vidhan_sabha_name'] ? htmlspecialchars($member['vidhan_sabha_name']) : '-'; ?></td>
                        <td><?php echo isset($member['bg']) && $member['bg'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['bc']) && $member['bc'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['er']) && $member['er'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['br']) && $member['br'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['ip']) && $member['ip'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['sc']) && $member['sc'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['sa']) && $member['sa'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['yc']) && $member['yc'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['ap']) && $member['ap'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['fp']) && $member['fp'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['pp']) && $member['pp'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['wc']) && $member['wc'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['pa']) && $member['pa'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['pc']) && $member['pc'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['ak']) && $member['ak'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['fm']) && $member['fm'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['zp']) && $member['zp'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['vp']) && $member['vp'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['sr']) && $member['sr'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['in_field']) && $member['in_field'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['eo']) && $member['eo'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['gs']) && $member['gs'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['us']) && $member['us'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['pw']) && $member['pw'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['nl']) && $member['nl'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['fr']) && $member['fr'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['so']) && $member['so'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['st']) && $member['st'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['ob']) && $member['ob'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['smw']) && $member['smw'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['smtw']) && $member['smtw'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['it']) && $member['it'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['test']) && $member['test'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['dyc']) && $member['dyc'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['dcc']) && $member['dcc'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['obc']) && $member['obc'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['cell']) && $member['cell'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['mp']) && $member['mp'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['dt']) && $member['dt'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['dp']) && $member['dp'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['avp']) && $member['avp'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['meet']) && $member['meet'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['media']) && $member['media'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['mla_x_mla']) && $member['mla_x_mla'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['vech']) && $member['vech'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['it_cell_exp']) && $member['it_cell_exp'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['info']) && $member['info'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['nsui']) && $member['nsui'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['imp']) && $member['imp'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['advise']) && $member['advise'] ? '✓' : '-'; ?></td>
                        <td><?php echo isset($member['ref']) && $member['ref'] ? '✓' : '-'; ?></td>
                        <td><?php echo !empty($member['remark']) ? htmlspecialchars($member['remark']) : '-'; ?></td>
                        <td><?php echo $member['created_by_name']; ?></td>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($member['created_time'])); ?></td>
                        <td><?php echo isset($member['date']) && $member['date'] ? date('Y', strtotime($member['date'])) : '-'; ?></td>
                        <td>
                            <a href="<?php echo site_url('mp_vidhan_sabha_member/edit/'.$member['id']); ?>"  class="btn btn-info"><i class="fa fa-pencil"></i></a>
                            <a href="<?php echo site_url('mp_vidhan_sabha_member/delete/'.$member['id']); ?>"  class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this Member?');"><i class="fa fa-trash"></i></a>
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
    $('#memberTable').DataTable({
        "processing": true,
        "serverSide": false,
        "dom": '<"top"lfB>rt<"bottom"ip>',
        "buttons": [
            {
                extend: 'excelHtml5',
                text: 'Export Excel',
                title: 'MP Vidhan Sabha Member List'
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
            { "orderable": false, "targets": 63 }
        ],
        "scrollX": true
    });
});
</script>
